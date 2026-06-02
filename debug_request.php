<?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    Illuminate\Support\Facades\Auth::loginUsingId(1); // Fake login as superadmin
    $request = Illuminate\Http\Request::create('/payroll/list', 'GET', ['month' => 1, 'year' => 2026]);
    $response = app()->handle($request);
    echo $response->getContent();
    