<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $schoolDb = DB::connection('school')->getDatabaseName();
    DB::connection('school')->getPdo();
    echo "Connected successfully to school database: " . $schoolDb;
} catch (\Exception $e) {
    echo "School connection failed: " . $e->getMessage();
}
