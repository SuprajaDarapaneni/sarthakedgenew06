<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // 1. Drop 'application_status' from main database 'students' table
    try {
        $columns = Illuminate\Support\Facades\DB::connection('mysql')->select("SHOW COLUMNS FROM students LIKE 'application_status'");
        if (!empty($columns)) {
            Illuminate\Support\Facades\DB::connection('mysql')->statement("ALTER TABLE students DROP COLUMN application_status");
            echo "Dropped 'application_status' from main database.\n";
        }
    } catch (\Exception $e) {
        echo "Error in main DBstudents: " . $e->getMessage() . "\n";
    }

    // Get all schools to fix tenant databases
    $schools = Illuminate\Support\Facades\DB::connection('mysql')->table('schools')->get();
    echo "Processing " . count($schools) . " schools for revert.\n";

    foreach ($schools as $school) {
        if (empty($school->database_name)) continue;

        echo "Processing School ID " . $school->id . " - DB: " . $school->database_name . "\n";

        Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
        Illuminate\Support\Facades\DB::purge('school');

        try {
            Illuminate\Support\Facades\DB::connection('school')->reconnect();

            // Drop 'application_status' from tenant 'students' table
            try {
                $columns = Illuminate\Support\Facades\DB::connection('school')->select("SHOW COLUMNS FROM students LIKE 'application_status'");
                if (!empty($columns)) {
                    Illuminate\Support\Facades\DB::connection('school')->statement("ALTER TABLE students DROP COLUMN application_status");
                    echo "  -> Dropped 'application_status' from 'students'.\n";
                }
            } catch (\Exception $e) { }

            // Drop 'class_teacher_id' from tenant 'class_sections' table
            try {
                $columns = Illuminate\Support\Facades\DB::connection('school')->select("SHOW COLUMNS FROM class_sections LIKE 'class_teacher_id'");
                if (!empty($columns)) {
                    Illuminate\Support\Facades\DB::connection('school')->statement("ALTER TABLE class_sections DROP COLUMN class_teacher_id");
                    echo "  -> Dropped 'class_teacher_id' from 'class_sections'.\n";
                }
            } catch (\Exception $e) { }

        } catch (\Exception $e) {
            echo "  -> Connection failed for " . $school->database_name . "\n";
        }
    }
    
    echo "Revert complete.\n";

} catch (\Exception $e) {
    echo "Global error: " . $e->getMessage() . "\n";
}
