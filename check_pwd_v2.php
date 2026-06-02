<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pwd_list = ['school', 'Sch20269', '9392511176'];

// Central DB
$email1 = 'zeedoors924@gmail.com';
$user1 = DB::connection('mysql')->table('users')->where('email', $email1)->first();
if($user1) {
    echo "--- sarthakedge25.users ($email1) ---\n";
    foreach ($pwd_list as $pwd) {
        echo "  '$pwd': " . (Hash::check($pwd, $user1->password) ? 'MATCH' : 'NO MATCH') . "\n";
    }
}

// Tenant DB
$db = 'eschool_saas_9_parnikakidsville';
$email2 = 'skgupta2k1@gmail.com';
$user2 = DB::connection('mysql')->table($db.'.users')->where('email', $email2)->first();
if($user2) {
    echo "--- $db.users ($email2) ---\n";
    foreach ($pwd_list as $pwd) {
        echo "  '$pwd': " . (Hash::check($pwd, $user2->password) ? 'MATCH' : 'NO MATCH') . "\n";
    }
}
