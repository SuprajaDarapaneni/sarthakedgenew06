<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('expenses')) {
            // Check if foreign key exists before dropping
            $conn = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $conn->listTableForeignKeys('expenses');
            $fkNames = array_map(function($fk) { return $fk->getName(); }, $foreignKeys);
            
            Schema::table('expenses', function (Blueprint $table) use ($fkNames) {
                if (in_array('expenses_school_id_foreign', $fkNames)) {
                    $table->dropForeign(['school_id']);
                }
            });

            Schema::table('expenses', function (Blueprint $table) {
                // Make school_id nullable
                $table->unsignedBigInteger('school_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('expenses')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->unsignedBigInteger('school_id')->nullable(false)->change();
            });
        }
    }
};
