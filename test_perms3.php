<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$role = Spatie\Permission\Models\Role::find(7);
if ($role) {
    echo "Role: " . $role->name . " (Guard: " . $role->guard_name . ")\n";
    foreach ($role->permissions as $p) {
        echo $p->id . ' | ' . $p->name . ' | ' . $p->guard_name . "\n";
    }
} else {
    echo "Role not found.\n";
}
