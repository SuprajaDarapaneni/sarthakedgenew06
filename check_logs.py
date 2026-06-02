import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    dirs = ["php_code", "php_code1", "php_code2", "php_code3"]
    
    with open("log_results.txt", "w") as f:
        for d in dirs:
            log_path = f"/home/sarthakedge/htdocs/sarthakedge.com/{d}/storage/logs/laravel.log"
            f.write(f"--- Logs for {d} ---\n")
            stdin, stdout, stderr = ssh.exec_command(f"tail -n 50 {log_path}")
            f.write(stdout.read().decode())
            f.write(stderr.read().decode())
            f.write("\n")

    ssh.close()

if __name__ == "__main__":
    main()
