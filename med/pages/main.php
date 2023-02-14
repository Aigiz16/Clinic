<?php
session_start();

// если пользователь не авторизован, то редирект на страницу авторизации
if (!isset($_SESSION['logged_user'])) {
    header('Location: ./auth.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/styles/styles.css">
    <title>Главная страница</title>
</head>
<body>
    <!-- подключаем header -->
    <?php require_once("../components/header.php");?>

    <p class="text-center fs-1">Поликлиника №5</p>

    <div class="container d-flex justify-content-center">
    <img src="../static/images/main.jpg" alt="" class="main_photo img-fluid">
    </div>

    <div class="border-top fixed-bottom">
    <div class="container d-flex justify-content-between">
        <div>
        <p>Является государственным учреждением</p>
        <a href="https://minzdrav.tatarstan.ru/"><p>https://minzdrav.tatarstan.ru/</p></a>
        </div>

        <div>
            <p>Тел. : +7 (999) 157 83 74</p>
            <p>Адрес : г. Казань, ул. Б. Красная, 18/7</p>
            <p>Все права защищены</p>
        </div>
    </div>
    </div>
</body>
</html>