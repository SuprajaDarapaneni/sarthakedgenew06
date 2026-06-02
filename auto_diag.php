<?php
$env = file_get_contents('.env');
preg_match('/DB_HOST=(.*)/', $env, $m); $db_host = trim($m[1] ?? 'localhost');
preg_match('/DB_DATABASE=(.*)/', $env, $m); $db_name = trim($m[1] ?? '');
preg_match('/DB_USERNAME=(.*)/', $env, $m); $db_user = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $env, $m); $db_pass = trim($m[1] ?? '');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $stmt = $pdo->query('SHOW TABLES');
    echo "TABLES:\n";
    while ($row = $stmt->fetch()) {
        echo $row[0] . "\n";
    }
    
    $email = 'admin@gmail.com';
    $stmt = $pdo->prepare('SELECT id, first_name, school_id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    echo "\nUSER_INFO: " . ($user ? "ID:" . $user['id'] . " SCHOOL:" . ($user['school_id'] ?? 'NULL') . " NAME:" . $user['first_name'] : "NOT FOUND") . "\n";

    // Also check for prefix se_
    $stmt = $pdo->query("SHOW TABLES LIKE 'se_users'");
    echo "SE_USERS_EXISTS: " . ($stmt->fetch() ? 'YES' : 'NO') . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>