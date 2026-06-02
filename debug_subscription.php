<?php
try {
    echo "SUB START\n";
    $s = \App\Models\School::find(1);

    // Logic from SubscriptionService usually checks end_date
    $sub = \App\Models\Subscription::where('school_id', $s->id)
        ->whereDate('end_date', '>=', \Carbon\Carbon::now())
        ->orderBy('end_date', 'desc')
        ->first();

    if (!$sub) {
        echo "No Active Subscription. Creating...\n";
        $p = \App\Models\Package::first();
        if (!$p) {
            // Create a dummy package if none
            $p = new \App\Models\Package();
            $p->name = "Pro";
            $p->days = 365;
            $p->student_charge = 0;
            $p->staff_charge = 0;
            $p->status = 1;
            $p->save();
            echo "Created Dummy Package.\n";
        }

        $sub = new \App\Models\Subscription();
        $sub->school_id = $s->id;
        $sub->package_id = $p->id;
        $sub->name = $p->name;
        $sub->student_charge = 0;
        $sub->staff_charge = 0;
        $sub->start_date = date('Y-m-d');
        $sub->end_date = date('Y-m-d', strtotime('+365 days'));
        $sub->billing_cycle = 365;
        // $sub->status = 1; // Column doesn't exist
        $sub->save();
        echo "Subscription Created (ID: $sub->id).\n";
    } else {
        echo "Subscription ID: " . $sub->id . " exists (Ends: " . $sub->end_date . ").\n";
    }

    $fname = 'Website Management';
    $feat = \App\Models\Feature::where('name', $fname)->first();
    if (!$feat)
        throw new Exception("Feature $fname not found!");

    echo "Feature ID: " . $feat->id . "\n";

    // 1. Ensure Package has Feature
    $pkg = \App\Models\Package::find($sub->package_id);
    if ($pkg) {
        $has = $pkg->package_feature()->where('feature_id', $feat->id)->exists();

        if (!$has) {
            $pkg->package_feature()->create(['feature_id' => $feat->id]);
            echo "Feature linked to Package.\n";
        } else {
            echo "Feature already linked to Package.\n";
        }
    }

    // 2. Ensure Subscription has Feature (IMPORTANT for Controller logic)
    // Controller calls: active_subscription($id)->subscription_feature...
    // SubscriptionService creates SubscriptionFeature rows when creating subscription.
    // Since we manually created/checked, we must ensure rows exist.

    $existsSubFeat = \App\Models\SubscriptionFeature::where('subscription_id', $sub->id)->where('feature_id', $feat->id)->exists();
    if (!$existsSubFeat) {
        $sf = new \App\Models\SubscriptionFeature();
        $sf->subscription_id = $sub->id;
        $sf->feature_id = $feat->id;
        $sf->save();
        echo "SubscriptionFeature linked.\n";
    } else {
        echo "SubscriptionFeature already linked.\n";
    }

    // Clear Cache
    // app(App\Services\CachingService::class)->removeSchoolCache($s->id);
    // echo "Cache cleaned.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
