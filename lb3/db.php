<?php
$host = "localhost";
$database = "lb_pdo_netstat";
$username = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$database;charset=utf8";
$options = [
    PDO::ATTR_PERSISTENT => true,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
];

try {
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => $e->getMessage()]));
}