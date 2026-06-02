
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();

$user = App\\Models\\User::where('email', 'ds@gmail.com')->first();
Auth::login($user);

$controller = app()->make(App\\Http\\Controllers\\Api\\StaffApiController::class);
$response = $controller->profile();

echo json_encode($response->getData(), JSON_PRETTY_PRINT);

