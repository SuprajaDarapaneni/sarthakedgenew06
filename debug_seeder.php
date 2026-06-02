<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    (new Database\Seeders\DemoDataSeeder())->run();
    echo "Success!";
} catch (\Exception $e) {
    echo $e->getMessage();
    echo "\n";
    echo $e->getTraceAsString();
}
