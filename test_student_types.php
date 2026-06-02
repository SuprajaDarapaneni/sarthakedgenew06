
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$students = App\Models\Students::select('application_type', 'application_status')->distinct()->get();
echo "TYPES & STATUSES:\n";
foreach ($students as $s) {
    echo "Type: " . ($s->application_type ?? 'NULL') . " | Status: " . ($s->application_status ?? 'NULL') . "\n";
}
