<?php
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
DB::setDefaultConnection('school');
config(['database.connections.school.database' => 'eschool_saas_31_pandahighschool']);
DB::purge('school');
DB::connection('school')->reconnect();
\$user = \App\Models\User::on('mysql')->find(82);
Auth::login(\$user);

\$request = \Illuminate\Http\Request::create('/subjects', 'POST', [
    'name' => 'English',
    'code' => 'ENG',
    'medium_id' => 1,
    'type' => 'Core',
    'class_id' => [1],
    'teacher_id' => 82,
    'periods_per_week' => 5
]);

\$controller = app(\App\Http\Controllers\SubjectController::class);
\$response = \$controller->store(\$request);
echo \$response->getContent();
