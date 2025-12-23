<?php
// Два довільні цілочисленні масиви
$array1 = [1, 2, 3, 4, 5, 3, 2, 7, 8];
$array2 = [4, 5, 6, 7, 7, 8, 9, 4];

// Прибрати дублікати в кожному масиві
$array1_unique = array_values(array_unique($array1));
$array2_unique = array_values(array_unique($array2));

// Кількість дублюючих елементів двох масивів
$duplicates_between = array_intersect($array1_unique, $array2_unique);
$duplicates_count = count($duplicates_between);

// Злиття двох масивів без дублювань
$merged_unique = array_values(array_unique(array_merge($array1_unique, $array2_unique)));

// Реверс масиву через foreach (без array_reverse)
$reversed = [];
foreach ($merged_unique as $value) {
    array_unshift($reversed, $value);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна робота 4</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #2c3e50; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>

<h2>Початкові масиви</h2>
<pre>
Масив 1: <?php print_r($array1); ?>
Масив 2: <?php print_r($array2); ?>
</pre>

<h2>Масиви без дублікатів</h2>
<pre>
Масив 1: <?php print_r($array1_unique); ?>
Масив 2: <?php print_r($array2_unique); ?>
</pre>

<h2>Кількість спільних (дублюючих) елементів</h2>
<p><?= $duplicates_count ?></p>

<h2>Об’єднаний масив без дублікатів</h2>
<pre><?php print_r($merged_unique); ?></pre>

<h2>Масив зі зміненим порядком елементів (foreach)</h2>
<pre><?php print_r($reversed); ?></pre>

</body>
</html>
