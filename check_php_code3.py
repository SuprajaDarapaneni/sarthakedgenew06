import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    REMOTE_FILE = "/home/sarthakedge/htdocs/sarthakedge.com/php_code3/app/Http/Controllers/TeacherController.php"
    print(f"--- Checking {REMOTE_FILE} ---")
    cmd = f"php8.1 -l {REMOTE_FILE}"
    stdin, stdout, stderr = ssh.exec_command(cmd)
    print(f"STDOUT: {stdout.read().decode()}")
    print(f"STDERR: {stderr.read().decode()}")
    
    print("--- Head of file ---")
    cmd = f"head -c 20 {REMOTE_FILE} | od -t x1"
    stdin, stdout, stderr = ssh.exec_command(cmd)
    print(stdout.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
