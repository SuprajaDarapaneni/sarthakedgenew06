<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$settings = App\Models\SystemSetting::whereIn('name', ['horizontal_logo', 'vertical_logo', 'favicon'])->get();
foreach ($settings as $setting) {
    echo "Name: " . $setting->name . "\n";
    echo "Data: " . $setting->data . "\n";
    echo "Type: " . $setting->type . "\n";
    echo "-------------------\n";
}
