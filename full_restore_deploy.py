import os
import zipfile
import paramiko
from scp import SCPClient
import time

HOST = "72.61.237.199"
USER = "sarthakedge"
PASS = "Sarthakedge@2025"
REMOTE_DIR = "/home/sarthakedge/htdocs/sarthakedge.com/php_code_live"
LOCAL_DIR = r"e:\WORKS\sarthakedgenewcode-final"

def zip_project(output_filename):
    print("Zipping project...")
    exclude_dirs = {'.git', 'vendor', 'node_modules', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs', 'public/storage'}
    exclude_files = {output_filename, '.env'}
    
    count = 0
    with zipfile.ZipFile(output_filename, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk(LOCAL_DIR):
            rel_path = os.path.relpath(root, LOCAL_DIR)
            
            # Skip excluded directories
            if rel_path != '.':
                normalized_rel = rel_path.replace('\\', '/')
                if any(normalized_rel == d or normalized_rel.startswith(d + '/') for d in exclude_dirs):
                    continue
            
            for file in files:
                if file in exclude_files:
                    continue
                
                full_path = os.path.join(root, file)
                file_rel_path = os.path.join(rel_path, file)
                
                # Double check file exclusion
                normalized_file_rel = file_rel_path.replace('\\', '/')
                if any(normalized_file_rel == d or normalized_file_rel.startswith(d + '/') for d in exclude_dirs):
                    continue
                    
                zipf.write(full_path, file_rel_path)
                count += 1
                if count % 500 == 0:
                    print(f"Added {count} files...")
                    
    print(f"Zipping complete. Total files: {count}")

def deploy():
    zip_file = "project_restore.zip"
    zip_project(zip_file)
    
    size_mb = os.path.getsize(zip_file) / (1024 * 1024)
    print(f"Zip file size: {size_mb:.2f} MB")
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, username=USER, password=PASS)
    
    print(f"Creating remote directory {REMOTE_DIR}...")
    ssh.exec_command(f"mkdir -p {REMOTE_DIR}")
    
    print("Uploading zip...")
    with SCPClient(ssh.get_transport()) as scp:
        scp.put(zip_file, f"{REMOTE_DIR}/{zip_file}")
    
    print("Extracting zip...")
    stdin, stdout, stderr = ssh.exec_command(f"cd {REMOTE_DIR} && unzip -o {zip_file}")
    stdout.read() # Wait
    ssh.exec_command(f"rm {REMOTE_DIR}/{zip_file}")
    
    print("Copying .env from php_code1...")
    ssh.exec_command(f"cp /home/sarthakedge/htdocs/sarthakedge.com/php_code1/.env {REMOTE_DIR}/.env")
    
    print("Running composer install (this may take a while)...")
    stdin, stdout, stderr = ssh.exec_command(f"cd {REMOTE_DIR} && composer install --no-dev --optimize-autoloader")
    # Stream output
    while not stdout.channel.exit_status_ready():
        if stdout.channel.recv_ready():
            print(stdout.channel.recv(1024).decode(), end='')
    print(stdout.read().decode())
    print(stderr.read().decode())
    
    print("Setting permissions...")
    ssh.exec_command(f"chmod -R 775 {REMOTE_DIR}/storage {REMOTE_DIR}/bootstrap/cache")
    
    print("Fixing storage symlink...")
    ssh.exec_command(f"rm -rf {REMOTE_DIR}/public/storage")
    ssh.exec_command(f"ln -s {REMOTE_DIR}/storage/app/public {REMOTE_DIR}/public/storage")
    
    print("Clearing cache...")
    ssh.exec_command(f"cd {REMOTE_DIR} && php8.1 artisan optimize:clear")
    
    print("Switching live symlink...")
    # Update php_code to point to php_code_live
    ssh.exec_command("rm /home/sarthakedge/htdocs/sarthakedge.com/php_code")
    ssh.exec_command(f"ln -s {REMOTE_DIR} /home/sarthakedge/htdocs/sarthakedge.com/php_code")
    
    print("Checking if live...")
    stdin, stdout, stderr = ssh.exec_command("ls -l /home/sarthakedge/htdocs/sarthakedge.com/php_code")
    print(stdout.read().decode())

    ssh.close()
    os.remove(zip_file)
    print("Restoration and Deployment complete!")

if __name__ == "__main__":
    deploy()
