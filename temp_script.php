<?php
    $user = \App\Models\User::where('email', 'superadmin@gmail.com')->first();
    echo "ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Password Hash: " . $user->password . "\n";
    echo "Hash Check 'superadmin': " . (\Hash::check('superadmin', $user->password) ? 'TRUE' : 'FALSE') . "\n";
    echo "Is Active/Status: " . $user->status . "\n";
    echo "Deleted At: " . $user->deleted_at . "\n";
    echo "Two Factor Enabled: " . $user->two_factor_enabled . "\n";
    