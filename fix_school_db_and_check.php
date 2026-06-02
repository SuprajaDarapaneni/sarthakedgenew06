<?php
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "Current DB Name in .env: " . env('DB_DATABASE') . "\n";
    $school = School::find(1);

    if ($school) {
        $school->database_name = env('DB_DATABASE') ?: 'project';
        $school->save();
        echo "Updated School ID 1 database_name to: " . $school->database_name . "\n";

        // Clear Cache to force reload
        app(App\Services\CachingService::class)->removeSchoolCache($school->id);
    } else {
        echo "School 1 not found??\n";
    }

    // Check 'sliders' table in main DB
    $cols = Schema::connection('mysql')->getColumnListing('sliders');
    echo "Columns in 'sliders': " . json_encode($cols) . "\n";

    if (!in_array('type', $cols) && count($cols) > 0) {
        echo "WARNING: 'type' column missing in 'sliders' table!\n";

        // Add column if missing?
        // Check migration first. 
        // 2024_01_30_092228_version1_2_0.php adds 'type' to sliders?
        // No, let's just check if we can add it or if migration failed.

        // Check if we can add type column easily:
        /*
        Schema::table('sliders', function($table) {
             $table->integer('type')->default(1)->comment('1:App, 2:Web, 3:Both');
        });
        echo "Added 'type' column.\n";
        */
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
