<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::setDefaultConnection('mysql');

// Read SchoolDataService
$code = file_get_contents(app_path('Services/SchoolDataService.php'));

preg_match('/\$SchoolAdminHasAccessTo\s*=\s*\[(.*?)\];/s', $code, $matchesAdmin);
preg_match('/\$TeacherHasAccessTo\s*=\s*\[(.*?)\];/s', $code, $matchesTeacher);

$permsStr = $matchesAdmin[1] . ',' . $matchesTeacher[1];
preg_match_all("/'([^']+)'/", $permsStr, $matchesPerms);

$missingPerms = array_unique($matchesPerms[1]);

echo "Found " . count($missingPerms) . " unique permissions from SchoolDataService.\n";

$inserted = 0;
foreach ($missingPerms as $p) {
    if (!Spatie\Permission\Models\Permission::where('name', $p)->where('guard_name', 'web')->exists()) {
        Spatie\Permission\Models\Permission::create(['name' => $p, 'guard_name' => 'web']);
        $inserted++;
    }
}
echo "Inserted $inserted new permissions.\n";

// Now sync them to the School Admin role on mysql!
// 1. Get the global role if any, or the school specific role. 
// Wait, is School Admin role on mysql specific to a school? 
// Role id 7 was specific to school id 2? Let's assign to all School Admin roles to be safe.
$roles = Spatie\Permission\Models\Role::where('name', 'School Admin')->get();
foreach ($roles as $role) {
    // Sync all
    $role->syncPermissions($missingPerms);
    echo "Synced to role ID: {$role->id}\n";
}

app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
echo "Cache cleared.\n";
