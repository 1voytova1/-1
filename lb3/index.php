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
<form>
    <label>Клієнт:
        <select id="client_id">
            <?php
            $stmt = $dbh->query("SELECT id_client, name, login FROM client ORDER BY name");
            foreach ($stmt as $row) {
                echo "<option value=\"{$row['id_client']}\">{$row['name']} ({$row['login']})</option>";
            }
            ?>
        </select>
    </label>
    <button type="button" onclick="loadQuery1()">Показати</button>
</form>
<div id="result1"></div>

<hr>


<h2>2. Сеанси за вказаний проміжок часу</h2>
<form>
    <label>Від: <input type="time" id="time_from" value="08:00"></label>
    <label>До: <input type="time" id="time_to" value="18:00"></label>
    <button type="button" onclick="loadQuery2()">Показати</button>
</form>
<div id="result2"></div>

<hr>

<h2>3. Клієнти з від'ємним балансом</h2>
<button type="button" onclick="loadQuery3()">Показати</button>
<div id="result3"></div>

<script>
function loadQuery1() {
    var clientId = document.getElementById('client_id').value;
    var cacheKey = 'query1_' + clientId;
    var cached = localStorage.getItem(cacheKey);

    if (cached !== null) {
        document.getElementById('result1').innerHTML = cached;
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'query1.php?client_id=' + encodeURIComponent(clientId), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                localStorage.setItem(cacheKey, xhr.responseText);
                document.getElementById('result1').innerHTML = xhr.responseText;
            } else {
                document.getElementById('result1').innerHTML = '<p>Помилка запиту.</p>';
            }
        }
    };
    xhr.send();
}


function loadQuery2() {
    var timeFrom = document.getElementById('time_from').value;
    var timeTo   = document.getElementById('time_to').value;
    var cacheKey = 'query2_' + timeFrom + '_' + timeTo;
    var cached = localStorage.getItem(cacheKey);

    if (cached !== null) {
        document.getElementById('result2').innerHTML = cached;
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'query2.php?time_from=' + encodeURIComponent(timeFrom) + '&time_to=' + encodeURIComponent(timeTo), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var xml = xhr.responseXML;
                var container = document.getElementById('result2');

                if (!xml) {
                    container.innerHTML = '<p>Помилка розбору XML.</p>';
                    return;
                }

                var error = xml.querySelector('error');
                if (error) {
                    container.innerHTML = '<p>' + error.textContent + '</p>';
                    return;
                }

                var sessions = xml.querySelectorAll('seanse');
                if (sessions.length === 0) {
                    container.innerHTML = '<p>Сеансів не знайдено.</p>';
                    return;
                }

                var html = '<table border="1" cellpadding="5">'
                         + '<tr><th>ID</th><th>Клієнт</th><th>Логін</th><th>Початок</th><th>Кінець</th><th>Вхідний (KB)</th><th>Вихідний (KB)</th></tr>';

                sessions.forEach(function (s) {
                    function val(tag) {
                        var el = s.querySelector(tag);
                        return el ? el.textContent : '';
                    }
                    html += '<tr>'
                          + '<td>' + val('id_seanse')    + '</td>'
                          + '<td>' + val('client_name')  + '</td>'
                          + '<td>' + val('login')        + '</td>'
                          + '<td>' + val('start')        + '</td>'
                          + '<td>' + val('stop')         + '</td>'
                          + '<td>' + val('in_traffic')   + '</td>'
                          + '<td>' + val('out_traffic')  + '</td>'
                          + '</tr>';
                });

                html += '</table>';
                html += '<p>Знайдено записів: ' + sessions.length + '</p>';

                localStorage.setItem(cacheKey, html);
                container.innerHTML = html;
            } else {
                document.getElementById('result2').innerHTML = '<p>Помилка запиту.</p>';
            }
        }
    };
    xhr.send();
}


function loadQuery3() {
    var cacheKey = 'query3';
    var cached = localStorage.getItem(cacheKey);

    if (cached !== null) {
        document.getElementById('result3').innerHTML = cached;
        return;
    }

    fetch('query3.php')
        .then(function (response) {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.text();
        })
        .then(function (text) {
            var data = JSON.parse(text);
            var container = document.getElementById('result3');

            if (data.error) {
                container.innerHTML = '<p>' + data.error + '</p>';
                return;
            }

            if (data.length === 0) {
                container.innerHTML = '<p>Клієнтів з від\'ємним балансом не знайдено.</p>';
                return;
            }

            var html = '<table border="1" cellpadding="5">'
                     + '<tr><th>ID</th><th>Ім\'я</th><th>Логін</th><th>IP</th><th>Баланс</th></tr>';

            data.forEach(function (row) {
                html += '<tr>'
                      + '<td>' + row.id_client + '</td>'
                      + '<td>' + row.name      + '</td>'
                      + '<td>' + row.login     + '</td>'
                      + '<td>' + row.ip        + '</td>'
                      + '<td>' + row.balance   + '</td>'
                      + '</tr>';
            });

            html += '</table>';
            html += '<p>Знайдено клієнтів: ' + data.length + '</p>';

            localStorage.setItem(cacheKey, html);
            container.innerHTML = html;
        })
        .catch(function (err) {
            document.getElementById('result3').innerHTML = '<p>Помилка: ' + err.message + '</p>';
        });
}
</script>

</body>
</html>