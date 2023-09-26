
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
        <div>
            <button class="add-button" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #80109f; border: none;" type="button">Добавить еще поля</button>
        </div>

        <div style="margin-top: 30px">
            <input type="text" name="productName" placeholder="Введите название товара" style="width: 500px;">
        </div>

        <div style="margin-top: 50px" class="input-wrapper">
            <input type="text" name="formatName[]" placeholder="Введите формат товара">
            <input type="text" name="pathImg[]" placeholder="Введите путь для замены">
        </div>

        <div style="margin-top: 50px;">
            <button style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #11b814; border: none;" type="submit">Добавить поля в таблицу</button>

            <select name="selectSeparator" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: rgba(0,0,0,0.5); border: none;">
                <option value=";">Разделить знаком - ( ; )</option>
                <option value="," selected>Разделить знаком - ( , )</option>
            </select>
        </div>

    </form>
</center>

<script>
    let inputWrapper = document.querySelector('.input-wrapper');
    let addButton = document.querySelector('.add-button');

    addButton.addEventListener('click', function() {
        let newInput = document.createElement('div');
        newInput.innerHTML = '<br> <input type="text" name="formatName[]" placeholder="Введите формат товара"> <input type="text" name="pathImg[]" placeholder="Введите путь для замены">';
        inputWrapper.appendChild(newInput);
    });

</script>
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

    foreach ($_POST['formatName'] as $key => $format) {
        foreach ($tableData as &$row) {
            if ($row[array_search('IE_NAME', $headers)] == $_POST['productName'] && $row[array_search('IP_PROP1295', $headers)] ==  $format ) {
                $row[$preview_picture_index] = $_POST['pathImg'][$key];
                $row[$detail_picture_index] = $_POST['pathImg'][$key];

                $count++;
            }
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



