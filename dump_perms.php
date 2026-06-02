<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "default DB: " . config('database.default') . "\n";
echo "DB prefix: " . config('database.connections.mysql.prefix') . "\n";
echo "Spatie Permission Count (MySQL): " . Spatie\Permission\Models\Permission::count() . "\n";
echo "Raw DB 'permissions' Table Count: " . DB::table('permissions')->count() . "\n";

Config::set('database.connections.school.database', 'school_db');
DB::purge('school');
DB::connection('school')->reconnect();

echo "Spatie Permission Count (School): " . Spatie\Permission\Models\Permission::on('school')->count() . "\n";
echo "Raw DB 'permissions' Table Count (School): " . DB::connection('school')->table('permissions')->count() . "\n";
