
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
<center>
    <form action="" method="POST">
        <div style="margin-top: 50px" class="input-wrapper">
            <input type="text" name="productName" placeholder="Введите название товара">
            <input type="text" name="formatName" placeholder="Введите формат товара">
            <input type="text" name="pathImg" placeholder="Введите путь для замены">
            <select name="selectSeparator">
                <option value=";">Разделить знаком - ( ; )</option>
                <option value="," selected>Разделить знаком - ( , )</option>
            </select>

        </div>

        <div style="margin-top: 20px;">
            <button style="padding: 10px; font-size: 20px; color: #8b2ae5; background-color: aqua; border: none;" type="submit">submit</button>
        </div>

    </form>
</center>
</body>
</html>

<?php

if (isset($_POST['productName'], $_POST['formatName'], $_POST['pathImg'], $_POST['selectSeparator'])) {
    // Открытие файла с данными
    $file = fopen('../tables/lioni.csv', 'r+');

// Чтение заголовков столбцов
    $headers = fgetcsv($file, null, $_POST['selectSeparator']);

// Инициализация массива для хранения данных таблицы
    $tableData = array();

// Чтение строк таблицы и добавление их в массив
    while ($row = fgetcsv($file, null, $_POST['selectSeparator'])) {
        $tableData[] = $row;
    }

// Закрытие файла
    fclose($file);

// Нахождение индекса столбца preview_picture
    $preview_picture_index = array_search('IE_PREVIEW_PICTURE', $headers);

// Нахождение индекса столбца detail_picture
    $detail_picture_index = array_search('IE_DETAIL_PICTURE', $headers);

// Изменение значений в столбцах preview_picture и detail_picture
    $count = 0;

    foreach ($tableData as &$row) {
        if ($row[array_search('IE_NAME', $headers)] == $_POST['productName'] && $row[array_search('IP_PROP1295', $headers)] ==  $_POST['formatName'] ) {
            $row[$preview_picture_index] = $_POST['pathImg'];
            $row[$detail_picture_index] = $_POST['pathImg'];

            $count++;
        }
    }

    if ($count == 0) {
        echo '<center style="margin-top: 30px;"> <h3>Не найдены товары</h3> </center>';
        exit();
    }

// Открытие файла для записи измененных данных
    $file = fopen('../tables/output.csv', 'r+');

// Запись заголовков столбцов
    fputcsv($file, $headers, $_POST['selectSeparator']);

// Запись измененных строк таблицы
    foreach ($tableData as $row) {
        fputcsv($file, $row,  $_POST['selectSeparator']);
    }

// Закрытие файла
    fclose($file);

    echo '<center style="margin-top: 30px;"> <h3>кол-во измененных записей</h3> - ' . $count . '</center>' ;

} else {
   echo '<center style="margin-top: 30px;"> <h3>Вставьте все данные</h3> </center>';
}



