<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mainUser = DB::connection('mysql')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
$school = DB::connection('mysql')->table('schools')->where('id', $mainUser->school_id)->first();

\Config::set('database.connections.school.database', $school->database_name);
\DB::purge('school');
\DB::setDefaultConnection('school');

echo "Database assigned: {$school->database_name}\n";
echo "DB Table count: " . \DB::table('permissions')->count() . "\n";
echo "Spatie Model count: " . \Spatie\Permission\Models\Permission::count() . "\n";

app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

echo "Registrar count: " . app()->make(\Spatie\Permission\PermissionRegistrar::class)->getPermissions()->count() . "\n";

