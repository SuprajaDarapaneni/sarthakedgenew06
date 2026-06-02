<?php

namespace App\Http\Controllers;

use App\Models\PaymentConfiguration;
use App\Models\PaymentTransaction;
use App\Models\School;
use App\Services\Payment\CcavenuePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\SubscriptionService;
use App\Repositories\SubscriptionBill\SubscriptionBillInterface;
use App\Repositories\SubscriptionFeature\SubscriptionFeatureInterface;
use App\Repositories\PaymentTransaction\PaymentTransactionInterface;
use App\Repositories\Subscription\SubscriptionInterface;
use App\Models\SubscriptionBill as SubscriptionBillModel;
use App\Models\Fee;
use App\Models\FeesPaid;
use App\Models\CompulsoryFee;
use App\Models\OptionalFee;
use App\Models\FeesAdvance;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class CcavenueController extends Controller {
    
    /**
     * Handle the response callback from CCAvenue
     */
    public function handleResponse(Request $request) {
        $encResponse = $request->encResp;
        
        // Always check system settings first for CCAvenue credentials
        DB::setDefaultConnection('mysql');
        $paymentConfig = PaymentConfiguration::where('status', 1)->whereRaw('LOWER(payment_method) = ?', ['ccavenue'])->whereNull('school_id')->first();
        
        if (!$paymentConfig) {
            return redirect()->route('home')->with('error', 'CCAvenue configuration not found.');
        }

        $ccavenue = new CcavenuePayment(
            $paymentConfig->secret_key, 
            $paymentConfig->api_key, 
            $paymentConfig->merchant_id, 
            $paymentConfig->currency_code
        );

        $decryptValues = $ccavenue->decrypt($encResponse, $paymentConfig->secret_key);
        $dataSize = explode('&', $decryptValues);
        $response = [];
        for ($i = 0; $i < count($dataSize); $i++) {
            $information = explode('=', $dataSize[$i]);
            if (count($information) == 2) {
                $response[$information[0]] = $information[1];
            }
        }

        Log::info('CCAvenue Response:', $response);

        $orderId = $response['order_id'] ?? null;
        $orderStatus = $response['order_status'] ?? 'Failure';
        
        $paymentTransactionId = $response['merchant_param1'] ?? null;
        $schoolId = $response['merchant_param2'] ?? null;
        $transactionType = $response['merchant_param3'] ?? null;

        if ($orderStatus === 'Success') {
            DB::beginTransaction();
            try {
                $paymentTransactionRepo = app(\App\Repositories\PaymentTransaction\PaymentTransactionInterface::class);
                $paymentTransaction = $paymentTransactionRepo->findById($paymentTransactionId);
                
                if (!$paymentTransaction) {
                    throw new Exception('Transaction not found');
                }

                $paymentTransactionRepo->update($paymentTransaction->id, [
                    'payment_status' => 'succeed',
                    'payment_id' => $response['tracking_id'], // CCAvenue tracking ID
                    'order_id' => $response['bank_ref_no'] ?? $orderId,
                ]);

                $metadata = [];
                if ($paymentTransaction->payment_signature) {
                    $metadata = json_decode($paymentTransaction->payment_signature, true);
                }

                if ($transactionType == 'subscription') {
                    $subscriptionService = app(SubscriptionService::class);
                    $subscriptionBillRepo = app(\App\Repositories\SubscriptionBill\SubscriptionBillInterface::class);
                    
                    $packageId = $metadata['package_id'] ?? null;
                    $type = $metadata['type'] ?? null;
                    $subscriptionId = $metadata['subscription_id'] ?? null;
                    $isCurrentPlan = $metadata['isCurrentPlan'] ?? null;
                    $subscriptionBillId = $metadata['subscriptionBill_id'] ?? null;

                    $billId = '';
                    if ($packageId) {
                        if ($type == 'upcoming') {
                            $subscription = $subscriptionService->createSubscription($packageId, NULL, $subscriptionId);
                        } elseif ($type == 'immediate') {
                            $subscription = $subscriptionService->createSubscription($packageId, null, null, 1);
                        } else {
                            $subscription = $subscriptionService->createSubscription($packageId);
                        }
                        
                        // Handle subscription features and bill generation (logic from SubscriptionService)
                        // ... (The createSubscription method usually handles most of this)
                        $billId = $subscription->subscription_bill->id ?? null;
                    } else if ($subscriptionBillId) {
                        $billId = $subscriptionBillId;
                    }

                    if ($billId) {
                        $subscriptionBillRepo->update($billId, ['payment_transaction_id' => $paymentTransaction->id]);
                    }
                } else if ($transactionType == 'addon') {
                    $addonSubscriptionId = $metadata['addon_subscription_id'] ?? null;
                    $addonSubscriptionRepo = app(\App\Repositories\AddonSubscription\AddonSubscriptionInterface::class);
                    $addonSubscriptionRepo->update($addonSubscriptionId, ['payment_transaction_id' => $paymentTransaction->id, 'status' => 1]);
                } else if ($transactionType == 'fees') {
                    // Switch to school connection for fees processing
                    if ($schoolId) {
                        $school = \App\Models\School::find($schoolId);
                        if ($school) {
                            \App\Helpers\DatabaseHelper::setDatabaseConnection($school);
                        }
                    }
                    $this->processFeesPayment($response);
                }

                DB::commit();
                
                if ($transactionType == 'fees') {
                    return view('payment.ccavenue_success');
                }
                return redirect()->route('subscriptions.history')->with('success', 'Payment successful.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('CCAvenue Callback processing error: ' . $e->getMessage());
                if ($transactionType == 'fees') {
                    return view('payment.ccavenue_error');
                }
                return redirect()->route('subscriptions.history')->with('error', 'Error processing payment.');
            }
        } else {
            if ($transactionType == 'fees') {
                return view('payment.ccavenue_error');
            }
            return redirect()->route('subscriptions.history')->with('error', 'Payment failed or cancelled.');
        }
    }

    private function processFeesPayment($response) {
        $transactionId = $response['merchant_param1'];
        $schoolId = $response['merchant_param2'];
        
        $school = School::on('mysql')->where('id', $schoolId)->first();
        Config::set('database.connections.school.database', $school->database_name);
        DB::purge('school');
        DB::connection('school')->reconnect();
        DB::setDefaultConnection('school');

        $paymentTransaction = \App\Models\PaymentTransaction::on('mysql')->find($transactionId);
        if (!$paymentTransaction) {
            throw new \Exception('Payment transaction not found');
        }

        $metadata = json_decode($paymentTransaction->payment_signature, true);
        if (!$metadata) {
            throw new \Exception('Payment metadata not found');
        }

        $fees = Fee::where('id', $metadata['fees_id'])->with(['fees_class_type', 'fees_class_type.fees_type'])->firstOrFail();
        $current_date = date('Y-m-d');

        // Get or create fees_paid record
        $feesPaidDB = FeesPaid::where([
            'fees_id' => $metadata['fees_id'],
            'student_id' => $metadata['student_id'],
            'school_id' => $metadata['school_id']
        ])->first();

        $totalAmount = !empty($feesPaidDB) ? $feesPaidDB->amount + $paymentTransaction->amount : $paymentTransaction->amount;

        $feesPaidData = array(
            'amount' => $totalAmount,
            'date' => $current_date,
            "school_id" => $metadata['school_id'],
            'fees_id' => $metadata['fees_id'],
            'student_id' => $metadata['student_id'],
            'is_fully_paid' => $totalAmount >= $fees->total_compulsory_fees,
            'is_used_installment' => !empty($metadata['installment_details'])
        );

        $feesPaidResult = FeesPaid::updateOrCreate(
            ['id' => $feesPaidDB->id ?? null],
            $feesPaidData
        );

        if ($metadata['fees_type'] == "compulsory") {
            $installments = $metadata['installment_details'];
            if (!empty($installments)) {
                foreach ($installments as $installment) {
                    CompulsoryFee::create([
                        'student_id' => $metadata['student_id'],
                        'payment_transaction_id' => $paymentTransaction->id,
                        'type' => 'Installment Payment',
                        'installment_id' => $installment['id'],
                        'mode' => 'Online',
                        'amount' => $installment['amount'],
                        'due_charges' => $installment['dueChargesAmount'],
                        'fees_paid_id' => $feesPaidResult->id,
                        'status' => "Success",
                        'date' => $current_date,
                        'school_id' => $metadata['school_id'],
                    ]);
                }
            } else {
                CompulsoryFee::create([
                    'student_id' => $metadata['student_id'],
                    'payment_transaction_id' => $paymentTransaction->id,
                    'type' => 'Full Payment',
                    'mode' => 'Online',
                    'amount' => $paymentTransaction->amount,
                    'due_charges' => $metadata['dueChargesAmount'] ?? 0,
                    'fees_paid_id' => $feesPaidResult->id,
                    'status' => "Success",
                    'date' => $current_date,
                    'school_id' => $metadata['school_id'],
                ]);
            }

            if (!empty($metadata['advance_amount']) && $metadata['advance_amount'] > 0) {
                $updateCompulsoryFees = CompulsoryFee::where('student_id', $metadata['student_id'])
                    ->whereHas('fees_paid', function ($q) use ($metadata) {
                        $q->where('fees_id', $metadata['fees_id']);
                    })
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($updateCompulsoryFees) {
                    $updateCompulsoryFees->amount += $metadata['advance_amount'];
                    $updateCompulsoryFees->save();

                    FeesAdvance::create([
                        'compulsory_fee_id' => $updateCompulsoryFees->id,
                        'student_id' => $metadata['student_id'],
                        'parent_id' => $metadata['parent_id'],
                        'amount' => $metadata['advance_amount']
                    ]);
                }
            }
        } else if ($metadata['fees_type'] == "optional") {
            $optionalFees = $metadata['optional_fees_id'];
            foreach ($optionalFees as $optionalFee) {
                OptionalFee::create([
                    'student_id' => $metadata['student_id'],
                    'class_id' => $metadata['class_id'],
                    'payment_transaction_id' => $paymentTransaction->id,
                    'fees_class_id' => $optionalFee['id'],
                    'amount' => $optionalFee['amount'],
                    'fees_paid_id' => $feesPaidResult->id,
                    'status' => "Success",
                    'date' => $current_date,
                    'school_id' => $metadata['school_id'],
                ]);
            }
        }

        // Send success notification
        $user = User::where('id', $metadata['parent_id'])->first();
        if ($user) {
            $body = 'Amount :- ' . $paymentTransaction->amount;
            send_notification([$user->id], 'Fees Payment Successful', $body, 'payment', ['is_payment_success' => "true"]);
        }
    }

    /**
     * API for Android App to get encrypted request
     */
    public function getEncryptedRequest(Request $request) {
        $request->validate([
            'amount' => 'required|numeric',
            'order_id' => 'required',
            'school_id' => 'required'
        ]);

        $school = School::on('mysql')->where('id', $request->school_id)->first();
        if (!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        Config::set('database.connections.school.database', $school->database_name);
        DB::purge('school');
        
        $paymentConfig = PaymentConfiguration::on('school')->where('status', 1)->whereRaw('LOWER(payment_method) = ?', ['ccavenue'])->first();
        if (!$paymentConfig) {
            return response()->json(['error' => 'CCAvenue not configured'], 404);
        }

        $ccavenue = new CcavenuePayment(
            $paymentConfig->secret_key, 
            $paymentConfig->api_key, 
            $paymentConfig->merchant_id, 
            $paymentConfig->currency_code
        );

        $customMetaData = $request->all();
        // Add redirect and cancel URLs
        $customMetaData['redirect_url'] = route('ccavenue.callback', ['school_id' => $request->school_id]);
        $customMetaData['cancel_url'] = route('ccavenue.callback', ['school_id' => $request->school_id]);

        $payload = $ccavenue->createPaymentIntent($request->amount, $customMetaData);

        return response()->json([
            'success' => true,
            'data' => $payload
        ]);
    }

    public function webviewPayment(Request $request, $transactionId) {
        if ($request->has('school_id')) {
            $schoolId = $request->school_id;
            $school = \App\Models\School::on('mysql')->findOrFail($schoolId);
            \Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
            \Illuminate\Support\Facades\DB::purge('school');
            \Illuminate\Support\Facades\DB::setDefaultConnection('school');
            $paymentTransaction = \App\Models\PaymentTransaction::on('school')->findOrFail($transactionId);
        } else {
            $paymentTransaction = \App\Models\PaymentTransaction::on('mysql')->findOrFail($transactionId);
            $schoolId = $paymentTransaction->school_id;
            $school = \App\Models\School::on('mysql')->findOrFail($schoolId);
            \Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
            \Illuminate\Support\Facades\DB::purge('school');
            \Illuminate\Support\Facades\DB::setDefaultConnection('school');
        }

        $paymentConfig = \App\Models\PaymentConfiguration::on('school')->where('status', 1)->whereRaw('LOWER(payment_method) = ?', ['ccavenue'])->first();
        if (!$paymentConfig) {
            return "CCAvenue not configured";
        }

        $ccavenue = new \App\Services\Payment\CcavenuePayment(
            $paymentConfig->secret_key, 
            $paymentConfig->api_key, 
            $paymentConfig->merchant_id, 
            $paymentConfig->currency_code
        );

        $metadata = json_decode($paymentTransaction->payment_signature, true);
        $metadata['redirect_url'] = route('ccavenue.callback', ['school_id' => $schoolId]);
        $metadata['cancel_url'] = route('ccavenue.callback', ['school_id' => $schoolId]);
        $metadata['merchant_param1'] = $paymentTransaction->id;
        $metadata['merchant_param2'] = $schoolId;
        $metadata['merchant_param3'] = "fees";
        
        $payload = $ccavenue->createPaymentIntent($paymentTransaction->amount, $metadata);

        return view('payment.ccavenue_webview', [
            'url' => $payload['url'],
            'encRequest' => $payload['encRequest'],
            'access_code' => $payload['access_code']
        ]);
    }
}
