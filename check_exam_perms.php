
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$user = App\Models\User::where('email', 'ds@gmail.com')->first();
if ($user) {
    echo "User found: " . $user->id . "\n";
    echo "exam-upload-marks permission: " . ($user->hasPermissionTo('exam-upload-marks') ? 'YES' : 'NO') . "\n";
    echo "class-teacher permission: " . ($user->hasPermissionTo('class-teacher') ? 'YES' : 'NO') . "\n";
    echo "Roles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
} else {
    echo "User not found.\n";
}
