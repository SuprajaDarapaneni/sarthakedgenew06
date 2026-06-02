<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Exam;
use App\Models\SubjectTeacher;
use App\Models\ClassTeacher;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Assuming school_id 1 or similar. Let's find a teacher.
$teacher = User::role('Teacher')->first();
if (!$teacher) {
    echo "No teacher found\n";
    exit;
}

Auth::login($teacher);
DB::setDefaultConnection('school');
$school = $teacher->school;
Config::set('database.connections.school.database', $school->database_name);
DB::purge('school');
DB::reconnect('school');

echo "Testing getExamList for Teacher: " . $teacher->full_name . " (ID: " . $teacher->id . ")\n";

$request = new \Illuminate\Http\Request([
    'status' => '2'
]);

$sessionYear = App\Services\CachingService::getDefaultSessionYear();

$sql = Exam::on('school')->with('session_year', 'class')->select('id', 'name', 'description', 'class_id', 'start_date', 'end_date', 'session_year_id', 'publish')
    ->with([
        'timetable.class_subject' => function ($q) {
            $q->withTrashed();
        }
    ]);

$sql = $sql->where('session_year_id', $sessionYear->id);

$exam_data_db = $sql->orderBy('id', 'DESC')->get();

echo "Total exams found in session year: " . $exam_data_db->count() . "\n";

foreach ($exam_data_db as $data) {
    $current_date = date('Y-m-d');
    $exam_status = "3";
    
    // Original broken logic check
    if ($current_date >= $data->start_date && $current_date <= $data->end_date) {
        $exam_status = "1";
    } else if ($current_date < $data->start_date) {
        $exam_status = "2"; // WRONG
    } else if ($current_date >= $data->end_date) {
        $exam_status = "1"; // WRONG
    } else {
        $exam_status = null;
    }

    echo "Exam: " . $data->name . " | start: " . $data->start_date . " | end: " . $data->end_date . " | Calc Status: " . $exam_status . " | Model Status: " . $data->exam_status . "\n";
    
    $subjectTeacherIds = SubjectTeacher::where('teacher_id', Auth::user()->id)->where('class_section_id', $request->class_section_id)->pluck('subject_id')->toArray();
    $classTeacher = ClassTeacher::where('teacher_id', Auth::user()->id)->where('class_section_id', $request->class_section_id)->first();
    
    echo "  subjectTeacherIds count: " . count($subjectTeacherIds) . "\n";
    echo "  classTeacher: " . ($classTeacher ? 'Yes' : 'No') . "\n";
    
    $timetable_data = [];
    foreach ($data->timetable as $timetable) {
        if ($classTeacher) {
            $timetable_data[] = $timetable->id;
        } else if (in_array($timetable->class_subject->subject_id, $subjectTeacherIds)) {
            $timetable_data[] = $timetable->id;
        }
    }
    echo "  Subjects visible: " . count($timetable_data) . "\n";
}
