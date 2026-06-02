
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Force the school connection and check features directly
$school = \App\Models\School::where('code', 'Sch20269')->first();
if ($school) {
    echo "School Code Sch20269 Found!\n";
    echo "School ID: " . $school->id . "\n";
    echo "School Name: " . $school->name . "\n";
    echo "School Database: " . $school->database_name . "\n"; // Guessing column name
    
    // Output all Columns
    $columns = Schema::getColumnListing('schools');
    echo "Columns: " . implode(", ", $columns) . "\n";
} else {
    echo "School Code Sch20269 NOT Found in default DB.\n";
}
