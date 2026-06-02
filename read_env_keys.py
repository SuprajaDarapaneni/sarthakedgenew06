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
    
    # Read specific keys from .env
    cmd = f"grep -E 'APP_URL|SESSION_DOMAIN|DB_DATABASE|DB_USERNAME' {REMOTE_BASE}/.env"
    stdin, stdout, stderr = ssh.exec_command(cmd)
    print(stdout.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
