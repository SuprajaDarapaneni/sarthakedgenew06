<?php
try {
    echo "DEBUG START\n";
    $s = \App\Models\School::find(1);
    if ($s) {
        // Current: school1.localhost
        // Fix: Set to 'school1' so logic matches subdomain parts[0]
        $s->domain = 'school1';
        $s->save();
        echo "[OK] Updated School Domain to 'school1'.\n";

        // Clear Cache
        app(App\Services\CachingService::class)->removeSchoolCache($s->id);
        echo "Cache cleaned.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
