<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$school_id = 13;
$central_school = DB::connection('mysql')->table('schools')->where('id', $school_id)->first();
if(!$central_school) {
    echo "Central school ID $school_id not found!\n";
    exit;
}

$db = $central_school->database_name;
$admin_id = $central_school->admin_id;

echo "Syncing School $school_id and Admin $admin_id to $db...\n";

DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=0;');

function sync_table($db, $table, $id, $central_data) {
    echo "Syncing $table ID $id...\n";
    $columns = DB::connection('mysql')->select("DESCRIBE $db.$table");
    $valid_columns = array_column($columns, 'Field');
    $filtered_data = [];
    foreach((array)$central_data as $key => $val) {
        if(in_array($key, $valid_columns)) {
            $filtered_data[$key] = $val;
        }
    }
    $exists = DB::connection('mysql')->table($db.'.'.$table)->where('id', $id)->first();
    if($exists) {
        DB::connection('mysql')->table($db.'.'.$table)->where('id', $id)->update($filtered_data);
    } else {
        DB::connection('mysql')->table($db.'.'.$table)->insert($filtered_data);
    }
}

// Sync Admin
$central_user = DB::connection('mysql')->table('users')->where('id', $admin_id)->first();
if($central_user) {
    sync_table($db, 'users', $admin_id, $central_user);
}

// Sync School
sync_table($db, 'schools', $school_id, $central_school);

DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=1;');
echo "Completed Successfully!\n";
