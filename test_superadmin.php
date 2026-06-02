<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $u = App\Models\User::where('email', 'superadmin@gmail.com')->first();
    echo json_encode($u);
} catch (\Exception $e) {
    echo $e->getMessage();
}
