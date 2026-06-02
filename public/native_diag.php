<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=sarthakedge25', 'sarthakedge', 'Sarthakedge@2025');
    $stmt = $pdo->query('SHOW TABLES');
    while ($row = $stmt->fetch()) {
        echo $row[0] . "\n";
    }
    
    // Also check for the specific user
    $email = 'admin@gmail.com';
    $stmt = $pdo->prepare('SELECT id, first_name, school_id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    echo "\nUSER_INFO: " . ($user ? "ID:" . $user['id'] . " SCHOOL:" . ($user['school_id'] ?? 'NULL') . " NAME:" . $user['first_name'] : "NOT FOUND") . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>