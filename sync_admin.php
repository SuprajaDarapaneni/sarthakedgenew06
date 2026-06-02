<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$central_user = DB::connection('mysql')->table('users')->where('id', 12)->first();
$db = 'eschool_saas_9_parnikakidsville';

if($central_user) {
    echo "Syncing user ID 12 to $db...\n";
    
    // Check if ID 12 exists in tenant
    $tenant_user = DB::connection('mysql')->table($db.'.users')->where('id', 12)->first();
    
    $update_data = [
        'email' => $central_user->email,
        'mobile' => $central_user->mobile,
        'first_name' => $central_user->first_name,
        'last_name' => $central_user->last_name,
        'password' => $central_user->password, // Sync the Hashed password directly
        'status' => 1,
        'updated_at' => Carbon\Carbon::now()
    ];
    
    if($tenant_user) {
        DB::connection('mysql')->table($db.'.users')->where('id', 12)->update($update_data);
        echo "Updated existing user ID 12 in tenant DB.\n";
    } else {
        $update_data['id'] = 12;
        $update_data['created_at'] = Carbon\Carbon::now();
        DB::connection('mysql')->table($db.'.users')->insert($update_data);
        echo "Inserted new user ID 12 in tenant DB.\n";
    }
} else {
    echo "Central user ID 12 not found!\n";
}
