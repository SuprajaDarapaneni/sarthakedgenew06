<?php
use Illuminate\Support\Facades\Artisan;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "Running migrations for school connection...\n";
    Artisan::call('migrate', [
        '--database' => 'school',
        '--path' => 'database/migrations/schools',
        '--force' => true,
    ]);
    echo Artisan::output();
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
