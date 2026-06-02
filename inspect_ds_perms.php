
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// simulate login
$user = App\Models\User::where('email', 'ds@gmail.com')->first();

echo "User class-teacher permission: " . ($user->hasPermissionTo('class-teacher') ? 'YES' : 'NO') . "\n";
echo "User attendance-create permission: " . ($user->hasPermissionTo('attendance-create') ? 'YES' : 'NO') . "\n";
echo "User attendance-list permission: " . ($user->hasPermissionTo('attendance-list') ? 'YES' : 'NO') . "\n";
