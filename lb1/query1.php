<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сеанси клієнта</title>
</head>
<body>

<h1>Сеанси роботи клієнта</h1>
<a href="index.php">← Назад</a>

<?php
$client_id = $_GET['client_id'] ?? null;

if ($client_id === null) {
    echo "<p>Не вказано клієнта.</p>";
    exit;
}

$stmt = $dbh->prepare("SELECT name, login FROM client WHERE id_client = :id");
$stmt->bindValue(':id', $client_id, PDO::PARAM_INT);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    echo "<p>Клієнта не знайдено.</p>";
    exit;
}

echo "<h2>Клієнт: {$client['name']} ({$client['login']})</h2>";


$sql = "SELECT id_seanse, start, stop, in_traffic, out_traffic
        FROM seanse
        WHERE fid_client = :id
        ORDER BY start";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $client_id, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) === 0) {
    echo "<p>Сеансів не знайдено.</p>";
} else {
    echo "<table border='1' cellpadding='5'>
        <tr>
            <th>ID</th>
            <th>Початок</th>
            <th>Кінець</th>
            <th>Вхідний трафік (KB)</th>
            <th>Вихідний трафік (KB)</th>
        </tr>";
    foreach ($rows as $row) {
        echo "<tr>
            <td>{$row['id_seanse']}</td>
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