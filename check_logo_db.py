import paramiko

def run_tinker(command):
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')
    
    # Escape single quotes for the artisan command
    tinker_cmd = f'php /home/sarthakedge/htdocs/sarthakedge.com/php_code_live/artisan tinker --execute="{command}"'
    stdin, stdout, stderr = ssh.exec_command(tinker_cmd)
    
    out = stdout.read().decode()
    err = stderr.read().decode()
    ssh.close()
    return out, err

out, err = run_tinker("print_r(App\\Models\\School::pluck('domain', 'name')->toArray());")
print("OUTPUT:", out)
print("ERROR:", err)
