<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    echo "ERROR: vendor/autoload.php not found! Path: $autoload\n";
    exit;
}
require $autoload;

try {
    $context = __DIR__ . '/bootstrap/app.php';
    if (!file_exists($context)) {
        echo "ERROR: bootstrap/app.php not found! Path: $context\n";
        exit;
    }
    $app = require_once $context;
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    echo "BOOT_SUCCESSFUL";
    
} catch (Throwable $t) {
    echo "CAUGHT: " . $t->getMessage() . "\n";
    echo "IN: " . $t->getFile() . " LINE: " . $t->getLine() . "\n";
}
?>