<?php
use app\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Students;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Let's find any Student to test
DB::setDefaultConnection('school');
// Iterate over schools to find one with students
$school = \App\Models\School::where('status', 1)->first();
if ($school) {
    Config::set('database.connections.school.database', $school->database_name);
    DB::purge('school');
    DB::connection('school')->reconnect();
    
    $student = Students::whereNotNull('guardian_id')->where('guardian_id', '>', 0)->with('guardian')->first();
    if ($student && $student->guardian) {
        echo "GUARDIAN JSON:\n";
        print_r($student->guardian->toArray());
    } else {
        echo "No student with guardian found in school: " . $school->database_name . "\n";
    }
} else {
    echo "No school found.\n";
}
