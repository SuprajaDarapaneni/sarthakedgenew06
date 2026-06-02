<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Repositories\Medium\MediumInterface;
use App\Repositories\Section\SectionInterface;

$mediumRepo = app(MediumInterface::class);
$sectionRepo = app(SectionInterface::class);

echo "Mediums Count: " . $mediumRepo->builder()->count() . "\n";
echo "Sections Count: " . $sectionRepo->builder()->count() . "\n";

foreach ($mediumRepo->builder()->get() as $m) {
    echo "Medium: " . $m->name . " (ID: " . $m->id . ")\n";
}
foreach ($sectionRepo->builder()->get() as $s) {
    echo "Section: " . $s->name . " (ID: " . $s->id . ")\n";
}
