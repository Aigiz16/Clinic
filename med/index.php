<?php
session_start();

// если пользователь авторизован, то редирект на главную страницу
if (isset($_SESSION['logged_user'])) {
    header('Location: ./pages/main.php');
    exit;
} else { // если нет, то редирект на страницу входа
    header('Location: ./pages/auth.php');
    exit;
}

?>