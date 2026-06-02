import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    cmds = [
        "ls -la /home/sarthakedge/htdocs/sarthakedge.com/php_code1/packages",
        "find /home/sarthakedge/htdocs/sarthakedge.com/ -type d -name 'packages' 2>/dev/null",
        "grep -A 10 'repositories' /home/sarthakedge/htdocs/sarthakedge.com/php_code1/composer.json"
    ]
    
    for cmd in cmds:
        print(f"--- Running: {cmd} ---")
        stdin, stdout, stderr = ssh.exec_command(cmd)
        print(stdout.read().decode())
        err = stderr.read().decode()
        if err:
            print("ERR:", err)

    ssh.close()

if __name__ == "__main__":
    main()
