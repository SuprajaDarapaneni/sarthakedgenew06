<?php
$env = file_get_contents('.env');
preg_match('/DB_HOST=(.*)/', $env, $m); $db_host = trim($m[1] ?? 'localhost');
preg_match('/DB_DATABASE=(.*)/', $env, $m); $db_name = trim($m[1] ?? '');
preg_match('/DB_USERNAME=(.*)/', $env, $m); $db_user = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $env, $m); $db_pass = trim($m[1] ?? '');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $stmt = $pdo->query('SHOW TABLES');
    echo "FULL_TABLES_LIST:\n";
    $count = 0;
    while ($row = $stmt->fetch()) {
        echo $row[0] . "\n";
        $count++;
        if ($count > 100) break;
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>