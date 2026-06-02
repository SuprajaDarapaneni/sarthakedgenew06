<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$db = 'eschool_saas_12_abhinavhighschool';

// 1. Sync User 63
$central_user = DB::connection('mysql')->table('users')->where('id', 63)->first();
if($central_user) {
    echo "Syncing user ID 63...\n";
    $tenant_user = DB::connection('mysql')->table($db.'.users')->where('id', 63)->first();
    $user_data = (array)$central_user;
    if($tenant_user) {
        DB::connection('mysql')->table($db.'.users')->where('id', 63)->update($user_data);
    } else {
        DB::connection('mysql')->table($db.'.users')->insert($user_data);
    }
}

// 2. Sync School 12
$central_school = DB::connection('mysql')->table('schools')->where('id', 12)->first();
if($central_school) {
    echo "Syncing school ID 12...\n";
    $columns = DB::connection('mysql')->select("DESCRIBE $db.schools");
    $valid_columns = array_column($columns, 'Field');
    $school_data = [];
    foreach((array)$central_school as $key => $val) {
        if(in_array($key, $valid_columns)) {
            $school_data[$key] = $val;
        }
    }
    $tenant_school = DB::connection('mysql')->table($db.'.schools')->where('id', 12)->first();
    if($tenant_school) {
        DB::connection('mysql')->table($db.'.schools')->where('id', 12)->update($school_data);
    } else {
        DB::connection('mysql')->table($db.'.schools')->insert($school_data);
    }
    echo "Done!\n";
}
