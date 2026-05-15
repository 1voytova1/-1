<?php
$dsn = "sqlite:" . __DIR__ . "/netstat.db";
$options = [
    PDO::ATTR_PERSISTENT => true,
];

try {
    $dbh = new PDO($dsn, null, null, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Помилка підключення: " . $e->getMessage());
}