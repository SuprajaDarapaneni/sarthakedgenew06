<?php
$env = file_get_contents('.env');
preg_match('/DB_HOST=(.*)/', $env, $m); $db_host = trim($m[1] ?? 'localhost');
preg_match('/DB_USERNAME=(.*)/', $env, $m); $db_user = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $env, $m); $db_pass = trim($m[1] ?? '');
$db_name = 'sarthakedge_project';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $stmt = $pdo->query("SHOW TABLES LIKE 'se_leave_masters'");
    echo "SE_LEAVE_MASTERS_EXISTS: " . ($stmt->fetch() ? 'YES' : 'NO') . "\n";
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'leave_masters'");
    echo "LEAVE_MASTERS_EXISTS: " . ($stmt->fetch() ? 'YES' : 'NO') . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>