<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

// 1. Get database_name for School ID 2
$school = \Illuminate\Support\Facades\DB::connection('mysql')->table('schools')->where('id', 2)->first();
if (!$school) {
    die("School 2 not found\n");
}

echo "School 2 Database: " . $school->database_name . "\n";

// 2. Connect to that database
\Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
\Illuminate\Support\Facades\DB::purge('school');

$user = \Illuminate\Support\Facades\DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
if ($user) {
    echo "User in School DB found:\n";
    echo "ID: " . $user->id . "\n";
    echo "School ID value in School DB: " . ($user->school_id ?? 'NULL') . "\n";
} else {
    echo "User not found in School DB\n";
}
