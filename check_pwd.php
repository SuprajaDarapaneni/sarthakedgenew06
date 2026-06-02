<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'zeedoors924@gmail.com';
$user = DB::connection('mysql')->table('users')->where('email', $email)->first();

if (!$user) {
    echo "User not found in mysql\n";
} else {
    echo "Testing passwords for $email:\n";
    foreach (['school', 'Sch20269'] as $pwd) {
        if (Hash::check($pwd, $user->password)) {
            echo "  '$pwd': MATCH\n";
        } else {
            echo "  '$pwd': NO MATCH\n";
        }
    }
}
