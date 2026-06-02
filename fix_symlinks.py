import paramiko

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    dirs = ["php_code", "php_code1", "php_code2", "php_code3"]
    
    for d in dirs:
        REMOTE_BASE = f"/home/sarthakedge/htdocs/sarthakedge.com/{d}"
        print(f"--- Fixing symlinks in {REMOTE_BASE} ---")
        
        # Remove old symlink
        ssh.exec_command(f"rm {REMOTE_BASE}/public/storage")
        
        # Create correct absolute symlink
        target = f"{REMOTE_BASE}/storage/app/public"
        link = f"{REMOTE_BASE}/public/storage"
        cmd = f"ln -s {target} {link}"
        stdin, stdout, stderr = ssh.exec_command(cmd)
        stdout.read()
        print(f"Created symlink: {link} -> {target}")

        # Clear cache
        ssh.exec_command(f"cd {REMOTE_BASE} && php8.1 artisan optimize:clear")
        print("Cleared cache.")

    ssh.close()
    print("Symlink fix complete.")

if __name__ == "__main__":
    main()
