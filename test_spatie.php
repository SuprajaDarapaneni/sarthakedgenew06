<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
Auth::login($u);

echo "Before DB Switch:\n";
echo "Roles: " . Auth::user()->roles->pluck('name')->implode(', ') . "\n";
echo "Permissions count: " . app()->make(\Spatie\Permission\PermissionRegistrar::class)->getPermissions()->count() . "\n";

\Config::set('database.connections.school.database', $u->school->database_name);
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

echo "After DB Switch and Cache Clear:\n";
echo "Roles: " . Auth::user()->roles->pluck('name')->implode(', ') . "\n";
echo "Permissions count from Registrar: " . app()->make(\Spatie\Permission\PermissionRegistrar::class)->getPermissions()->count() . "\n";
echo "User permissions count: " . Auth::user()->getAllPermissions()->count() . "\n";
echo "Can medium-list? " . (Auth::user()->can('medium-list') ? 'Yes' : 'No') . "\n";
