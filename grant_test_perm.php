
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$user = App\Models\User::find(88);
if ($user) {
    // Explicitly give permission to test
    $user->givePermissionTo('attendance-create');
    echo "Granted attendance-create permission on user ID 88.\n";
} else {
    echo "User not found.\n";
}
