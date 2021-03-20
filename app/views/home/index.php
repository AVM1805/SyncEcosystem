<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Сайт для линых заметок с возможностью размещения фото" />
    </head>
    <title>
        Sync - 
        <?php if($_COOKIE['login']==''):?>
            Регистрация
        <?php else: ?>
            Главная
        <?php endif; ?>
    </title>

    <link rel="stylesheet" href="/public/css/main.css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/form.css" charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
</head>
<body>
<?php require 'public/blocks/header.php' ?>

<div class="container main">
    <p><b>SyncEcosystem</b> - сайт для личных заметок с возможностью добавления фото</p>
    <?php if($_COOKIE['login']==''):?>
    <p>Но сначала зарегистрируйтесь</p>
    <form action="/" method="post" class="form-control">
        <input type="text" name="name" placeholder="Введите логин" value="<?=$_POST['name']?>"><br>
        <input type="email" name="email" placeholder="Введите email" value="<?=$_POST['email']?>"><br>
        <input type="password" name="pass" placeholder="Введите пароль" value="<?=$_POST['pass']?>"><br>
        <div class="error"><?=$data['message']?></div>
        <button class="btn" id="send">Готово</button>
    </form>
    <?php else: ?>
        <form action="/" method="post" class="form-control" enctype="multipart/form-data">
            <input type="text" name="text" placeholder="Введите текст" autocomplete="off"><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
            <input type="file" name="file"><br>
            <div class="error"><?=  $option['message']?></div>
            <button class="btn" id="send">Добавить</button>
        </form>
        <h2>Ваши записи:</h2>
        <?php for($i = 0; $i < count($data); $i++):?>
            <div class="items-info">
                <p><b>Текст:</b> <?= $data[$i]['text']?></p>
                <?php if($data[$i]['filename'] != ''):?>
                    <img src="/public/img/<?= $data[$i]['filename']?>" class="shortcut">
                <?php endif;?>
                <form action="/" method="post" style="margin-top: 10px">
                    <input type="hidden" name="delete_button" value="<?= $data[$i]['id']?>">
                    <button type="submit" class="btn">Удалить</button>
                </form>
            </div>
        <?php endfor;?>
    <?php endif; ?>
</div>

<?php require 'public/blocks/footer.php' ?>
</body>
</html>