<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

try {
    if (!Schema::hasTable('sliders')) {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('link')->nullable();
            $table->integer('type')->default(1)->comment('1: App, 2: Web, 3: Both');
            $table->timestamps();
        });
        echo "Table 'sliders' created successfully.\n";
    } else {
        echo "Table 'sliders' already exists.\n";

        // Check columns
        if (!Schema::hasColumn('sliders', 'type')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->integer('type')->default(1)->comment('1: App, 2: Web, 3: Both');
            });
            echo "Column 'type' added to 'sliders'.\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
