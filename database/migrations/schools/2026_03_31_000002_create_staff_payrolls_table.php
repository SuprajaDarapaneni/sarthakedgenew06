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
        if (!Schema::hasTable('staff_payrolls')) {
            Schema::create('staff_payrolls', function (Blueprint $table) {
                $table->id();
                $table->foreignId('expense_id')->nullable()->references('id')->on('expenses')->onDelete('cascade');
                $table->foreignId('payroll_setting_id')->nullable()->references('id')->on('payroll_settings')->onDelete('cascade');
                $table->double('amount')->nullable();
                $table->float('percentage')->nullable();
                $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->unique(['expense_id', 'payroll_setting_id'], 'unique_ids');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_payrolls');
    }
};
