<?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    Illuminate\Support\Facades\Auth::loginUsingId(1);
    
    // Fake request
    $request = Illuminate\Http\Request::create('/payroll/list', 'GET', ['month' => 1, 'year' => 2026]);
    app()->instance('request', $request);
    
    try {
        $controller = app(App\Http\Controllers\PayrollController::class);
        $response = $controller->show();
        file_put_contents('debug_json_out.txt', print_r(json_decode($response->getContent(), true), true));
    } catch (\Exception $e) {
        file_put_contents('debug_json_out.txt', "Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    }
    