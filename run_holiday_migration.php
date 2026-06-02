<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Config::set('database.connections.school.database', 'school_db');
DB::purge('school');
$db = DB::connection('school');

try {
    if (!Schema::connection('school')->hasColumn('holidays', 'end_date')) {
        Schema::connection('school')->table('holidays', function (Blueprint $table) {
            $table->date('end_date')->nullable()->after('date');
        });
        echo "Successfully added end_date to holidays table in school_db\n";
    } else {
        echo "end_date column already exists in holidays table in school_db\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
