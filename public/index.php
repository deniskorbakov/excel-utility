
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        input {
            height: 30px;
            padding: 5px;
        }

        body {
            background: #222222;
        }
    </style>
</head>
<body>
<center>
    <form action="" method="POST">
        <div>
            <button class="add-button" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #80109f; border: none;" type="button">Добавить еще поля</button>
            <button class="delete-inputs" type="button" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #9f1031; border: none;">Удалить последние поля</button>
        </div>

        <div style="margin-top: 30px">
            <input type="text" name="productName" placeholder="Введите название товара" style="width: 500px;">
        </div>

        <div style="margin-top: 50px" class="input-wrapper">
            <input type="text" name="formatName[]" placeholder="Введите формат товара">
            <input type="text" name="pathImg[]" placeholder="Введите путь для замены">
        </div>

        <div style="margin-top: 25px;">
            <button style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #11b814; border: none;" type="submit">Изменить картинки в таблице</button>

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
    let deleteInputs = document.querySelector('.delete-inputs');

    addButton.addEventListener('click', function() {
        let newInput = document.createElement('div');
        newInput.className = 'inputs';
        newInput.innerHTML = '<br> <input class="newFormatName" type="text" name="formatName[]" placeholder="Введите формат товара"> <input class="newPathImg" type="text" name="pathImg[]" placeholder="Введите путь для замены">';
        inputWrapper.appendChild(newInput);
    });

    deleteInputs.addEventListener('click', function() {
        let newInputs = document.querySelector('.inputs');

        newInputs.remove();
    });
</script>
</body>
</html>

<?php

require './functions/translit.php';

const NEW_COLUMN_FOR_IMPORT_TABLE = "XML_ID";

if (isset($_POST['productName'], $_POST['formatName'], $_POST['pathImg'], $_POST['selectSeparator'])) {
//очищаем массивы от пустых значений
    $formatName = array_diff($_POST['formatName'], array(""));
    $pathImg = array_diff($_POST['pathImg'], array(""));

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

    $arrayRowsForNewFile = [];

    foreach ($formatName as $key => $format) {
        foreach ($tableData as &$row) {
            if ($row[array_search('IE_NAME', $headers)] == $_POST['productName'] && $row[array_search('IP_PROP1295', $headers)] ==  $format ) {
                $row[$preview_picture_index] = $pathImg[$key];
                $row[$detail_picture_index] = $pathImg[$key];

                array_unshift($arrayRowsForNewFile, $row);
                $count++;
            }
        }
    }

    if ($count == 0) {
        echo '<center style="margin-top: 30px; color: white;"> <h3>Не найдены товары</h3> </center>';
        exit();
    }

    $newFileName = getConvertString($_POST['productName']);
    $newFilePath = '../tables/' . $newFileName . '.csv';

// Открытие файла для записи измененных данных
    $file = fopen('../tables/' . str_replace('/', '-', $newFileName) . '.csv', 'w');

// Запись заголовков столбцов
    fputcsv($file, $headers, $_POST['selectSeparator']);

// Запись измененных строк таблицы
    foreach ($arrayRowsForNewFile as $row) {
        fputcsv($file, $row,  $_POST['selectSeparator']);
    }

// Закрытие файла
    fclose($file);

    echo '<center style="margin-top: 30px; color: white;"> <h3>кол-во измененных записей</h3>' . $count . '</center>' ;
} else {
   echo '<center style="margin-top: 30px; color: white;"> <h3>Вставьте все данные</h3> </center>';
}



