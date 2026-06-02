<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$job = DB::table('failed_jobs')->orderBy('id', 'desc')->first();
if ($job) {
    echo "ID: " . $job->id . "\n";
    echo "Failed At: " . $job->failed_at . "\n";
    echo "Exception: \n" . $job->exception . "\n";
} else {
    echo "No failed jobs found.\n";
}
