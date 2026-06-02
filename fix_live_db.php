<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Check if column exists first
    $columns = Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM students LIKE 'application_status'");
    if (empty($columns)) {
        Illuminate\Support\Facades\DB::statement("ALTER TABLE students ADD COLUMN application_status INT DEFAULT 1 COMMENT '1- accepted, 0- rejected' AFTER school_id");
        echo "Column 'application_status' added successfully!";
    } else {
        echo "Column 'application_status' already exists!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
