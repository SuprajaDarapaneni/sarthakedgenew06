
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$tables = DB::select('SHOW TABLES');
echo "Tables:\n";
foreach ($tables as $t) {
    echo "- " . array_values((array)$t)[0] . "\n";
}

if (Schema::hasTable('class_sections')) {
    echo "\nColumns for class_sections:\n";
    $columns = Schema::getColumnListing('class_sections');
    echo implode(", ", $columns) . "\n";
}

if (Schema::hasTable('class_teachers')) {
    echo "\nColumns for class_teachers:\n";
    $columns = Schema::getColumnListing('class_teachers');
    echo implode(", ", $columns) . "\n";
}
