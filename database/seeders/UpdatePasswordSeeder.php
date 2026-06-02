<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordSeeder extends Seeder
{
    public function run()
    {
        $pass = Hash::make('09392511176');
        DB::statement("UPDATE school_db.users SET password = '$pass' WHERE email = 'saisuppu1@gmail.com'");
    }
}
