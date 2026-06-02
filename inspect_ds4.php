
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// simulate login
$user = App\Models\User::where('email', 'ds@gmail.com')->first();
Auth::login($user);
$school = \App\Models\School::find($user->school_id);
\App\Services\CachingService::setSchoolDatabaseConnection($school->database_name);

// Check if feature access works
$features = app(\App\Services\CachingService::class)->getSchoolFeatures();
echo "School features: " . implode(', ', $features) . "\n";

$has_access = in_array('Attendance Management', $features);
echo "Has Attendance Management? " . ($has_access ? 'YES' : 'NO') . "\n";
