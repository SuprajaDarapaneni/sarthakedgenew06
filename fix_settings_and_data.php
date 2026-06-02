<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\School;
use App\Models\SessionYear;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Helper to check and create tables
function createTableIfMissing($name, $callback)
{
    if (!Schema::hasTable($name)) {
        Schema::create($name, $callback);
        echo "Table '$name' created.\n";
    } else {
        echo "Table '$name' exists.\n";
    }
}

try {
    echo "Fixing settings and data...\n";

    // 1. Create Tables
    createTableIfMissing('school_settings', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('data');
        $table->string('type')->comment('datatype like string , file etc')->nullable();
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->unique(['name', 'school_id']);
    });

    createTableIfMissing('announcements', function (Blueprint $table) {
        $table->id();
        $table->string('title', 128);
        $table->longText('description')->nullable();
        $table->foreignId('session_year_id')->references('id')->on('session_years')->onDelete('cascade');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
    });

    createTableIfMissing('announcement_classes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('announcement_id')->nullable()->unsigned()->index()->references('id')->on('announcements')->onDelete('cascade');
        $table->foreignId('class_section_id')->nullable()->unsigned()->index()->references('id')->on('class_sections')->onDelete('cascade');
        $table->foreignId('class_subject_id')->nullable(true)->references('id')->on('class_subjects')->onDelete('cascade');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->unique(['announcement_id', 'class_section_id', 'school_id'], 'unique_columns');
    });

    // 2. Data Seeding for School 1
    $schoolId = 1;
    $school = School::find($schoolId);

    if ($school) {
        // Create Session Year if missing
        $sessionYear = SessionYear::where('school_id', $schoolId)->where('default', 1)->first();
        if (!$sessionYear) {
            $sessionYear = SessionYear::create([
                'name' => Carbon::now()->format('Y'),
                'school_id' => $schoolId,
                'default' => 1,
                'start_date' => Carbon::now()->startOfYear()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfYear()->format('Y-m-d'),
            ]);
            echo "Created Session Year: " . $sessionYear->id . "\n";
        } else {
            echo "Session Year exists: " . $sessionYear->id . "\n";
        }

        // Set session_year in school_settings
        DB::table('school_settings')->updateOrInsert(
            ['name' => 'session_year', 'school_id' => $schoolId],
            ['data' => $sessionYear->id, 'type' => 'number']
        );
        echo "Updated 'session_year' setting.\n";

        // Add other common settings??
        DB::table('school_settings')->updateOrInsert(
            ['name' => 'school_name', 'school_id' => $schoolId],
            ['data' => $school->name, 'type' => 'string']
        );

        // Clear cache
        app(App\Services\CachingService::class)->removeSchoolCache($schoolId);
        echo "Cache cleared.\n";

    } else {
        echo "School 1 not found.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
