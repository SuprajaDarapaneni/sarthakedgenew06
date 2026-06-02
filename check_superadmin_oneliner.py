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
    
    # Check super admin user in DB - single line
    script = "\\App\\Models\\User::where('email', 'superadmin@gmail.com')->get()->map(function(\$u){ return ['id'=>\$u->id, 'sid'=>\$u->school_id, 'status'=>\$u->status, '2fa'=>\$u->two_factor_enabled, 'pass'=>Hash::check('superadmin', \$u->password)]; })->toJson()"
    cmd = f"cd {REMOTE_BASE} && php8.1 artisan tinker --execute=\"echo {script};\""
    stdin, stdout, stderr = ssh.exec_command(cmd)
    print("STDOUT:")
    print(stdout.read().decode())
    print("STDERR:")
    print(stderr.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
