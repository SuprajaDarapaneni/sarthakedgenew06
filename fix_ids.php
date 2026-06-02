<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mainUser = DB::connection('mysql')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
$school = DB::connection('mysql')->table('schools')->where('id', $mainUser->school_id)->first();

\Config::set('database.connections.school.database', $school->database_name);
\DB::purge('school');
\DB::connection('school')->reconnect();

$schoolUser = DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->first();

echo "Main User ID: {$mainUser->id}\n";
echo "School User ID: {$schoolUser->id}\n";

if ($mainUser->id !== $schoolUser->id) {
    echo "ID mismatch! Updating School DB to match Main DB...\n";
    DB::connection('school')->table('model_has_roles')->where('model_id', $schoolUser->id)->update(['model_id' => $mainUser->id]);
    DB::connection('school')->table('model_has_permissions')->where('model_id', $schoolUser->id)->update(['model_id' => $mainUser->id]);
    echo "Updated spatie model_ids.\n";

    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
} else {
    echo "IDs match already.\n";
}
