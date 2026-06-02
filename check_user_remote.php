<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$user = App\Models\User::where('email', 'superadmin@gmail.com')->first();
if ($user) {
    echo "User FOUND: " . $user->email . "\n";
    echo "ID: " . $user->id . "\n";
    echo "Password Hash: " . $user->password . "\n";
} else {
    echo "User NOT FOUND\n";
}
