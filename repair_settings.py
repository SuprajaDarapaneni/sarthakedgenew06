import paramiko
from scp import SCPClient

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    dirs = ["php_code", "php_code1", "php_code2", "php_code3"]
    
    # Files to upload
    files_to_upload = [
        (r"app\Http\Controllers\SystemSettingsController.php", "app/Http/Controllers/SystemSettingsController.php")
    ]

    for d in dirs:
        REMOTE_BASE = f"/home/sarthakedge/htdocs/sarthakedge.com/{d}"
        print(f"--- Processing {REMOTE_BASE} ---")
        
        # Upload files
        with SCPClient(ssh.get_transport()) as scp:
            for local_rel, remote_rel in files_to_upload:
                local_path = f"e:\\WORKS\\sarthakedgenewcode-final\\{local_rel}"
                remote_path = f"{REMOTE_BASE}/{remote_rel}"
                try:
                    scp.put(local_path, remote_path)
                    print(f"Uploaded {remote_rel}")
                except Exception as e:
                    print(f"Failed to upload {remote_rel}: {e}")

        # Commands to run
        cmds = [
            f"cd {REMOTE_BASE} && php8.1 artisan optimize:clear",
            f"cd {REMOTE_BASE} && php8.1 artisan storage:link",
            "curl -s https://sarthakedge.com/clear_opcache.php"
        ]
        
        for cmd in cmds:
            stdin, stdout, stderr = ssh.exec_command(cmd)
            stdout.read() # Wait for completion
            print(f"Executed: {cmd[:50]}...")

    ssh.close()
    print("Repair and deployment complete.")

if __name__ == "__main__":
    main()
