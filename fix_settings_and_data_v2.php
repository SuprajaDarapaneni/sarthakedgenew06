<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\School;
use App\Models\SessionYear;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    echo "Fixing settings and dependencies...\n";

    createTableIfMissing('semesters', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->tinyInteger('start_month');
        $table->tinyInteger('end_month');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTableIfMissing('elective_subject_groups', function (Blueprint $table) {
        $table->id();
        $table->integer('total_subjects');
        $table->integer('total_selectable_subjects');
        $table->foreignId('class_id')->references('id')->on('classes')->onDelete('cascade');
        $table->foreignId('semester_id')->nullable()->references('id')->on('semesters')->onDelete('cascade');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTableIfMissing('class_subjects', function (Blueprint $table) {
        $table->id();
        $table->foreignId('class_id')->references('id')->on('classes')->onDelete('cascade');
        $table->foreignId('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        $table->string('type', 32)->comment('Compulsory / Elective');
        $table->foreignId('elective_subject_group_id')->nullable()->comment('if type=Elective')->references('id')->on('elective_subject_groups')->onDelete('cascade');
        $table->foreignId('semester_id')->nullable()->references('id')->on('semesters')->onDelete('cascade');
        $table->integer('virtual_semester_id')->virtualAs('CASE WHEN semester_id IS NOT NULL THEN semester_id ELSE 0 END');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->unique(['class_id', 'subject_id', 'virtual_semester_id'], 'unique_ids');
        $table->softDeletes();
        $table->timestamps();
    });

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

    createTableIfMissing('form_fields', function (Blueprint $table) {
        $table->id();
        $table->string('name', 128);
        $table->string('type', 128)->comment('text,number,textarea,dropdown,checkbox,radio,fileupload');
        $table->boolean('is_required')->default(0);
        $table->text('default_values')->nullable()->comment('values of radio,checkbox,dropdown,etc');
        $table->text('other')->nullable()->comment('extra HTML attributes');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->integer('rank')->default(0);
        $table->timestamps();
        $table->softDeletes();
        $table->unique(['name', 'school_id'], 'name');
    });

    createTableIfMissing('class_groups', function (Blueprint $table) { // Needed? Controller uses it
        $table->id();
        $table->string('name');
        $table->string('description')->nullable();
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
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

        // Add other common settings
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
