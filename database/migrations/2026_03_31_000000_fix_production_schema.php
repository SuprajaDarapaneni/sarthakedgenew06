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
        // 1. Add 'status' column to 'subscriptions' if it doesn't exist
        if (Schema::hasTable('subscriptions')) {
            if (!Schema::hasColumn('subscriptions', 'status')) {
                Schema::table('subscriptions', function (Blueprint $table) {
                    $table->tinyInteger('status')->default(1)->comment('1 => Active, 2 => Overdue, 0 => Inactive')->after('end_date');
                });
            }
        }

        // 2. Create 'leave_masters' table if it doesn't exist
        if (!Schema::hasTable('leave_masters')) {
            Schema::create('leave_masters', function (Blueprint $table) {
                $table->id();
                $table->float('leaves')->comment('Leaves per month');
                $table->string('holiday');
                $table->foreignId('session_year_id')->references('id')->on('session_years')->onDelete('cascade');
                $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // 3. Create 'expenses' table if it doesn't exist
        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->nullable()->references('id')->on('expense_categories')->onDelete('cascade');
                $table->string('ref_no')->nullable();
                $table->foreignId('staff_id')->nullable()->references('id')->on('staffs')->onDelete('cascade');
                $table->bigInteger('basic_salary')->default(0);
                $table->float('paid_leaves')->default(0);
                $table->bigInteger('month')->nullable();
                $table->integer('year')->nullable();
                $table->string('title', 512);
                $table->string('description')->nullable();
                $table->double('amount', 8, 2);
                $table->date('date');
                $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->foreignId('session_year_id')->references('id')->on('session_years')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['staff_id', 'month', 'year'], 'salary_unique_records');
            });
        } else {
            // Ensure basic_salary and paid_leaves exist if table exists but is missing these columns
            Schema::table('expenses', function (Blueprint $table) {
                if (!Schema::hasColumn('expenses', 'basic_salary')) {
                    $table->bigInteger('basic_salary')->default(0)->after('staff_id');
                }
                if (!Schema::hasColumn('expenses', 'paid_leaves')) {
                    $table->float('paid_leaves')->default(0)->after('basic_salary');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subscriptions')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
        Schema::dropIfExists('leave_masters');
        // We probably don't want to drop 'expenses' if it already existed
    }
};
