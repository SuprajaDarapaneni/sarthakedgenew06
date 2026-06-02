<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once __DIR__ . '/bootstrap/autoload.php'; // Or vendor/autoload.php depending on version
    // If autoload.php doesn't exist in bootstrap, use vendor/autoload.php
} catch (Exception $e) {}

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "ERROR: vendor/autoload.php not found!";
    exit;
}
require __DIR__ . '/vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    echo "BOOT_SUCCESSFUL";
    
} catch (Exception $e) {
    echo "CAUGHT_EXCEPTION: " . $e->getMessage() . "\n";
    echo "TRACE: " . $e->getTraceAsString() . "\n";
}
?>