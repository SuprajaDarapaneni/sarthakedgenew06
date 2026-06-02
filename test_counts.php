<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mainDBCount = DB::connection('mysql')->table('permissions')->count();
echo "Main DB (project) permissions: {$mainDBCount}\n";

Config::set('database.connections.school.database', 'school_db');
DB::purge('school');
$schoolDBCount = DB::connection('school')->table('permissions')->count();
echo "School DB (school_db) permissions: {$schoolDBCount}\n";
