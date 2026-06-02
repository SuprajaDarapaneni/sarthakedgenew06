<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'saisuppu1@gmail.com';
$password = 'Sch20252';

try {
    $user = Illuminate\Support\Facades\DB::connection('mysql')->table('users')->where('email', $email)->first();

    if (!$user) {
        echo "USER_NOT_FOUND: User with email $email does not exist in main database.\n";
        
        // Search in all databases? 
        echo "Searching in all databases...\n";
        $schools = Illuminate\Support\Facades\DB::connection('mysql')->table('schools')->get();
        foreach ($schools as $school) {
            if (empty($school->database_name)) continue;
            Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
            Illuminate\Support\Facades\DB::purge('school');
            try {
                $u = Illuminate\Support\Facades\DB::connection('school')->table('users')->where('email', $email)->first();
                if ($u) {
                    echo "-> Found user in database: " . $school->database_name . " (School ID: " . $school->id . ")\n";
                    echo "   Password Match: " . (Illuminate\Support\Facades\Hash::check($password, $u->password) ? "YES" : "NO") . "\n";
                }
            } catch (\Exception $e) {}
        }
        exit;
    }

    echo "User found in main database!\n";
    echo "ID: " . $user->id . "\n";
    echo "School ID: " . $user->school_id . "\n";
    
    $password_check = Illuminate\Support\Facades\Hash::check($password, $user->password);
    echo "Password Check: " . ($password_check ? "SUCCESS" : "FAILED") . "\n";

    if ($user->school_id) {
        $school = Illuminate\Support\Facades\DB::connection('mysql')->table('schools')->where('id', $user->school_id)->first();
        if ($school) {
            echo "Associated School: " . $school->name . "\n";
            echo "School Status: " . ($school->status == 1 ? "Active" : "Inactive") . "\n";
        } else {
            echo "Associated School not found in DB!\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
