
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

$request = Illuminate\Http\Request::create('/class-section/1', 'GET', [
    'limit' => 5,
    'offset' => 0,
    'sort' => 'id',
    'order' => 'DESC'
]);

try {
    $controller = app()->make(App\Http\Controllers\ClassSectionController::class);
    $response = $controller->show($request);
    
    // Output exactly the JSON sent to the client
    echo "EXACT JSON RESPONSE:\n\n";
    echo $response->getContent() . "\n";

} catch (\Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . " at " . $e->getFile() . "\n";
}
