<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$central_school = DB::connection('mysql')->table('schools')->where('id', 12)->first();
$db = 'eschool_saas_12_abhinavhighschool';

if($central_school) {
    echo "Syncing school ID 12 to $db (Filtered)...\n";
    
    // Get tenant table columns
    $columns = DB::connection('mysql')->select("DESCRIBE $db.schools");
    $valid_columns = array_column($columns, 'Field');
    
    $data = [];
    foreach((array)$central_school as $key => $val) {
        if(in_array($key, $valid_columns)) {
            $data[$key] = $val;
        }
    }
    
    // Check if school exists in tenant
    $tenant_school = DB::connection('mysql')->table($db.'.schools')->where('id', 12)->first();
    
    if($tenant_school) {
        DB::connection('mysql')->table($db.'.schools')->where('id', 12)->update($data);
        echo "Updated existing school ID 12 in tenant DB.\n";
    } else {
        DB::connection('mysql')->table($db.'.schools')->insert($data);
        echo "Inserted new school ID 12 in tenant DB.\n";
    }
} else {
    echo "Central school ID 12 not found!\n";
}
