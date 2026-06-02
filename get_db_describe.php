
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
$cols = DB::connection('school')->select("DESCRIBE students");
foreach ($cols as $c) {
    echo $c->Field . "\n";
}
echo "--- USERS ---\n";
$cols2 = DB::connection('school')->select("DESCRIBE users");
foreach ($cols2 as $c) {
    echo $c->Field . "\n";
}
