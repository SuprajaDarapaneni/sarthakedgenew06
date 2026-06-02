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
        if (!Schema::hasTable('leaves')) {
            Schema::create('leaves', static function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('reason');
                $table->date('from_date');
                $table->date('to_date');
                $table->integer('status')->default(0)->comment('0 => Pending, 1 => Approved, 2 => Rejected');
                $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->unsignedBigInteger('leave_master_id')->nullable();
                $table->timestamps();
            });
            
            // Add foreign key if leave_masters exists
            if (Schema::hasTable('leave_masters')) {
                Schema::table('leaves', function (Blueprint $table) {
                    $table->foreign('leave_master_id')->references('id')->on('leave_masters')->onDelete('cascade');
                });
            }
        }

        if (!Schema::hasTable('leave_details')) {
            Schema::create('leave_details', static function (Blueprint $table) {
                $table->id();
                $table->foreignId('leave_id')->references('id')->on('leaves')->onDelete('cascade');
                $table->date('date');
                $table->string('type');
                $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_details');
        Schema::dropIfExists('leaves');
    }
};
