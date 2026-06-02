<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

Config::set('database.connections.school.database', 'school_db');
DB::purge('school');
DB::connection('school')->reconnect();

try {
    $tables = DB::connection('school')->getDoctrineSchemaManager()->listTableNames();
    file_put_contents('err.txt', json_encode($tables, JSON_PRETTY_PRINT));
} catch (\Exception $e) {
    file_put_contents('err.txt', "Error: " . $e->getMessage() . "\n");
}
