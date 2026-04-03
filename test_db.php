<?php
try {
    $pdo = new PDO('mysql:host=centerbeam.proxy.rlwy.net;port=33455;dbname=railway', 'root', 'RyErAGSaxmSANxQaOUuWxyatvEyNIfrA');
    echo 'CONNECTED';
} catch (PDOException $e) {
    echo 'FAILED: ' . $e->getMessage();
}
