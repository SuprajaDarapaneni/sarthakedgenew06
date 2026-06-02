<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mainUser = DB::connection('mysql')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
Auth::loginUsingId($mainUser->id);

$school = DB::connection('mysql')->table('schools')->where('id', $mainUser->school_id)->first();
\Config::set('database.connections.school.database', $school->database_name);
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

// The sidebar uses `app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(...)` under the hood. 
// Let's test that exact construct:
$gate = app(\Illuminate\Contracts\Auth\Access\Gate::class);
$canAcademics = $gate->any(['medium-list', 'section-list', 'subject-list', 'class-list', 'subject-list', 'promote-student-list', 'transfer-student-list']);

echo "Has permission for Academics via Gate::any? " . ($canAcademics ? 'Yes' : 'No') . "\n";

// Now test Auth::user()->canany
$canany = Auth::user()->canany(['medium-list', 'section-list']);
echo "Auth::user()->canany? " . ($canany ? 'Yes' : 'No') . "\n";
