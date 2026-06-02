
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'eschool_saas_9_parnikakidsville');
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

$user = App\Models\User::where('email', 'ds@gmail.com')->first();
Auth::login($user);

$html = view('layouts.sidebar')->render();

echo "SEMESTER IN VIEW: " . (strpos($html, 'Semester') !== false ? 'YES' : 'NO') . "\n";
echo "STREAM IN VIEW: " . (strpos($html, 'Stream') !== false ? 'YES' : 'NO') . "\n";
echo "SHIFT IN VIEW: " . (strpos($html, 'Shift') !== false ? 'YES' : 'NO') . "\n";
echo "DOCUMENTATION IN VIEW: " . (strpos($html, 'Documentation') !== false ? 'YES' : 'NO') . "\n";
