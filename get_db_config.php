<?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo config("database.connections.mysql.database") . "|" . config("database.connections.mysql.username") . "|" . config("database.connections.mysql.password");
    
