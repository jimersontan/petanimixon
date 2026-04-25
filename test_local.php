<?php
$host = '127.0.0.1';
$port = 3306;
$db   = 'pet_markt_ph';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "PDO initialized on local.\n";
     $stmt = $pdo->query('SELECT 1');
     echo "Query executed.\n";
     var_dump($stmt->fetchAll());
} catch (\PDOException $e) {
     echo "Failed at: " . $e->getFile() . ":" . $e->getLine() . "\n";
     echo "Connection failed: " . $e->getMessage() . "\n";
}
