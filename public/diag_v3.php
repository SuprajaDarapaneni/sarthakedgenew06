<?php
include_once 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $email = 'admin@gmail.com';
    $user = App\Models\User::where('email', $email)->first();
    if ($user) {
        $role = $user->getRoleNames()->first() ?? 'NO_ROLE';
        $school = $user->school_id ?? 'NULL';
        echo "FOUND: user_id:{$user->id}, role:{$role}, school_id:{$school}";
    } else {
        echo "NOT_FOUND: $email";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>