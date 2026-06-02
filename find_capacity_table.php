<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $tableName = current((array)$table);
    $columns = DB::select("SHOW COLUMNS FROM `{$tableName}`");
    foreach ($columns as $column) {
        if (strtolower($column->Field) == 'capacity') {
            echo "Table: {$tableName} has column capacity\n";
        }
    }
}
