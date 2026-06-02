<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    $model = new \App\Models\Holiday();
    echo "Holiday Model Connection: " . $model->getConnectionName() . "\n";
    
    // Also print first element with raw data parameters setups 
    // Wait, first() might return null if empty
    $h = \App\Models\Holiday::first();
    if ($h) {
        echo "Holiday First Item Connection: " . $h->getConnectionName() . "\n";
    } else {
        echo "Holiday Table is empty on resolved connection.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
