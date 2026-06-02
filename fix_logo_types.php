<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$logos = ['horizontal_logo', 'vertical_logo', 'favicon', 'login_page_logo'];
foreach ($logos as $name) {
    $setting = App\Models\SystemSetting::where('name', $name)->first();
    if ($setting) {
        $setting->type = 'file';
        // Clean up data if it contains full URL
        $data = $setting->getRawOriginal('data');
        if (strpos($data, 'http') === 0) {
            $parts = explode('/storage/', $data);
            if (count($parts) > 1) {
                $data = $parts[1];
            }
        }
        $setting->data = $data;
        $setting->save();
        echo "Fixed $name | New Data: $data\n";
    }
}
