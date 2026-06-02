<?php
$log_file = 'storage/logs/laravel.log';
if (file_exists($log_file)) {
    $lines = file($log_file);
    $last_lines = array_slice($lines, -100);
    echo implode("", $last_lines);
} else {
    echo "Log file not found.";
}
?>