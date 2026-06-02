
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
$permissions = $user->getAllPermissions()->pluck('name')->toArray();
echo "Permissions for ds@gmail.com: \n" . implode("\n", $permissions) . "\n";

// check class teacher logic
echo "has class-teacher permission? " . ($user->can('class-teacher') ? "YES" : "NO") . "\n";
