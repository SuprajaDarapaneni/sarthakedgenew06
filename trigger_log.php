<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
\Illuminate\Support\Facades\Log::error('TRIGGER_TEST_ERROR_FROM_PHP');
echo "LOG_TRIGGERED";
?>