<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mainUser = DB::connection('mysql')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
$schoolRaw = DB::connection('mysql')->table('schools')->where('id', $mainUser->school_id)->first();

$user = App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
$schoolEloquent = $user->school;

echo "Raw DB - School ID: " . $schoolRaw->id . " DB: " . $schoolRaw->database_name . "\n";
echo "Eloquent - School ID: " . ($schoolEloquent ? $schoolEloquent->id : 'none') . " DB: " . ($schoolEloquent ? $schoolEloquent->database_name : 'none') . "\n";

echo "User school_id field: " . $mainUser->school_id . "\n";
