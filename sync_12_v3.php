<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$db = 'eschool_saas_12_abhinavhighschool';

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

$central_user = DB::connection('mysql')->table('users')->where('id', 63)->first();
if($central_user) {
    sync_table($db, 'users', 63, $central_user);
}

$central_school = DB::connection('mysql')->table('schools')->where('id', 12)->first();
if($central_school) {
    sync_table($db, 'schools', 12, $central_school);
}
echo "Done!\n";
