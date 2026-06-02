<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'saisuppu1@gmail.com';
$new_password = 'Sch20252';

try {
    $user = Illuminate\Support\Facades\DB::connection('mysql')->table('users')->where('email', $email)->first();

    if ($user) {
        $hashed_password = Illuminate\Support\Facades\Hash::make($new_password);
        Illuminate\Support\Facades\DB::connection('mysql')->table('users')->where('id', $user->id)->update([
            'password' => $hashed_password
        ]);
        echo "Password for $email successfully reset to $new_password!\n";
    } else {
        echo "User $email not found in main database. Cannot reset password.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
