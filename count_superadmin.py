import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    d = "php_code"
    REMOTE_BASE = f"/home/sarthakedge/htdocs/sarthakedge.com/{d}"
    
    # Check for multiple users with same email
    script = "\\App\\Models\\User::where('email', 'superadmin@gmail.com')->count()"
    cmd = f"cd {REMOTE_BASE} && php8.1 artisan tinker --execute=\"echo {script};\""
    stdin, stdout, stderr = ssh.exec_command(cmd)
    print("Count: " + stdout.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
