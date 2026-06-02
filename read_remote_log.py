import paramiko
import sys

def read_remote_log(n=50):
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')
    stdin, stdout, stderr = ssh.exec_command(f'tail -n {n} /home/sarthakedge/htdocs/sarthakedge.com/php_code_live/storage/logs/laravel.log')
    content = stdout.read().decode('utf-8', errors='replace')
    print(content)
    ssh.close()

if __name__ == "__main__":
    n = int(sys.argv[1]) if len(sys.argv) > 1 else 50
    read_remote_log(n)
