<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
echo "User email: " . $u->email . "\n";
echo "Roles: " . $u->roles->pluck('name')->implode(', ') . "\n";
echo "Can 'medium-list'? " . ($u->can('medium-list') ? 'Yes' : 'No') . "\n";
echo "Total permissions: " . $u->getAllPermissions()->count() . "\n";
echo "Role ID matching: " . $u->roles->first()->id . "\n";
echo "Does role have 'medium-list'? " . ($u->roles->first()->hasPermissionTo('medium-list') ? 'Yes' : 'No') . "\n";
