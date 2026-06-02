
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

// Check if assigned in class_sections
$section = DB::table('class_sections')->where('teacher_id', 88)->first();
if ($section) {
    echo "Teacher assigned to Class Section ID: " . $section->id . "\n";
} else {
    echo "Teacher is NOT assigned to any Class Section as primary teacher.\n";
}

// Check Class teachers table if any
if (Schema::hasTable('class_teachers')) {
    $class_teacher = DB::table('class_teachers')->where('teacher_id', 88)->first();
    if ($class_teacher) {
        echo "Teacher found in class_teachers table.\n";
    } else {
        echo "Teacher NOT found in class_teachers table.\n";
    }
} else {
    echo "No class_teachers table exists.\n";
}
