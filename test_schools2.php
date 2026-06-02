<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schools = DB::connection('mysql')->table('schools')->get();
$output = "";
foreach ($schools as $s) {
    $output .= "School ID: {$s->id}, Name: {$s->name}, admin_id: {$s->admin_id}, db: {$s->database_name}\n";
}
file_put_contents('schools.log', $output);
