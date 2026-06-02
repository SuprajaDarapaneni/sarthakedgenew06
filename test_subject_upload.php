<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::setDefaultConnection('school');
config(['database.connections.school.database' => 'eschool_saas_31_pandahighschool']);
DB::purge('school');
DB::connection('school')->reconnect();

$user = \App\Models\User::on('mysql')->find(82);
Auth::login($user);

$repo = app(\App\Repositories\Subject\SubjectInterface::class);
file_put_contents('dummy.txt', 'test');
$file = new \Illuminate\Http\UploadedFile('dummy.txt', 'dummy.txt', 'text/plain', null, true);

$data = ['name' => 'English', 'code' => 'ENG', 'medium_id' => 1, 'type' => 'Core', 'bg_color' => '#2E447E', 'image' => $file];

try {
    $repo->create($data);
    echo "Created successfully!
";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}
