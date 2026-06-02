<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
    if (!$user) {
        die("User not found.\n");
    }

    $school = $user->school;

    if (!$school || !$school->database_name) {
        die("School or database not found.\n");
    }

    echo "User: {$user->first_name} {$user->last_name} (School ID: {$school->id})\n";
    echo "Connecting to School Database: {$school->database_name}\n";

    // Switch to school database
    \Config::set('database.connections.school.database', $school->database_name);
    \DB::purge('school');
    \DB::connection('school')->reconnect();
    \DB::setDefaultConnection('school');

    // Get the user from the school database
    $schoolUser = App\Models\User::on('school')->where('email', 'saisuppu1@gmail.com')->first();

    if (!$schoolUser) {
        die("User not found in school database.\n");
    }

    // Role
    $role = Spatie\Permission\Models\Role::on('school')->where('name', 'School Admin')->first();
    if (!$role) {
        die("School Admin role not found in school DB.\n");
    }

    // Since developer claims "has all features", sync all permissions available in the school DB
    $perms = Spatie\Permission\Models\Permission::on('school')->get();

    echo "Found " . $perms->count() . " permissions in school DB.\n";

    // Assign role to user if not assigned
    if (!$schoolUser->hasRole('School Admin')) {
        $schoolUser->assignRole($role);
        echo "Assigned School Admin role to user in school DB.\n";
    }

    $role->syncPermissions($perms);
    echo "Synced " . $perms->count() . " permissions to role {$role->name} in school DB.\n";

    // Also sync the permissions directly to the user to be absolutely safe?
    // Actually, Spatie checks role permissions appropriately. Let's just grant all to the role.

    // Clear permission cache
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    echo "Cleared permission cache.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
