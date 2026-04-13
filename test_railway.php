<?php
$host = 'centerbeam.proxy.rlwy.net';
$port = 33455;
$db   = 'railway';
$user = 'root';
$pass = 'RyErAGSaxmSANxQaOUuWxyatvEyNIfrA';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => true,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "PDO initialized.\n";
     $stmt = $pdo->query('SELECT 1');
     echo "Query executed.\n";
     var_dump($stmt->fetchAll());
} catch (\PDOException $e) {
     echo "Failed at: " . $e->getFile() . ":" . $e->getLine() . "\n";
     echo "Connection failed: " . $e->getMessage() . "\n";
}
