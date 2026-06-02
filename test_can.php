
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
Auth::login($user);

echo "can('class-section-list'): " . ($user->can('class-section-list') ? 'YES' : 'NO') . "\n";

$roles = $user->getRoleNames();
echo "Roles: " . implode(', ', $roles->toArray()) . "\n";

$permissions = $user->getAllPermissions();
echo "Has class-section-list in getAllPermissions(): " . ($permissions->contains('name', 'class-section-list') ? 'YES' : 'NO') . "\n";

