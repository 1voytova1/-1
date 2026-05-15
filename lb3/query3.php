<?php

ob_start();
include 'db.php';
ob_clean();

header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT id_client, name, login, ip, balance
        FROM client
        WHERE balance < 0
        ORDER BY balance ASC";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows, JSON_UNESCAPED_UNICODE);