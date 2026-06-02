
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$db = DB::connection('mysql')->table('users')->where('email', 'ds@gmail.com')->first();
if ($db) {
    echo "Found ds@gmail.com in MYSQL.\n";
} else {
    echo "Not in MYSQL.\n";
}

$db2 = DB::connection('school')->table('users')->where('email', 'LIKE', '%ds@gmail%')->first();
if ($db2) {
    echo "Found in SCHOOL db.\n";
}

// Check if any role logic was returning an 'attendance-create' permission.
