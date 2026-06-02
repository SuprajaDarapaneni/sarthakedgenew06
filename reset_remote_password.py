import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')

php_code = """<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Http\\Kernel::class);
$kernel->handle(Illuminate\\Http\\Request::capture());

$user = App\\Models\\User::where('email', 'superadmin@gmail.com')->first();
if ($user) {
    $user->password = Hash::make('superadmin');
    $user->save();
    echo "Password RESET for superadmin@gmail.com to 'superadmin'\\n";
} else {
    echo "User NOT FOUND\\n";
}
"""

sftp = ssh.open_sftp()
with sftp.open('/home/sarthakedge/htdocs/sarthakedge.com/php_code/reset_password.php', 'w') as f:
    f.write(php_code)

stdin, stdout, stderr = ssh.exec_command('cd /home/sarthakedge/htdocs/sarthakedge.com/php_code && php8.1 reset_password.php')
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
