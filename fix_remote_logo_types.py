import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')

php_code = """<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Http\\Kernel::class);
$kernel->handle(Illuminate\\Http\\Request::capture());

$logos = ['horizontal_logo', 'vertical_logo', 'favicon', 'login_page_logo'];
foreach ($logos as $name) {
    $setting = App\\Models\\SystemSetting::where('name', $name)->first();
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
        echo "Fixed $name | New Data: $data\\n";
    }
}
"""

sftp = ssh.open_sftp()
with sftp.open('/home/sarthakedge/htdocs/sarthakedge.com/php_code/fix_logo_types.php', 'w') as f:
    f.write(php_code)

stdin, stdout, stderr = ssh.exec_command('cd /home/sarthakedge/htdocs/sarthakedge.com/php_code && php8.1 fix_logo_types.php')
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
