<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignSchoolIdSeeder extends Seeder
{
    public function run()
    {
        DB::statement("UPDATE school_db.users SET school_id = 1 WHERE email = 'saisuppu1@gmail.com'");
    }
}
