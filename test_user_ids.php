<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u1 = DB::connection('mysql')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
if ($u1 && $u1->school_id) {
    $school = DB::connection('mysql')->table('schools')->where('id', $u1->school_id)->first();
    \Config::set('database.connections.school.database', $school->database_name);
    \DB::purge('school');
    \DB::connection('school')->reconnect();

    $u2 = DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
    echo 'MySQL ID: ' . $u1->id . ' | School DB ID: ' . ($u2 ? $u2->id : 'NOT FOUND') . "\n";
} else {
    echo "User or school missing in main DB.\n";
}
