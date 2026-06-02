<?php
include_once 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = DB::connection('mysql')->select('SHOW TABLES');
    foreach ($tables as $table) {
        foreach ($table as $key => $val) {
            echo $val . "\n";
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>