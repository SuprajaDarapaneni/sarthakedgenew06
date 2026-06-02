import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')

stdin, stdout, stderr = ssh.exec_command('cat /home/sarthakedge/htdocs/sarthakedge.com/php_code/.env')
print(stdout.read().decode())

ssh.close()
