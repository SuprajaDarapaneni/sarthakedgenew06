<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Auth::loginUsingId(72);
DB::setDefaultConnection('school');
config(['database.connections.school.database' => 'eschool_saas_21_vivekanandafreeeducationcenter']);
DB::purge('school');
DB::connection('school')->reconnect();
DB::setDefaultConnection('school');

app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
config(['permission.cache.key' => 'spatie.permission.cache.eschool_saas_21_vivekanandafreeeducationcenter']);

$request = Illuminate\Http\Request::create('/teacher/show', 'GET', []);
app()->instance('request', $request);

$controller = app(App\Http\Controllers\TeacherController::class);
$response = $controller->show();
echo json_encode($response->getData(true));
