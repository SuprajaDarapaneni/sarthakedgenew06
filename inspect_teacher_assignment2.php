
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

if (Schema::hasTable('class_teachers')) {
    $class_teacher = DB::table('class_teachers')->where('teacher_id', 88)->first();
    if ($class_teacher) {
        echo "Teacher found in class_teachers table! Class Section ID: " . $class_teacher->class_section_id . "\n";
        
        // Grant permissions
        $user = App\Models\User::find(88);
        if ($user) {
            $user->givePermissionTo(['class-teacher', 'exam-upload-marks', 'exam-result', 'attendance-list']);
            echo "Permissions granted!\n";
        } else {
            echo "User not found to grant permissions.\n";
        }
    } else {
        echo "Teacher NOT found in class_teachers table.\n";
    }
} else {
    echo "No class_teachers table exists.\n";
}
