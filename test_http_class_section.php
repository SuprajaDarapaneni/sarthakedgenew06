
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

// Let's create an HTTP request that goes through the exact middleware pipeline
$request = Illuminate\Http\Request::create('/class-section/1', 'GET', [
    'limit' => 5,
    'offset' => 0,
    'sort' => 'id',
    'order' => 'DESC'
]);

$response = app()->handle($request);
echo "STATUS: " . $response->getStatusCode() . "\n";
echo "CONTENT: " . substr($response->getContent(), 0, 1000) . "\n";
