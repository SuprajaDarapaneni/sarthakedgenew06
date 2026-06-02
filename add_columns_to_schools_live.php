<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Get all schools from the main database
    $schools = Illuminate\Support\Facades\DB::connection('mysql')->table('schools')->get();
    echo "Found " . count($schools) . " schools.\n";

    foreach ($schools as $school) {
        if (empty($school->database_name)) {
            echo "School ID " . $school->id . " has no database name. Skipping.\n";
            continue;
        }

        echo "Processing School ID " . $school->id . " (" . $school->name . ") - DB: " . $school->database_name . "\n";

        // Switch to school database
        Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
        Illuminate\Support\Facades\DB::purge('school');
        
        try {
            // Reconnect to verify
            Illuminate\Support\Facades\DB::connection('school')->reconnect();

            // 1. ADD 'application_status' TO 'students' TABLE IN SCHOOL DB
            try {
                $columns = Illuminate\Support\Facades\DB::connection('school')->select("SHOW COLUMNS FROM students LIKE 'application_status'");
                if (empty($columns)) {
                    Illuminate\Support\Facades\DB::connection('school')->statement("ALTER TABLE students ADD COLUMN application_status INT DEFAULT 1 COMMENT '1- accepted, 0- rejected' AFTER school_id");
                    echo "  -> Added 'application_status' to 'students' table.\n";
                } else {
                    echo "  -> 'application_status' column already exists in 'students' table.\n";
                }
            } catch (\Exception $e) {
                echo "  -> Error on 'students' table for " . $school->database_name . ": " . $e->getMessage() . "\n";
            }

            // 2. ADD 'class_teacher_id' TO 'class_sections' TABLE IN SCHOOL DB
            try {
                $columns = Illuminate\Support\Facades\DB::connection('school')->select("SHOW COLUMNS FROM class_sections LIKE 'class_teacher_id'");
                if (empty($columns)) {
                    Illuminate\Support\Facades\DB::connection('school')->statement("ALTER TABLE class_sections ADD COLUMN class_teacher_id INT DEFAULT NULL AFTER section_id");
                    echo "  -> Added 'class_teacher_id' to 'class_sections' table.\n";
                } else {
                    echo "  -> 'class_teacher_id' column already exists in 'class_sections' table.\n";
                }
            } catch (\Exception $e) {
                echo "  -> Error on 'class_sections' table for " . $school->database_name . ": " . $e->getMessage() . "\n";
            }

        } catch (\Exception $e) {
            echo "  -> Could not connect to database " . $school->database_name . ": " . $e->getMessage() . "\n";
        }
    }

    echo "Finished processing all schools.\n";

} catch (Exception $e) {
    echo "Global Error: " . $e->getMessage() . "\n";
}
