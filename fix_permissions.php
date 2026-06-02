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
    if (!$school) {
        $school = App\Models\School::where('id', $user->school_id)->first();
    }

    if (!$school) {
        die("School not found for user.\n");
    }

    echo "User: {$user->first_name} {$user->last_name} (School ID: {$school->id})\n";

    // Find the School Admin role for this school or create one
    $role = Spatie\Permission\Models\Role::where('name', 'School Admin')
        ->where('school_id', $school->id)
        ->first();

    if (!$role) {
        // If not found, try to find a global one, or create specifically for this school
        $role = Spatie\Permission\Models\Role::create([
            'name' => 'School Admin',
            'school_id' => $school->id,
            'custom_role' => 0
        ]);
        echo "Created new School Admin role for school {$school->id}.\n";
    }

    // Get features from the school's active subscription package
    $subscription = $school->subscription;
    if ($subscription && $subscription->package) {
        $features = $subscription->package->package_feature->pluck('feature_id');

        // Get permissions linked to these features
        $permissions = Spatie\Permission\Models\Permission::whereIn('id', function ($q) use ($features) {
            $q->select('permission_id')
                ->from('feature_sections')
                ->whereIn('feature_id', $features);
        })->get();

        echo "Found " . $permissions->count() . " permissions from package.\n";

        // Ensure "School Admin" role gets all these permissions
        $role->syncPermissions($permissions);
        echo "Synced permissions to role {$role->name} (ID: {$role->id}).\n";

        // Assign this role to the user
        $user->assignRole($role);
        echo "Assigned role to user. User now has " . $user->getAllPermissions()->count() . " permissions.\n";
    } else {
        echo "No active subscription package found to derive permissions from.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
