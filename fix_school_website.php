<?php
use App\Models\School;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;

try {
    $school = School::find(1);
    if (!$school) {
        echo "School ID 1 not found. Picking first available.\n";
        $school = School::first();
    }

    if ($school) {
        echo "Processing School: " . $school->name . " (ID: " . $school->id . ")\n";

        // Fix 1: Domain and Status
        $school->domain = 'school1.localhost';
        $school->status = 1;
        $school->save();
        echo "[OK] Updated Domain to 'school1.localhost' and Status to 1.\n";

        // Fix 2: Subscription
        $subscriptionService = app(SubscriptionService::class);
        $subscription = $subscriptionService->active_subscription($school->id);

        if (!$subscription) {
            echo "No active subscription found.\n";
            $package = Package::first();
            if ($package) {
                echo "Assigning Package: " . $package->name . "\n";
                // Create subscription manually to avoid complex service dependencies if any
                $subscription = new Subscription();
                $subscription->school_id = $school->id;
                $subscription->package_id = $package->id;
                $subscription->name = $package->name;
                $subscription->student_charge = $package->student_charge;
                $subscription->staff_charge = $package->staff_charge;
                $subscription->start_date = Carbon::now();
                $subscription->end_date = Carbon::now()->addDays($package->days);
                $subscription->billing_cycle = $package->days;
                $subscription->status = 1;
                $subscription->save();
                echo "[OK] Created new Subscription.\n";
            } else {
                echo "[ERROR] No Packages found in DB to assign.\n";
            }
        } else {
            echo "[OK] Active Subscription found (ID: " . $subscription->id . ")\n";
        }

        // Fix 3: Feature
        $feature = Feature::where('name', 'Website Management')->first();
        if ($feature) {
            echo "Website Management Feature ID: " . $feature->id . "\n";

            // Ensure the package has this feature
            if ($subscription) {
                $package = Package::find($subscription->package_id);
                if ($package) {
                    $exists = $package->package_feature()->where('feature_id', $feature->id)->exists();
                    if (!$exists) {
                        $package->package_feature()->create(['feature_id' => $feature->id]);
                        echo "[OK] Added 'Website Management' feature to Package " . $package->name . ".\n";
                    } else {
                        echo "[OK] Package already has 'Website Management' feature.\n";
                    }
                }
            }
        } else {
            echo "[ERROR] 'Website Management' feature not found in `features` table. Please run migrations.\n";
        }

    } else {
        echo "[ERROR] No schools found in database.\n";
    }
} catch (\Exception $e) {
    echo "[EXCEPTION] " . $e->getMessage() . "\n";
}
