
    <?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email from DO', function($msg) {
            $msg->to('support@sarthakedge.com')->subject('DO SMTP Test');
        });
        echo "SUCCESS: Email sent!
";
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "
";
    }
    
