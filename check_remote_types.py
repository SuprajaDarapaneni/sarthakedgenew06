import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')

php_code = """<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Http\\Kernel::class);
$kernel->handle(Illuminate\\Http\\Request::capture());

$count = App\\Models\\SystemSetting::where('type', 'file')->count();
echo "Total file type settings: " . $count . "\\n";

$logos = App\\Models\\SystemSetting::whereIn('name', ['horizontal_logo', 'vertical_logo', 'favicon', 'login_page_logo'])->get();
foreach ($logos as $logo) {
    echo "Name: " . $logo->name . " | Type: " . $logo->type . " | Data: " . $logo->getRawOriginal('data') . "\\n";
}
"""

sftp = ssh.open_sftp()
with sftp.open('/home/sarthakedge/htdocs/sarthakedge.com/php_code/check_types.php', 'w') as f:
    f.write(php_code)

stdin, stdout, stderr = ssh.exec_command('cd /home/sarthakedge/htdocs/sarthakedge.com/php_code && php8.1 check_types.php')
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
