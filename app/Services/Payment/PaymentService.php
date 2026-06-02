<?php

namespace App\Services\Payment;

use App\Models\PaymentConfiguration;
use App\Repositories\PaymentConfiguration\PaymentConfigurationInterface;
use Dompdf\Exception;
use InvalidArgumentException;

class PaymentService {
    /**
     * @param string $paymentGateway - Stripe
     * @param null $schoolID - IF School id is null then Super Admin's Payment Gateway Credentials will be used
     * @return StripePayment
     * @throws Exception
     */
    public static function create(string $paymentGateway, $schoolID = null) {
        $paymentGateway = strtolower($paymentGateway);
        //IF School ID is not empty then find the details in PaymentConfiguration Model
        if (!empty($schoolID)) {
            $payment = app(PaymentConfigurationInterface::class)->builder()->where('status', 1)->whereRaw('LOWER(payment_method) = ?', [$paymentGateway])->first();
            if (empty($payment)) {
                throw new Exception("Payment gateway is not enabled");
            }
        } else {
            // Force central database connection and bypass any potential scoping
            $payment = PaymentConfiguration::on('mysql')->whereNull('school_id')->where('status', 1)->whereRaw('LOWER(payment_method) = ?', [$paymentGateway])->first();
            
            if (!$payment) {
                // Final fallback using raw query to ensure we bypass ALL Eloquent scoping/interference
                $rawResults = \DB::connection('mysql')->select("SELECT * FROM payment_configurations WHERE school_id IS NULL AND status = 1 AND LOWER(payment_method) = ?", [$paymentGateway]);
                if (!empty($rawResults)) {
                    $payment = $rawResults[0];
                }
            }

            if (empty($payment)) {
                throw new Exception("Payment gateway is not enabled for Super Admin");
            }
        }
        return match ($paymentGateway) {
            'stripe' => new StripePayment($payment->secret_key, $payment->currency_code),
            'razorpay' => new RazorpayPayment($payment->secret_key, $payment->api_key, $payment->currency_code),
            'flutterwave' => new FlutterwavePayment($payment->secret_key, $payment->api_key, $payment->currency_code),
            'paystack' => new PaystackPayment($payment->secret_key, $payment->api_key, $payment->currency_code),
            'ccavenue' => new CcavenuePayment($payment->secret_key, $payment->api_key, $payment->merchant_id ?? null, $payment->currency_code),

            // any other payment processor implementations
            default => throw new InvalidArgumentException('Invalid Payment Gateway.'),
        };
    }

    /***
     * @param string $paymentGateway
     * @param $paymentIntentData
     * @return array
     * Stripe Payment Intent : https://stripe.com/docs/api/payment_intents/object
     */
    public static function formatPaymentIntent(string $paymentGateway, $paymentIntentData) {
        $paymentGateway = strtolower($paymentGateway);
        //IF School ID is not empty then find the details in PaymentConfiguration Model
        return match ($paymentGateway) {
            'stripe' => [
                'id'              => $paymentIntentData['id'],
                'amount'          => $paymentIntentData['amount'],
                'amount_received' => $paymentIntentData['amount_received'],
                'currency'        => $paymentIntentData['currency'],
                'metadata'        => $paymentIntentData['metadata'],
                'status'          => match ($paymentIntentData['status']) {
                    "canceled" => "failed",
                    "succeeded" => "succeed",
                    "processing", "requires_action", "requires_capture", "requires_confirmation", "requires_payment_method" => "pending",
                },
                'actual_status'   => $paymentIntentData['status']
            ],
            // any other payment processor implementations
            default => $paymentIntentData,
        };
    }
}