<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Package;

$packages = Package::all();
foreach($packages as $p) {
    $subCount = $p->subscription()->count();
    echo "ID: " . $p->id . " | Name: " . $p->name . " | Subs: " . $subCount . "\n";
}
