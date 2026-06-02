
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
$tables = DB::connection('school')->select("SHOW TABLES");
foreach ($tables as $t) {
    $table_arr = (array)$t;
    $table_name = array_values($table_arr)[0];
    if (strpos($table_name, 'admission') !== false || strpos($table_name, 'applicant') !== false) {
        echo "Table: " . $table_name . "\n";
        $cols = DB::connection('school')->select("DESCRIBE $table_name");
        foreach ($cols as $c) {
            echo "  - " . $c->Field . "\n";
        }
    }
}
