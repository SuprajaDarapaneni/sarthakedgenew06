<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            if (!Schema::hasColumn('classes', 'next_class_id')) {
                $table->foreignId('next_class_id')->nullable()->after('school_id')->references('id')->on('classes')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            if (Schema::hasColumn('classes', 'next_class_id')) {
                $table->dropForeign(['next_class_id']);
                $table->dropColumn('next_class_id');
            }
        });
    }
};
