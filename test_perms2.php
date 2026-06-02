<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (Spatie\Permission\Models\Permission::where('name', 'like', '%medium-list%')->get() as $p) {
    echo $p->id . ' | ' . $p->name . ' | ' . $p->guard_name . "\n";
}
