<?php
use App\Models\PaymentTransaction;
use App\Models\SubscriptionBill;
use App\Models\AddonSubscription;

echo "Backfilling subscriptions...\n";
$subTxIds = SubscriptionBill::whereNotNull('payment_transaction_id')->pluck('payment_transaction_id');
PaymentTransaction::whereIn('id', $subTxIds)->update(['type' => 'subscription']);

echo "Backfilling addons...\n";
$addonTxIds = AddonSubscription::whereNotNull('payment_transaction_id')->pluck('payment_transaction_id');
PaymentTransaction::whereIn('id', $addonTxIds)->update(['type' => 'addon']);

echo "Backfilling legacy...\n";
PaymentTransaction::whereNull('type')->update(['type' => 'subscription']);

echo "Done!\n";
