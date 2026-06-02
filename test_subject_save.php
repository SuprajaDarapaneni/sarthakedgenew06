<?php
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
DB::setDefaultConnection('school');
config(['database.connections.school.database' => 'eschool_saas_31_pandahighschool']);
DB::purge('school');
DB::connection('school')->reconnect();
\$data = [
    'name' => 'English',
    'code' => 'ENG',
    'medium_id' => 1,
    'type' => 'Core',
    'school_id' => 31
];
\$subject = new \App\Models\Subject();
\$subject->fill(\$data);
echo json_encode(\$subject->getAttributes());
