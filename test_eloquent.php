<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $model = \App\Models\CertificateTemplate::on('school')->first();
    if ($model) {
        $model->update(['style' => ['test' => 'val']]);
        echo "SUCCESS";
    } else {
        echo "NO MODEL";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
