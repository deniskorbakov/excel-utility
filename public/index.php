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
            <p style="color: white; font-size: 20px">Поле для товара заголовка в котором хранятся товары</p>

            <input type="text" name="headerTitle" placeholder="Введите название заголовка" style="width: 500px;">
        </div>

        <div style="margin-top: 30px">
            <p style="color: white; font-size: 20px">Поле для товара к которому вы хотите добавить картинки</p>

            <input type="text" name="productName" placeholder="Введите название товара" style="width: 500px;">
        </div>

        <div style="margin-top: 30px">
            <p style="color: white; font-size: 20px">Поле для директории в которой хранятся картинки</p>

            <input type="text" name="imgMainPath" placeholder="Введите путь где хранятся картинки" style="width: 500px;">
        </div>

        <div style="margin-top: 50px" class="input-wrapper">
            <input id="format" type="text" name="formatName[]" placeholder="Введите формат товара">
            <input type="text" name="pathImg[]" placeholder="Введите путь для замены">
        </div>

        <div style="margin-top: 25px;">
            <button style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #11b814; border: none;" type="submit">Изменить картинки в таблице</button>

            <select name="selectSeparator" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: rgba(0,0,0,0.5); border: none;">
                <option value=";">Разделить знаком - ( ; )</option>
                <option value="," selected>Разделить знаком - ( , )</option>
            </select>
        </div>

        <div style="margin-top: 25px;">
            <select name="isDelete" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: rgba(211,14,14,0.5); border: none;">
                <option value="false" selected>Удалить пустые торговые предложения - НЕТ</option>
                <option value="true">Удалить пустые торговые предложения - ДА</option>
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
        let newInputs = document.querySelectorAll('.inputs');
        let lastInput = newInputs[newInputs.length-1];
        lastInput.remove();
    });
</script>
</body>
</html>

<?php

require './functions/translit.php';

const IS_DELETE_EXTRA_TRADE_OFFER = 'true';
const NEW_COLUMN_FOR_IMPORT_TABLE = "XML_ID";
const NAME_COLUMN_FOR_NAME_PRODUCT = 'IE_NAME';
const ID_PRODUCT_FOR_SUCCESS_IMPORT_TABLE = "IP_PROP1085";
const REPLACEMENT_ROW_IMAGE_PREVIEW = 'IE_PREVIEW_PICTURE';
const REPLACEMENT_ROW_IMAGE_DETAIL = 'IE_DETAIL_PICTURE';

if (isset($_POST['productName'], $_POST['formatName'], $_POST['headerTitle'])) {
    //добавляем название заголовка для продукта
    $headerTitleFormatName = $_POST['headerTitle'];

    //убираем пустые строки
    $formatName = array_diff($_POST['formatName'], array(""));
    $pathImg = array_diff($_POST['pathImg'], array(""));

    $file = fopen('../tables/lioni.csv', 'r+');

    $headersTable = fgetcsv($file, null, $_POST['selectSeparator']);

    $tableData = array();

    // Чтение строк таблицы и добавление их в массив
    while ($row = fgetcsv($file, null, $_POST['selectSeparator'])) {
        $tableData[] = $row;
    }

    fclose($file);

    //получение индексов которые нужно изменить
    $previewPictureIndex = array_search(REPLACEMENT_ROW_IMAGE_PREVIEW, $headersTable);
    $detailPictureIndex = array_search(REPLACEMENT_ROW_IMAGE_DETAIL, $headersTable);

    $countChangeRows = 0;

    $arrayRowsForNewFile = [];

    //добавляем слеш для пути к картинкам
    $mainPathForImages = $_POST['imgMainPath'] . '/';

    //добавляем новый заголовк xml_id
    $newColumn = array_push($headersTable, NEW_COLUMN_FOR_IMPORT_TABLE);

    //получаем id поля с которого мы бдуем брать id
    $idProduct = array_search(ID_PRODUCT_FOR_SUCCESS_IMPORT_TABLE, $headersTable);

    foreach ($formatName as $key => $format) {
        foreach ($tableData as &$row) {
            if ($row[array_search(NAME_COLUMN_FOR_NAME_PRODUCT, $headersTable)] == $_POST['productName'] && $row[array_search($headerTitleFormatName, $headersTable)] ==  $format ) {
                $row[$previewPictureIndex] = $mainPathForImages . $pathImg[$key];
                $row[$detailPictureIndex] = $mainPathForImages . $pathImg[$key];

                //получаем цифры только в крадратных скобках
                preg_match("/\[(\d+)\]/", $row[$idProduct], $matches);

                if(IS_DELETE_EXTRA_TRADE_OFFER === $_POST['isDelete']) {
                    //проверка чтобы не выпадала ошибка неизвестного ключа
                    if (isset($matches[1])) {
                        $result = $matches[1];
                        $row[$newColumn] = $result;

                        // добавляем изменненыую колонку в массив
                        array_unshift($arrayRowsForNewFile, $row);
                        $countChangeRows++;
                    }
                } else {
                    if (!isset($matches[1])) {
                        $result = null;
                    } else {
                        $result = $matches[1];
                    }

                    $row[$newColumn] = $result;

                    // добавляем изменненыую колонку в массив
                    array_unshift($arrayRowsForNewFile, $row);
                    $countChangeRows++;
                }
            }
        }
    }

    if ($countChangeRows == 0) {
        echo '<center style="margin-top: 30px; color: white;"> <h3>Не найдены товары</h3> </center>';
        exit();
    }

    //делаем название для файла из заголовка страницы
    $newFileName = getConvertString($_POST['productName']);

    $newFilePath = '../tables/' . $newFileName . '.csv';

    // Открытие файла для записи измененных данных
    $file = fopen('../tables/' . str_replace('/', '-', $newFileName) . '.csv', 'w');

    fputcsv($file, $headersTable, $_POST['selectSeparator']);

    // Запись измененных строк таблицы
    foreach ($arrayRowsForNewFile as $row) {
        fputcsv($file, $row,  $_POST['selectSeparator']);
    }

    fclose($file);

    echo '<center style="margin-top: 30px; color: white;"> <h3>кол-во измененных записей</h3>' . $countChangeRows . '</center>' ;
} else {
   echo '<center style="margin-top: 30px; color: white;"> <h3>Вставьте все данные</h3> </center>';
}



