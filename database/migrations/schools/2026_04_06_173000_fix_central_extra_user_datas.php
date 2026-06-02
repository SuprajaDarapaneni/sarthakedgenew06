<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('extra_student_datas') && !Schema::hasTable('extra_user_datas')) {
            Schema::rename('extra_student_datas', 'extra_user_datas');
        }

        if (Schema::hasTable('extra_user_datas')) {
            Schema::table('extra_user_datas', function (Blueprint $table) {
                if (Schema::hasColumn('extra_user_datas', 'student_id') && !Schema::hasColumn('extra_user_datas', 'user_id')) {
                    $table->renameColumn('student_id', 'user_id');
                }
            });
        } else {
             Schema::create('extra_user_datas', static function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->comment('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreignId('form_field_id')->references('id')->on('form_fields')->onDelete('cascade');
                $table->text('data')->nullable();
                $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('extra_user_datas')) {
            Schema::rename('extra_user_datas', 'extra_student_datas');
            Schema::table('extra_student_datas', function (Blueprint $table) {
                if (Schema::hasColumn('extra_student_datas', 'user_id')) {
                    $table->renameColumn('user_id', 'student_id');
                }
            });
        }
    }
};
