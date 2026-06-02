
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// User authentication check
$user = App\Models\User::where('email', 'ds@gmail.com')->first();
if (!$user) {
    echo "User not found.\n";
} else {
    echo 'User ID: ' . $user->id . "\n";
    echo 'School ID: ' . $user->school_id . "\n";
    
    // Switch to school database explicitly
    $school = \App\Models\School::find($user->school_id);
    if ($school) {
        \App\Services\CachingService::setSchoolDatabaseConnection($school->database_name);
        echo 'Switched to -> ' . $school->database_name . "\n";
    }

    echo 'Roles: ' . implode(', ', $user->roles->pluck('name')->toArray()) . "\n";
    
    // Spatie permission check uses current guard/cache
    echo "User has 'attendance-create'? " . ($user->hasPermissionTo('attendance-create') ? 'YES' : 'NO') . "\n";
    echo "User has 'class-teacher'? " . ($user->hasPermissionTo('class-teacher') ? 'YES' : 'NO') . "\n";
}
