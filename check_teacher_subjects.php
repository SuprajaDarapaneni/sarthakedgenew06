
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$subjects = DB::table('subject_teachers')->where('teacher_id', 88)->get();
if ($subjects->isNotEmpty()) {
    echo "Teacher 88 has " . $subjects->count() . " subjects assigned.\n";
    foreach ($subjects as $s) {
        echo "- Subject ID: " . $s->subject_id . " in Class Section ID: " . $s->class_section_id . "\n";
    }
} else {
    echo "Teacher 88 has NO subjects assigned in subject_teachers table.\n";
}
