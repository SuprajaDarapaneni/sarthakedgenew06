
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Force the school connection and check features directly
$school_db = 'sarthake_3'; // Assuming this is correct from before
\App\Services\CachingService::setSchoolDatabaseConnection($school_db);

$features = \App\Models\SubscriptionFeature::where('school_id', 3)->get();
echo "Features for School ID 3:\n";
foreach ($features as $f) {
    if (strpos(strtolower($f->name), 'attendance') !== false) {
        echo "- " . $f->name . "\n";
    }
}

// Check what getFeatureAccess() would do for Attendance Management
$featureName = 'Attendance Management';
$feature = \App\Models\SubscriptionFeature::where('name', $featureName)
    ->where('school_id', 3)
    ->first();
if ($feature) {
    echo "Feature 'Attendance Management' EXISTS in DB. ID: " . $feature->id . "\n";
} else {
    echo "Feature 'Attendance Management' DOES NOT EXIST in DB.\n";
}

// Check features system helper
if (function_exists('hasFeatureAccess')) {
    echo "hasFeatureAccess('Attendance Management') = " . (hasFeatureAccess('Attendance Management') ? 'YES' : 'NO') . "\n";
}
