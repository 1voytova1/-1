<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Мережевий трафік</title>
</head>
<body>

<h1>Мережевий трафік — Варіант 7</h1>

<hr>

<h2>1. Сеанси роботи для обраного клієнта</h2>
<form action="query1.php" method="get">
    <label>Клієнт:
        <select name="client_id">
            <?php
            $stmt = $dbh->query("SELECT id_client, name, login FROM client ORDER BY name");
            foreach ($stmt as $row) {
                echo "<option value=\"{$row['id_client']}\">{$row['name']} ({$row['login']})</option>";
            }
            ?>
        </select>
    </label>
    <button type="submit">Показати</button>
</form>

<hr>


<h2>2. Сеанси за вказаний проміжок часу</h2>
<form action="query2.php" method="get">
    <label>Від: <input type="time" name="time_from" value="08:00"></label>
    <label>До: <input type="time" name="time_to" value="18:00"></label>
    <button type="submit">Показати</button>
</form>

<hr>

<h2>3. Клієнти з від'ємним балансом</h2>
<form action="query3.php" method="get">
    <button type="submit">Показати</button>
</form>

</body>
</html>