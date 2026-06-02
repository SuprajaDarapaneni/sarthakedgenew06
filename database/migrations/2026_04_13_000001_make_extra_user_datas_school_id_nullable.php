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
        if (Schema::hasTable('extra_user_datas')) {
            Schema::table('extra_user_datas', function (Blueprint $table) {
                // Drop foreign key first
                $table->dropForeign(['school_id']);
            });

            Schema::table('extra_user_datas', function (Blueprint $table) {
                // Make school_id nullable
                $table->foreignId('school_id')->nullable()->change();
            });

            Schema::table('extra_user_datas', function (Blueprint $table) {
                // Re-add foreign key
                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('extra_user_datas')) {
            Schema::table('extra_user_datas', function (Blueprint $table) {
                $table->dropForeign(['school_id']);
            });

            Schema::table('extra_user_datas', function (Blueprint $table) {
                $table->foreignId('school_id')->nullable(false)->change();
            });

            Schema::table('extra_user_datas', function (Blueprint $table) {
                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            });
        }
    }
};
