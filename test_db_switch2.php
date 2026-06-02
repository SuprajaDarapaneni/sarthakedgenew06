<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\Config::set('database.connections.school.database', 'school_db');
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

echo "Connection directly: " . (new Spatie\Permission\Models\Permission())->getConnectionName() . "\n";
echo "Count directly: " . Spatie\Permission\Models\Permission::count() . "\n";

echo "Connection via App: " . app(Spatie\Permission\Models\Permission::class)->getConnectionName() . "\n";
echo "Count via App: " . app(Spatie\Permission\Models\Permission::class)->count() . "\n";

echo "Count with roles: " . app(Spatie\Permission\Models\Permission::class)->with('roles')->count() . "\n";

// Emulate getPermissions closure exactly
$permissions = app(Spatie\Permission\Models\Permission::class)->with('roles')->get();
echo "Closure count: " . $permissions->count() . "\n";
