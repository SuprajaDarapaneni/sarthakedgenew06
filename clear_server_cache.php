<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "Clearing view cache...\n";
Artisan::call('view:clear');
echo Artisan::output();

echo "Clearing config cache...\n";
Artisan::call('config:clear');
echo Artisan::output();

echo "Clearing cache...\n";
Artisan::call('cache:clear');
echo Artisan::output();

echo "Clearing optimize...\n";
Artisan::call('optimize:clear');
echo Artisan::output();

echo "Done.";
