import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    dirs = ["php_code", "php_code1", "php_code2", "php_code3"]
    files = [
        "app/Http/Controllers/TeacherController.php",
        "app/Http/Controllers/Controller.php",
        "app/Http/Controllers/StudentController.php",
        "app/Services/UserService.php"
    ]
    
    for d in dirs:
        REMOTE_BASE = f"/home/sarthakedge/htdocs/sarthakedge.com/{d}"
        print(f"--- Checking {d} ---")
        for f in files:
            cmd = f"php8.1 -l {REMOTE_BASE}/{f}"
            stdin, stdout, stderr = ssh.exec_command(cmd)
            out = stdout.read().decode().strip()
            err = stderr.read().decode().strip()
            if out: print(out)
            if err: print(f"ERROR: {err}")

    ssh.close()

if __name__ == "__main__":
    main()
