<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Від'ємний баланс</title>
</head>
<body>

<h1>Клієнти з від'ємним балансом</h1>
<a href="index.php">← Назад</a>

<?php
$sql = "SELECT id_client, name, login, ip, balance
        FROM client
        WHERE balance < 0
        ORDER BY balance ASC";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) === 0) {
    echo "<p>Клієнтів з від'ємним балансом не знайдено.</p>";
} else {
    echo "<table border='1' cellpadding='5'>
        <tr>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Логін</th>
            <th>IP</th>
            <th>Баланс</th>
        </tr>";
    foreach ($rows as $row) {
        echo "<tr>
            <td>{$row['id_client']}</td>
            <td>{$row['name']}</td>
            <td>{$row['login']}</td>
            <td>{$row['ip']}</td>
            <td>{$row['balance']}</td>
        </tr>";
    }
    echo "</table>";
    echo "<p>Знайдено клієнтів: " . count($rows) . "</p>";
}
?>

</body>
</html>