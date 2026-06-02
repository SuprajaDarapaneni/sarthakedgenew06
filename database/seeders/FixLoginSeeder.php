<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FixLoginSeeder extends Seeder
{
    public function run()
    {
        // Ensure Role exists
        if (!Role::where('name', 'School Admin')->exists()) {
            Role::create(['name' => 'School Admin', 'guard_name' => 'web']);
        }

        // Ensure User exists
        $user = User::where('email', 'saisuppu1@gmail.com')->first();
        if (!$user) {
            $user = User::create([
                'first_name' => 'Sai',
                'last_name' => 'Suppu',
                'email' => 'saisuppu1@gmail.com',
                'password' => Hash::make('09392511176'), // Set requested password
                'status' => 1,
                'mobile' => '09392511176',
            ]);
        } else {
            $user->password = Hash::make('09392511176');
            $user->status = 1;
            $user->save();
        }

        // Assign Role if not already
        if (!$user->hasRole('School Admin')) {
            $user->assignRole('School Admin');
        }
    }
}
