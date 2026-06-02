
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$columns = DB::connection('school')->getSchemaBuilder()->getColumnListing('students');
echo "COLUMNS IN STUDENTS:\n" . implode(", ", $columns) . "\n";

$columns_users = DB::connection('school')->getSchemaBuilder()->getColumnListing('users');
echo "COLUMNS IN USERS:\n" . implode(", ", $columns_users) . "\n";
