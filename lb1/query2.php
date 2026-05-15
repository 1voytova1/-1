<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сеанси за часом</title>
</head>
<body>

<h1>Сеанси за вказаний проміжок часу</h1>
<a href="index.php">← Назад</a>

<?php
$time_from = $_GET['time_from'] ?? null;
$time_to   = $_GET['time_to']   ?? null;

if (!$time_from || !$time_to) {
    echo "<p>Не вказано часовий проміжок.</p>";
    exit;
}

echo "<h2>Сеанси з {$time_from} до {$time_to}</h2>";

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

if (count($rows) === 0) {
    echo "<p>Сеансів не знайдено.</p>";
} else {
    echo "<table border='1' cellpadding='5'>
        <tr>
            <th>ID</th>
            <th>Клієнт</th>
            <th>Логін</th>
            <th>Початок</th>
            <th>Кінець</th>
            <th>Вхідний (KB)</th>
            <th>Вихідний (KB)</th>
        </tr>";
    foreach ($rows as $row) {
        echo "<tr>
            <td>{$row['id_seanse']}</td>
            <td>{$row['client_name']}</td>
            <td>{$row['login']}</td>
            <td>{$row['start']}</td>
            <td>{$row['stop']}</td>
            <td>{$row['in_traffic']}</td>
            <td>{$row['out_traffic']}</td>
        </tr>";
    }
    echo "</table>";
    echo "<p>Знайдено записів: " . count($rows) . "</p>";
}
?>

</body>
</html>