<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Auth::loginUsingId(12);
$controller = app(App\Http\Controllers\StudentController::class);
$method = new ReflectionMethod($controller, 'create');
$method->setAccessible(true);
ob_start();
echo json_encode([
    'max_id' => app(App\Repositories\Student\StudentInterface::class)->builder()->latest('id')->withTrashed()->pluck('id')->first(),
    'view_data' => array_keys($method->invoke($controller)->getData())
]) . "
";
