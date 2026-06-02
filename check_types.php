<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$count = App\Models\SystemSetting::where('type', 'file')->count();
echo "Total file type settings: " . $count . "\n";

$logos = App\Models\SystemSetting::whereIn('name', ['horizontal_logo', 'vertical_logo', 'favicon', 'login_page_logo'])->get();
foreach ($logos as $logo) {
    echo "Name: " . $logo->name . " | Type: " . $logo->type . " | Data: " . $logo->getRawOriginal('data') . "\n";
}
