import paramiko
import re

def get_latest_error():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')
    stdin, stdout, stderr = ssh.exec_command('tail -n 100 /home/sarthakedge/htdocs/sarthakedge.com/php_code_live/storage/logs/laravel.log')
    content = stdout.read().decode('utf-8', errors='replace')
    
    # Find all production.ERROR blocks
    errors = re.findall(r'\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] production\.ERROR:.*?(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|$)', content, re.DOTALL)
    if errors:
        latest_error = errors[-1]
        print("LATEST ERROR:")
        print(latest_error)
    else:
        print("No errors found in the last 100 lines.")
    ssh.close()

if __name__ == "__main__":
    get_latest_error()
