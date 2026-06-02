<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$log = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($log)) {
    // Read the last 2000 characters to see the latest exception
    $content = shell_exec('tail -n 20 ' . escapeshellarg($log));
    echo "LATEST_LOG_ENTRIES:\n" . $content . "\n";
} else {
    echo "Log file not found!";
}
?>