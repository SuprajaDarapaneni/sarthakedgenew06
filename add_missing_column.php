
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\School;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$schools = School::all();
foreach ($schools as $school) {
    Config::set('database.connections.school.database', $school->database_name);
    DB::purge('school');
    DB::connection('school')->reconnect();

    try {
        if (!Schema::connection('school')->hasColumn('students', 'application_status')) {
            DB::connection('school')->statement("ALTER TABLE students ADD COLUMN application_status INT NULL DEFAULT 1 AFTER school_id");
            echo "Added application_status to " . $school->database_name . "\n";
        } else {
            echo $school->database_name . " already has it.\n";
        }
    } catch (\Throwable $e) {
        echo "Error on " . $school->database_name . ": " . $e->getMessage() . "\n";
    }
}
