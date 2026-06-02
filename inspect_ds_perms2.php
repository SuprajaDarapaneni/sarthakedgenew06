
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// simulate login
$user = DB::connection('school')->table('users')->where('email', 'ds@gmail.com')->first();
if ($user) {
    $real_user = App\Models\User::where('id', $user->id)->first(); // Actually the DB is school
    if (!$real_user) { // Must switch first
        \App\Services\CachingService::setSchoolDatabaseConnection('sarthake_3'); // guess based on earlier
        $real_user = App\Models\User::where('email', 'ds@gmail.com')->first();
    }
    
    if ($real_user) {
        Auth::login($real_user);
        echo "User class-teacher permission: " . ($real_user->hasPermissionTo('class-teacher') ? 'YES' : 'NO') . "\n";
        echo "User attendance-create permission: " . ($real_user->hasPermissionTo('attendance-create') ? 'YES' : 'NO') . "\n";
        echo "User attendance-list permission: " . ($real_user->hasPermissionTo('attendance-list') ? 'YES' : 'NO') . "\n";
    } else {
        echo "Real user not found even after switch.\n";
    }
}
