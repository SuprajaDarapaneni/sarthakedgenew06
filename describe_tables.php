<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'school_db');
DB::purge('school');

function describeTable($table)
{
    echo "Table: $table\n";
    $columns = DB::connection('school')->select("DESCRIBE $table");
    foreach ($columns as $column) {
        echo "{$column->Field} ({$column->Type})\n";
    }
    echo "\n";
}

ob_start();
describeTable('academic_calendars');
describeTable('holidays');
describeTable('exams');
describeTable('fees_paids');
describeTable('attendances');
$output = ob_get_clean();
file_put_contents('tables_description.txt', $output);
echo "Done\n";
