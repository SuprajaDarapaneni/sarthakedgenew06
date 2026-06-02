<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        try {
            echo "Starting seeder (raw mode)...\n";
            $mainConn = DB::connection('mysql');
            $schoolConn = DB::connection('school');

            // 1. Ensure School 1 exists in main DB
            $schoolId = 1;
            $school = $mainConn->table('schools')->where('id', $schoolId)->first();
            if (!$school) {
                $mainConn->table('schools')->insert([
                    'id' => $schoolId,
                    'name' => 'Premium Demo School',
                    'address' => 'Silicon Valley, CA',
                    'support_phone' => '1234567890',
                    'support_email' => 'admin@demoschool.com',
                    'status' => 1,
                    'database_name' => 'school_db',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 2. Ensure School Admin in main DB
            $adminEmail = 'admin@demoschool.com';
            $admin = $mainConn->table('users')->where('email', $adminEmail)->first();
            if (!$admin) {
                $adminId = $mainConn->table('users')->insertGetId([
                    'first_name' => 'School',
                    'last_name' => 'Admin',
                    'email' => $adminEmail,
                    'password' => Hash::make('admin123'),
                    'school_id' => $schoolId,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $role = $mainConn->table('roles')->where('name', 'School Admin')->first();
                if ($role) {
                    $mainConn->table('model_has_roles')->insert([
                        'role_id' => $role->id,
                        'model_type' => 'App\Models\User',
                        'model_id' => $adminId
                    ]);
                }
            }

            // 3. Populate school_db tables
            // Session Year
            $sessionYearId = $schoolConn->table('session_years')->where('name', '2023-24')->value('id');
            if (!$sessionYearId) {
                $sessionYearId = $schoolConn->table('session_years')->insertGetId([
                    'name' => '2023-24',
                    'school_id' => $schoolId,
                    'default' => 1,
                    'start_date' => '2023-01-01',
                    'end_date' => '2023-12-31',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Medium
            $mediumId = $schoolConn->table('mediums')->where('name', 'English')->value('id');
            if (!$mediumId) {
                $mediumId = $schoolConn->table('mediums')->insertGetId([
                    'name' => 'English',
                    'school_id' => $schoolId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Section
            $sectionId = $schoolConn->table('sections')->where('name', 'A')->value('id');
            if (!$sectionId) {
                $sectionId = $schoolConn->table('sections')->insertGetId([
                    'name' => 'A',
                    'school_id' => $schoolId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Class
            $classId = $schoolConn->table('classes')->where('name', 'Grade 10')->where('medium_id', $mediumId)->value('id');
            if (!$classId) {
                $classId = $schoolConn->table('classes')->insertGetId([
                    'name' => 'Grade 10',
                    'medium_id' => $mediumId,
                    'school_id' => $schoolId,
                    'include_semesters' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Class Section
            $classSectionId = $schoolConn->table('class_sections')->where('class_id', $classId)->where('section_id', $sectionId)->value('id');
            if (!$classSectionId) {
                $classSectionId = $schoolConn->table('class_sections')->insertGetId([
                    'class_id' => $classId,
                    'section_id' => $sectionId,
                    'medium_id' => $mediumId,
                    'school_id' => $schoolId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Subjects
            $subjects = [
                ['name' => 'Mathematics', 'code' => 'MATH', 'type' => 'Compulsory', 'bg_color' => '#6366f1'],
                ['name' => 'Physics', 'code' => 'PHY', 'type' => 'Compulsory', 'bg_color' => '#10b981'],
                ['name' => 'Chemistry', 'code' => 'CHEM', 'type' => 'Compulsory', 'bg_color' => '#3b82f6'],
                ['name' => 'English', 'code' => 'ENG', 'type' => 'Compulsory', 'bg_color' => '#f59e0b'],
                ['name' => 'Biology', 'code' => 'BIO', 'type' => 'Compulsory', 'bg_color' => '#ec4899'],
            ];

            foreach ($subjects as $sub) {
                $subId = $schoolConn->table('subjects')->where('name', $sub['name'])->where('school_id', $schoolId)->value('id');
                if (!$subId) {
                    $subId = $schoolConn->table('subjects')->insertGetId([
                        'name' => $sub['name'],
                        'code' => $sub['code'],
                        'type' => $sub['type'],
                        'bg_color' => $sub['bg_color'],
                        'medium_id' => $mediumId,
                        'school_id' => $schoolId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $schoolConn->table('class_subjects')->updateOrInsert(['class_id' => $classId, 'subject_id' => $subId, 'school_id' => $schoolId], ['type' => $sub['type'], 'created_at' => now(), 'updated_at' => now()]);
            }

            // Teachers
            $teacherRoleId = $mainConn->table('roles')->where('name', 'Teacher')->value('id');
            for ($i = 1; $i <= 5; $i++) {
                $email = "teacher$i@demoschool.com";
                $tId = $mainConn->table('users')->where('email', $email)->value('id');
                if (!$tId) {
                    $tId = $mainConn->table('users')->insertGetId([
                        'first_name' => "Demo",
                        'last_name' => "Teacher $i",
                        'email' => $email,
                        'password' => Hash::make('password'),
                        'school_id' => $schoolId,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    if ($teacherRoleId) {
                        $mainConn->table('model_has_roles')->insert([
                            'role_id' => $teacherRoleId,
                            'model_type' => 'App\Models\User',
                            'model_id' => $tId
                        ]);
                    }
                }
                $schoolConn->table('staff')->updateOrInsert(['user_id' => $tId], ['qualification' => 'Masters', 'salary' => 50000, 'joining_date' => now(), 'session_year_id' => $sessionYearId, 'join_session_year_id' => $sessionYearId, 'created_at' => now(), 'updated_at' => now()]);

                $subIds = $schoolConn->table('subjects')->where('school_id', $schoolId)->pluck('id');
                $subId = $subIds[$i - 1] ?? $subIds[0];
                $schoolConn->table('subject_teachers')->updateOrInsert(['class_section_id' => $classSectionId, 'subject_id' => $subId, 'teacher_id' => $tId, 'school_id' => $schoolId], ['created_at' => now(), 'updated_at' => now()]);
            }

            // Timetable
            $schoolConn->table('timetables')->where('class_section_id', $classSectionId)->delete();
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $timeSlots = [
                ['start' => '08:00:00', 'end' => '09:00:00'],
                ['start' => '09:00:00', 'end' => '10:00:00'],
                ['start' => '10:00:00', 'end' => '10:30:00', 'type' => 'Break'],
                ['start' => '10:30:00', 'end' => '11:30:00'],
                ['start' => '11:30:00', 'end' => '12:30:00'],
            ];

            foreach ($days as $day) {
                foreach ($timeSlots as $index => $slot) {
                    if (isset($slot['type']) && $slot['type'] == 'Break') {
                        $schoolConn->table('timetables')->insert(['class_section_id' => $classSectionId, 'start_time' => $slot['start'], 'end_time' => $slot['end'], 'day' => $day, 'type' => 'Break', 'note' => 'Short Break', 'school_id' => $schoolId, 'created_at' => now(), 'updated_at' => now()]);
                    } else {
                        $st = $schoolConn->table('subject_teachers')->where('class_section_id', $classSectionId)->get()->random();
                        $schoolConn->table('timetables')->insert(['class_section_id' => $classSectionId, 'subject_id' => $st->subject_id, 'subject_teacher_id' => $st->id, 'start_time' => $slot['start'], 'end_time' => $slot['end'], 'day' => $day, 'type' => 'Lecture', 'school_id' => $schoolId, 'created_at' => now(), 'updated_at' => now()]);
                    }
                }
            }
            echo "Timetable seeded successfully!\n";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
