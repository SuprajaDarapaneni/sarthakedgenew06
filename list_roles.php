<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;

$output = "Current Roles:\n";
foreach (Role::all() as $role) {
    $output .= "ID: {$role->id}, Name: {$role->name}, Guard: {$role->guard_name}\n";
}
file_put_contents('roles_list.txt', $output);
echo "Done writing to roles_list.txt\n";
