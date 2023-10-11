<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            background: #222222;
            color: white;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .main-img {
            width: 700px;
            height: 700px;
            display: block;
            border: solid 2px white;
        }

        .container-img {
            margin-top: 30px;
        }

        ul{
            margin-top: 30px;
            list-style-type:  none;
        }

        li {
            margin-top: 15px;
            font-size: 20px;
            padding: 5px;
        }

        li span {
            padding: 10px;
            border: solid #d57bc9 2px;
            border-radius: 10px 100px / 120px;
        }

        .container {
            margin-top: 30px;
            width: 500px;
        }
    </style>
</head>
<body>
<center>
    <button type="button" style="padding: 10px; font-size: 20px; color: #ffffff; background-color: #109f85; border: none;">
        <a href="/">
           Вернуться на главную
        </a>
    </button>

    <div class="container">
        <marquee>
            <h3>Документация по функционалу мини-приложения</h3>
        </marquee>
    </div>


    <div class="container-img">
        <img class="main-img" src="./images/main-page.png" alt="">
    </div>

    <div>
        <ul>
            <li>
                <span>1</span>

                <p>Кнопка добавить еще поле для пункта - 5, создаст поле для формата и ссылки на картинку</p>
                <p>Кнопка удалить поле, удалит последние два поля для ввода</p>
            </li>

            <li>
                <span>2</span>

                <p>Поле в котором должно быть название заголовка(при импорте оно может отличаться) - этот заголовок находиться на 1 строке где расположены форматы</p>
                <img class="extra-img" src="./images/field-format.png" alt="">
            </li>

            <li>
                <span>3</span>

                <p>Поле в котором должно быть название товара его можно взять либо со страницы товара либо с таблицы</p>
                <img src="./images/filed-name.png" alt="">
            </li>

            <li>
                <span>4</span>

                <p>Поле в котором должна быть ссылка на путь к картинкам(вставляете поле без указание символа - / на конце)</p>
                <img src="./images/filed-path-img.png" alt="">
            </li>

            <li>
                <span>5</span>

                <p>Поле(формат товара) в котором должен быть формат для товаров(в эти поле по одному указываете все возможные форматы) - повторять форматы не нужно указываете раз и навсегда</p>
                <img src="./images/filed-format-name.png" alt="">

                <p>Поле(путь для замены) в котором должно быть название картинки - которое соответствует формату - название вставляем без пробелов и доп символов</p>
                <img src="./images/field-name-img.png" alt="">
            </li>

            <li>
                <span>6</span>

                <p>Кнопка которая при нажатии заменить картинки для всех форматов</p>
            </li>

            <li>
                <span>7</span>

                <p>Выпадающий список для разделителя таблицы - при выгрузке указывается разделитель в частоности это запятая или точка с запятой - можно вручную указывать какой разделитель используется в таблице</p>
            </li>

            <li>
                <span>8</span>

                <p>есть шанс что будут торговые предложение и вы можете выбрать пукт из выпадающего списка на - да и тогда очистятся лишние торговые предложения</p>
            </li>

            <li>
                <span>9</span>

                <p>информационный вывод он скажет если будет ошибка либо же вывед кол-во изменных строк при успешном добавлении страницы</p>
            </li>
        </ul>
    </div>
</center>
</body>
</html>
