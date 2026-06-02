<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkVerifiedSeeder extends Seeder
{
    public function run()
    {
        DB::statement("UPDATE school_db.users SET email_verified_at = NOW() WHERE email = 'saisuppu1@gmail.com'");
    }
}
