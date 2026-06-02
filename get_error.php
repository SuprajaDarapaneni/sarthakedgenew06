<?php
$log_file = 'storage/logs/laravel.log';
if (file_exists($log_file)) {
    $content = file_get_contents($log_file);
    // Find the last occurrence of "local.ERROR"
    $pos = strrpos($content, 'local.ERROR');
    if ($pos !== false) {
        echo substr($content, $pos, 2000);
    } else {
        echo "No ERROR found in log.";
    }
} else {
    echo "Log file not found.";
}
?>