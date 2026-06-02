<?php
$env = file_get_contents('.env');
preg_match('/DB_HOST=(.*)/', $env, $m); $db_host = trim($m[1] ?? 'localhost');
preg_match('/DB_USERNAME=(.*)/', $env, $m); $db_user = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $env, $m); $db_pass = trim($m[1] ?? '');

$target_db = 'school_db';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$target_db", $db_user, $db_pass);
    $stmt = $pdo->query('SHOW TABLES');
    echo "TABLES_IN_SCHOOL_DB:\n";
    while ($row = $stmt->fetch()) {
        echo $row[0] . "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>