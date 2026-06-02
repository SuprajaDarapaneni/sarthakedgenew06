
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Switch to school database
Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$user = App\Models\User::where('email', 'ds@gmail.com')->first();
if ($user) {
    echo "User Found! ID: " . $user->id . "\n";
    Auth::login($user);
    echo "User class-teacher permission: " . ($user->hasPermissionTo('class-teacher') ? 'YES' : 'NO') . "\n";
    echo "User attendance-create permission: " . ($user->hasPermissionTo('attendance-create') ? 'YES' : 'NO') . "\n";
    echo "User attendance-list permission: " . ($user->hasPermissionTo('attendance-list') ? 'YES' : 'NO') . "\n";
    
    // Check features
    if (class_exists('App\Services\FeaturesService')) {
        echo "hasFeatureAccess('Attendance Management') = " . (\App\Services\FeaturesService::hasFeature('Attendance Management') ? 'YES' : 'NO') . "\n";
    } else {
        echo "FeaturesService not found.\n";
    }
} else {
    echo "User ds@gmail.com NOT found in eschool_saas_9_parnikakidsville.\n";
}
