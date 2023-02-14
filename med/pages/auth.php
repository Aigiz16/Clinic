<?php 
session_start();

// если пользователь авторизован, то редирект на главную страницу
if (isset($_SESSION['logged_user'])) {
    header('Location: ./main.php');
    exit;
}

// подключение базы данных
require_once("../assets/db_connect.php");

// авторизация
if (isset($_POST["auth-sent"])) {
    $login = $_POST["login"];
    $pass = $_POST["pass"];
    
    // дехэшируем пароль
    $pass = md5($pass."forhktkntuhpi");

    $result = $mysql->query("SELECT * FROM `user` WHERE `Email_login` = '$login' AND `Password` = '$pass'");
    // конвертируем в массив
    $user = $result->fetch_assoc(); 
    
    if ($user) {
        $_SESSION['logged_user'] = $user['Id'];
        $_SESSION['user_role'] = $user['Role_id'];
        header('Location: ./main.php');
    } else {
        echo "Такой пользователь не найден.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/styles/auth_style.css">
    <title>Поликлиника №5</title>
</head>
<body>
   <div class="auth-container">
    <span class="auth-form">Вход в систему медицинского учреждения </span>
    <div class="auth">
        <div class="auth-title">Вход в личный кабинет</div>
        <form method="POST">
            <div class="loginLabel">Логин</div>
            <input type="email" class="form-control" name="login" id="login">
            <div class="pswrdLabel">Пароль</div>
            <input type="password" class="form-control" name="pass" id="pass">
            <a class="forgetPswrd" href="./reset.php">Забыли пароль?</a>
            <input type="submit" class="btn-auth" name="auth-sent" value="Войти">
            <div class="signUpLink">Впервые у нас? <a href="./reg.php">Регистрация</a></div>
        </form>
    </div>
</body>
</html>