<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SubscriptionService;
use App\Models\Subscription;
use Carbon\Carbon;

$schoolID = 2;
$subscriptionService = app(SubscriptionService::class);
$active = $subscriptionService->active_subscription($schoolID);

if ($active) {
    echo "Active Subscription ID: {$active->id}, Package Type: {$active->package_type}\n";
    echo "Features Count: " . $active->subscription_feature->count() . "\n";
} else {
    echo "NO ACTIVE SUBSCRIPTION FOUND!\n";
    // Check all subscriptions for this school
    $subs = Subscription::where('school_id', $schoolID)->get();
    echo "Total subscriptions found: " . $subs->count() . "\n";
    foreach ($subs as $s) {
        $today = Carbon::now()->format('Y-m-d');
        echo "ID: {$s->id}, Start: {$s->start_date}, End: {$s->end_date}, Type: {$s->package_type}, Today: {$today}\n";
    }
}
