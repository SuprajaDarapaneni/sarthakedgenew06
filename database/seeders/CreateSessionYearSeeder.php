<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateSessionYearSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure School exists (Required for Foreign Key)
        if (DB::table('schools')->count() == 0) {
            DB::table('schools')->insert([
                'id' => 1, // Key
                'name' => 'Demo School',
                'address' => 'Demo Address',
                'support_phone' => '1234567890',
                'support_email' => 'support@school.com',
                'tagline' => 'Learning',
                'logo' => 'logo.png',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 2. Ensure Session Year exists
        if (DB::table('session_years')->where('default', 1)->count() == 0) {
            DB::table('session_years')->insert([
                'name' => '2025-26',
                'start_date' => '2025-04-01',
                'end_date' => '2026-03-31',
                'default' => 1,
                'school_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
