<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Read all missing perms
$code = file_get_contents(app_path('Services/SchoolDataService.php'));
preg_match('/\$SchoolAdminHasAccessTo\s*=\s*\[(.*?)\];/s', $code, $matchesAdmin);
preg_match('/\$TeacherHasAccessTo\s*=\s*\[(.*?)\];/s', $code, $matchesTeacher);

$permsStr = $matchesAdmin[1] . ',' . $matchesTeacher[1];
preg_match_all("/'([^']+)'/", $permsStr, $matchesPerms);
$missingPerms = array_unique($matchesPerms[1]);
echo "Found " . count($missingPerms) . " unique permissions.\n";

$schools = DB::connection('mysql')->table('schools')->get();

foreach ($schools as $school) {
    if (!$school->database_name || $school->database_name == 'project')
        continue;

    echo "\nProcessing School DB: {$school->database_name}\n";
    \Config::set('database.connections.school.database', $school->database_name);
    \DB::purge('school');
    \DB::connection('school')->reconnect();
    \DB::setDefaultConnection('school');
    // Clear cache per tenant
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    $inserted = 0;
    foreach ($missingPerms as $p) {
        if (!Spatie\Permission\Models\Permission::on('school')->where('name', $p)->where('guard_name', 'web')->exists()) {
            Spatie\Permission\Models\Permission::create(['name' => $p, 'guard_name' => 'web']);
            $inserted++;
        }
    }
    echo "Inserted $inserted permissions in {$school->database_name}.\n";

    // Sync to School Admin
    $roles = Spatie\Permission\Models\Role::on('school')->where('name', 'School Admin')->get();
    foreach ($roles as $role) {
        $role->syncPermissions($missingPerms);
        echo "Synced to role ID: {$role->id} in {$school->database_name}\n";
    }
}
echo "Done!\n";
