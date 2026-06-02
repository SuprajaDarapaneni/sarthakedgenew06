<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

try {
    DB::setDefaultConnection('school'); // Switch to school connection
    
    $today = Carbon::now()->format('Y-m-d');
    
    $recs = DB::table('holidays')->get();
    echo "Total Holidays in DB: " . count($recs) . "\n";
    foreach ($recs as $r) {
        echo "Holiday: Title=" . $r->title . " | Date=" . $r->date . " | EndDate=" . ($r->end_date ?? 'N/A') . "\n";
    }
    
    // Test the exact condition Added in controller
    $query = DB::table('holidays')->where(function ($q) use ($today) {
        $q->whereDate('date', '>=', $today)
          ->orWhere(function ($q2) use ($today) {
              $q2->whereDate('date', '<=', $today)->whereDate('end_date', '>=', $today);
          });
    })->get();

    echo "\nFiltered with Controller Condition Count: " . count($query) . "\n";
    foreach ($query as $r) {
        echo "MATCHED: Title=" . $r->title . "\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
