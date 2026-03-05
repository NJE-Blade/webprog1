<?php
$charset = 'utf8mb4';

// A konstansokat összefűzéssel illesztjük a DSN-be
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . $charset;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $db = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
     die("Adatbázis csatlakozási hiba: " . $e->getMessage());
}
?>