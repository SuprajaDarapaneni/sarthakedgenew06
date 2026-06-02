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
        if (!Schema::hasTable('session_years_trackings')) {
            Schema::create('session_years_trackings', function (Blueprint $table) {
                $table->id();
                $table->string('modal_type');
                $table->integer('modal_id');
                
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('session_year_id')->constrained('session_years')->onDelete('cascade');
                $table->foreignId('semester_id')->nullable();
                $table->foreignId('school_id')->nullable();
                
                $table->timestamps();
            });

            // Add foreign keys separately if tables exist
            Schema::table('session_years_trackings', function (Blueprint $table) {
                if (Schema::hasTable('semesters')) {
                    $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
                }
                if (Schema::hasTable('schools')) {
                    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_years_trackings');
    }
};
