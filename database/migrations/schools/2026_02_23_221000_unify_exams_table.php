<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('exams', 'exam_type')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->tinyInteger('exam_type')->default(1)->comment('1: Offline, 2: Online')->after('name');
            });
        }
        if (!Schema::hasColumn('exams', 'status')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->tinyInteger('status')->default(0)->comment('0: Draft, 1: Scheduled')->after('publish');
            });
        }
        if (!Schema::hasColumn('exams', 'total_marks')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->double('total_marks')->nullable()->after('end_date');
            });
        }
        if (!Schema::hasColumn('exams', 'passing_marks')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->double('passing_marks')->nullable()->after('total_marks');
            });
        }

        if (!Schema::hasTable('exam_classes')) {
            Schema::create('exam_classes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
                $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('exam_class_sections')) {
            Schema::create('exam_class_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
                $table->foreignId('class_section_id')->constrained('class_sections')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['exam_type', 'status', 'total_marks', 'passing_marks']);
        });
        Schema::dropIfExists('exam_classes');
        Schema::dropIfExists('exam_class_sections');
    }
};
