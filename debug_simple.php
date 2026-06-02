<?php
try {
    echo "DEBUG START\n";
    $count = \App\Models\School::count();
    echo "Schools: " . $count . "\n";

    $s = \App\Models\School::orderBy('id')->first();
    if ($s) {
        echo "School: " . $s->name . " (ID: $s->id)\n";
        $s->domain = 'school1.localhost';
        $s->status = 1;
        $s->save();
        echo "[OK] Domain set to school1.localhost and Status to 1.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
