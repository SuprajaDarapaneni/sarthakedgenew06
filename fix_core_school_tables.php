<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Helper to check and create tables
function createTable($name, $callback)
{
    if (!Schema::hasTable($name)) {
        Schema::create($name, $callback);
        echo "Table '$name' created.\n";
    } else {
        echo "Table '$name' already exists.\n";
    }
}

try {
    echo "Starting table repairs...\n";

    createTable('session_years', function (Blueprint $table) {
        $table->id();
        $table->string('name', 512);
        $table->tinyInteger('default')->default(0);
        $table->date('start_date');
        $table->date('end_date');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->unique(['name', 'school_id']);
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('mediums', function (Blueprint $table) {
        $table->id();
        $table->string('name', 512);
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->softDeletes();
        $table->timestamps();
    });

    createTable('sections', function (Blueprint $table) {
        $table->id();
        $table->string('name', 512);
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('shifts', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->time('start_time', 0);
        $table->time('end_time', 0);
        $table->integer('status')->default(1);
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('streams', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('classes', function (Blueprint $table) {
        $table->id();
        $table->string('name', 512);
        $table->tinyInteger('include_semesters')->comment('0 - no 1 - yes')->default(0);
        $table->foreignId('medium_id')->references('id')->on('mediums')->onDelete('cascade');
        $table->foreignId('shift_id')->nullable()->references('id')->on('shifts')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('stream_id')->nullable()->references('id')->on('streams')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('class_sections', function (Blueprint $table) {
        $table->id();
        $table->foreignId('class_id')->references('id')->on('classes')->onDelete('cascade');
        $table->foreignId('section_id')->references('id')->on('sections')->onDelete('cascade');
        $table->foreignId('medium_id')->references('id')->on('mediums')->onDelete('cascade');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->unique(['class_id', 'section_id', 'medium_id'], 'unique_id');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('students', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreignId('class_section_id')->references('id')->on('class_sections')->onDelete('cascade');
        $table->string('admission_no', 512);
        $table->integer('roll_number')->nullable();
        $table->date('admission_date');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->foreignId('guardian_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreignId('session_year_id')->references('id')->on('session_years')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('subjects', function (Blueprint $table) {
        $table->id();
        $table->string('name', 512);
        $table->string('code', 64)->nullable();
        $table->string('bg_color', 32);
        $table->string('image', 512);
        $table->foreignId('medium_id')->references('id')->on('mediums')->onDelete('cascade');
        $table->string('type', 64)->comment('Theory / Practical');
        $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });

    createTable('faqs', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->timestamps();
    });

    echo "Table repairs completed.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
