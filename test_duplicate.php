<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = DB::connection('mysql')->table('users')->where('email', 'saisuppu1@gmail.com')->get();
foreach ($users as $u) {
    echo "ID: {$u->id}, Name: {$u->first_name} {$u->last_name}, School ID: {$u->school_id}\n";
    if ($u->school_id) {
        $school = DB::connection('mysql')->table('schools')->where('id', $u->school_id)->first();
        echo "  -> School Name: {$school->name}, DB: {$school->database_name}\n";
    }
}
