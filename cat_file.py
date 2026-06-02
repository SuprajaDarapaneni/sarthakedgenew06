import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    file_path = "/home/sarthakedge/htdocs/sarthakedge.com/php_code3/app/Http/Controllers/Controller.php"
    stdin, stdout, stderr = ssh.exec_command(f"grep -n 'file()->create' {file_path}")
    print(stdout.read().decode())
    print(stderr.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
