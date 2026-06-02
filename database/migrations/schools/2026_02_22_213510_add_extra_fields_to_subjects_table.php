<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->after('school_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('periods_per_week')->nullable()->after('teacher_id');
            $table->tinyInteger('status')->default(1)->comment('0: inactive, 1: active')->after('periods_per_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['teacher_id', 'periods_per_week', 'status']);
        });
    }
};
