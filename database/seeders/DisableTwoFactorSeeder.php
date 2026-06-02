<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisableTwoFactorSeeder extends Seeder
{
    public function run()
    {
        DB::statement("UPDATE school_db.users SET two_factor_enabled = 0 WHERE email = 'saisuppu1@gmail.com'");
    }
}
