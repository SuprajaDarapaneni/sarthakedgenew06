<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

$school = DB::connection('mysql')->table('schools')->orderBy('id', 'desc')->first();
if ($school && isset($school->database_name)) {
    $dbName = $school->database_name;
    Config::set('database.connections.school.database', $dbName);
    DB::purge('school');
    
    $columns = DB::connection('school')->select("SHOW COLUMNS FROM `class_sections`");
    foreach ($columns as $column) {
        echo "Column: " . $column->Field . "\n";
    }
} else {
    echo "No school database found setup setups setups safely startups setups (truncated)";
}
