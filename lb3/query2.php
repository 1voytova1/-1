<?php


ob_start();
include 'db.php';
ob_clean();

header('Content-Type: application/xml; charset=utf-8');

$time_from = $_GET['time_from'] ?? null;
$time_to   = $_GET['time_to']   ?? null;

echo '<?xml version="1.0" encoding="UTF-8"?>';

if (!$time_from || !$time_to) {
    echo '<response><error>Не вказано часовий проміжок.</error></response>';
    exit;
}

$sql = "SELECT s.id_seanse, s.start, s.stop, s.in_traffic, s.out_traffic,
               c.name AS client_name, c.login
        FROM seanse s
        JOIN client c ON s.fid_client = c.id_client
        WHERE s.start >= :time_from AND s.stop <= :time_to
        ORDER BY s.start";

$stmt = $dbh->prepare($sql);
$stmt->bindValue(':time_from', $time_from, PDO::PARAM_STR);
$stmt->bindValue(':time_to',   $time_to,   PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<response>';

if (count($rows) === 0) {
    echo '<error>Сеансів не знайдено.</error>';
} else {
    foreach ($rows as $row) {
        echo '<seanse>';
        echo '<id_seanse>'   . htmlspecialchars($row['id_seanse'])    . '</id_seanse>';
        echo '<client_name>' . htmlspecialchars($row['client_name'])  . '</client_name>';
        echo '<login>'       . htmlspecialchars($row['login'])        . '</login>';
        echo '<start>'       . htmlspecialchars($row['start'])        . '</start>';
        echo '<stop>'        . htmlspecialchars($row['stop'])         . '</stop>';
        echo '<in_traffic>'  . htmlspecialchars($row['in_traffic'])   . '</in_traffic>';
        echo '<out_traffic>' . htmlspecialchars($row['out_traffic'])  . '</out_traffic>';
        echo '</seanse>';
    }
}

echo '</response>';