<?php
$log_file = 'storage/logs/laravel.log';
if (file_exists($log_file)) {
    $content = file_get_contents($log_file);
    $last_thousand = substr($content, -10000);
    echo $last_thousand;
} else {
    echo "Log file not found.";
}
?>