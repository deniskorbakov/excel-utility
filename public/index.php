
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="">
    <input type="text" placeholder="Введите искомое значение">
    <input type="text" placeholder="Введите искомое значение">
    <input type="text" placeholder="Введите строку на замену">

    <button>submit</button>
</form>
</body>
</html>

<?php
//Прочитать csv-файл в массив, обработать необходимую ячейку массива, и перезаписать csv-файл:

// Искомое значение
$need = 'вилка';
// Строка для замены
$repl = 'Большая вилка';
// Путь к csv-файлу
$csv_file = 'data/file.csv';

// Новый массив с данными для записи в csv-файл
$csv_new = [];

// Если файл доступен для чтения
if (($fp = fopen($csv_file, 'r')) !== false) {
    // Читать построчно, сохраняя каждую его строку во временный массив
    while (($arr = fgetcsv($fp, 1000, ',')) !== false) {
        // Если найдено искомое значение
        if (($k = array_search($need, $arr)) !== false) {
            // Перезаписать ячейку массива
            $arr[$k] = $repl;
        }
        // Сохранить временный массив в новый двумерный массив
        $csv_new[] = $arr;
    }
    fclose($fp);
}

// Если файл доступен для записи
if (($fp = fopen($csv_file, 'w')) !== false) {
    // Проходим по массиву
    foreach ($csv_new as $fields) {
        // И пишем данные в csv-файл
        fputcsv($fp, $fields);
    }
    fclose($fp);
}


