
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'ds@gmail.com')->first();
if (!$user) {
    echo "User not found.\n";
} else {
    echo 'User ID: ' . $user->id . "\n";
    echo 'Roles: ' . implode(', ', $user->getRoleNames()->toArray()) . "\n";
    echo 'Permissions: ' . implode(', ', $user->getAllPermissions()->pluck('name')->toArray()) . "\n";
    $teacher = $user->teacher;
    if ($teacher) {
        $class_section = DB::connection('school')->table('class_teachers')->where('teacher_id', $user->id)->get();
        echo 'Class Teacher for: ' . count($class_section) . ' sections\n';
    } else {
        echo "Not a teacher.\n";
    }
}
