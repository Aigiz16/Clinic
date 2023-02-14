<?php 
session_start();

// подключение базы данных
require_once("../assets/db_connect.php");

// регистрация
if (isset($_POST["reg-sent"])) {
    $login = $_POST["emailForm"];
    $pass = $_POST["passwordForm"];
    
    // создаем хэш из пароля
    $pass = md5($pass."forhktkntuhpi");
    
    $update = $mysql->query(
        "INSERT INTO `user` SET `Email_login` = '$login', `Password` = '$pass', `Role_id` = 1"
    );
    
    header('Location: ./auth.php');
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
    <title>Регистрация</title>
</head>
<body>
    <a href="./auth.php"><button class="btn btn-primary btn-lg btn-in text-dark">Войти</button></a>
    
    <div class="jumbotron d-flex align-items-center min-vh-100 h-100 justify-content-center">
        <div class="p-3 text-center border border-dark align-items-center reg-div">
            <p class="text-center">Регистрация</p>

            <form method="POST">
                <div class="mb-3">
                    <p class="text-start"><label for="emailForm">Введите эл. почту</label></p>
                    <input type="email" class="form-control gray-bg" id="emailForm" name="emailForm" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <p class="text-start"><label for="passwordForm">Введите пароль</label></p>
                    <input type="password" class="form-control gray-bg" id="passwordForm" name="passwordForm" aria-describedby="emailHelp">
                    <br>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary text-dark" name="reg-sent" value="Зарегистрироваться">
                    <br> <br>
                </div>
            </form>
        </div>
    </div>
</body>
</html>