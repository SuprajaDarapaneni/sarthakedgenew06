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
    
    script = """
    $user = \\App\\Models\\User::where('email', 'superadmin@gmail.com')->first();
    echo "ID: " . $user->id . "\\n";
    echo "Email: " . $user->email . "\\n";
    echo "Password Hash: " . $user->password . "\\n";
    echo "Hash Check 'superadmin': " . (\\Hash::check('superadmin', $user->password) ? 'TRUE' : 'FALSE') . "\\n";
    echo "Is Active/Status: " . $user->status . "\\n";
    echo "Deleted At: " . $user->deleted_at . "\\n";
    echo "Two Factor Enabled: " . $user->two_factor_enabled . "\\n";
    """
    
    cmd = f"cd {REMOTE_BASE} && php8.1 artisan tinker --execute=\"{script}\""
    stdin, stdout, stderr = ssh.exec_command(cmd)
    
    print("STDOUT:")
    print(stdout.read().decode())
    print("STDERR:")
    print(stderr.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
