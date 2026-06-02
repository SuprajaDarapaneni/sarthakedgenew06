import paramiko
from scp import SCPClient

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
    if ($user) {
        $res = [
            'id' => $user->id,
            'email' => $user->email,
            'school_id' => $user->school_id,
            'status' => $user->status,
            'deleted_at' => $user->deleted_at,
            'two_factor_enabled' => $user->two_factor_enabled,
            'password_match' => \\Hash::check('superadmin', $user->password)
        ];
        echo json_encode($res);
    } else {
        echo "User not found";
    }
    """
    
    # Run via tinker --execute
    cmd = f"cd {REMOTE_BASE} && php8.1 artisan tinker --execute=\"{script}\""
    stdin, stdout, stderr = ssh.exec_command(cmd)
    
    print("STDOUT:")
    print(stdout.read().decode())
    print("STDERR:")
    print(stderr.read().decode())

    ssh.close()

if __name__ == "__main__":
    main()
