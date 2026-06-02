<?php
$log = shell_exec('tail -n 20 /home/sarthakedge/htdocs/sarthakedge.com/php_code_live/storage/logs/laravel.log');
echo $log;
