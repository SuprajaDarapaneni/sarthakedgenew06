<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'school_db');
DB::purge('school');

$tables = DB::connection('school')->select('SHOW TABLES');
$output = "Tables in school_db:\n";
foreach ($tables as $table) {
    $output .= current((array) $table) . "\n";
}
file_put_contents('tenant_tables.txt', $output);
echo "Done\n";
