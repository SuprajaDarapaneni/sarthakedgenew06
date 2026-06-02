import paramiko
import os

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
    echo "User FOUND: " . $user->email . "\\n";
    echo "ID: " . $user->id . "\\n";
    echo "Password Hash: " . $user->password . "\\n";
} else {
    echo "User NOT FOUND\\n";
}
"""

sftp = ssh.open_sftp()
with sftp.open('/home/sarthakedge/htdocs/sarthakedge.com/php_code/check_user_remote.php', 'w') as f:
    f.write(php_code)

stdin, stdout, stderr = ssh.exec_command('cd /home/sarthakedge/htdocs/sarthakedge.com/php_code && php8.1 check_user_remote.php')
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
