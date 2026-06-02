<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
if ($user) {
    echo "User found:\n";
    echo "ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "School ID value: " . ($user->school_id ?? 'NULL') . "\n";
    
    // Also check current role
    echo "Roles: " . implode(', ', $requestRoles = $user->getRoleNames()->toArray()) . "\n";
} else {
    echo "User not found\n";
}
