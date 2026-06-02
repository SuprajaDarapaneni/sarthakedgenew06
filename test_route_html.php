
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

// Simulate HTTPS request to class-section index
$request = Illuminate\Http\Request::create('/class-section', 'GET', [], [], [], [
    'HTTPS' => 'on',
    'HTTP_X_FORWARDED_PROTO' => 'https'
]);

try {
    $controller = app()->make(App\Http\Controllers\ClassSectionController::class);
    $response = $controller->index($request);
    
    $html = $response->getContent();
    // Search for data-url inside the HTML
    preg_match('/data-url="([^"]+)"/', $html, $matches);
    echo "DATA URL in HTML: " . ($matches[1] ?? 'NOT FOUND') . "\n";

} catch (\Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . " at " . $e->getFile() . "\n";
}
