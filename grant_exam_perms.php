
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$role = Spatie\Permission\Models\Role::where('name', 'Teacher')->first();
if ($role) {
    $permission = Spatie\Permission\Models\Permission::where('name', 'exam-upload-marks')->first();
    if ($permission) {
        $role->givePermissionTo($permission);
        echo "Granted exam-upload-marks to Teacher role.\n";
    } else {
        echo "Permission exam-upload-marks not found.\n";
    }
} else {
    echo "Role Teacher not found.\n";
}

// Also grant to the user directly just in case they have a custom set
$user = App\Models\User::where('email', 'ds@gmail.com')->first();
if ($user) {
    if (!$user->hasPermissionTo('exam-upload-marks')) {
        $user->givePermissionTo('exam-upload-marks');
        echo "Granted exam-upload-marks to ds@gmail.com.\n";
    }
}
