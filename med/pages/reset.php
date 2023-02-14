<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// отправка письма на почту
if (isset($_POST["reset-sent"])) {

    // загрузка библиотеки
    require_once("../vendor/autoload.php");

    // подключение базы данных
    require_once("../assets/db_connect.php");

    // данные пользователя с формы
    $email = $_POST['emailForm'];

    // генерация нового пароля
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    $newPass = randomPassword();
    $newPassHash = md5($newPass."forhktkntuhpi");

    // смена пароля для аккаунта с таким email

    $result = $mysql->query("SELECT * FROM `user` WHERE `Email_login` = '$email'");
    $user = $result->fetch_assoc(); 
    
    if ($user) {
        $update = $mysql->query(
            "UPDATE `user` SET `Password` = '$newPassHash' WHERE `Email_login` = '$email'"
        );

        // настройка phpmailer
        $mail = new PHPMailer(true);

        try {
            // настройка сервера
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail -> charSet = "UTF-8";                                         
            $mail->Host       = 'smtp.yandex.ru';                    
            $mail->SMTPAuth   = true;                                 
            $mail->Username   = 'policlinicka.5@yandex.ru';                     
            $mail->Password   = 'g+9GAQa4U_Bhvku';                             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
            $mail->Port       = 465;                                   

            // настройка отправки
            $mail->setFrom('policlinicka.5@yandex.ru', 'Support');
            $mail->addAddress("$email");             

            // настройка письма
            $mail->isHTML(true);
            $mail->Subject = "$newPass";                                  
            $mail->Body    = "Новый пароль";

            $mail->send();
            header('Location: ./auth.php');
            exit();
        } catch (Exception $e) {
             echo "Ошибка: {$mail->ErrorInfo}";
        }
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
    <link rel="stylesheet" href="../static/styles/styles.css">
    <title>Восстановление доступа</title>
</head>
<body>
    <div class="jumbotron d-flex align-items-center min-vh-100 h-100 justify-content-center">
        <div class="p-3 text-center border border-dark align-items-center">
            <p class="text-center">Восстановление доступа</p>

            <form method="POST">
                <div class="mb-3">
                    <label for="emailForm" class="form-label">Введите электронную почту, на <br> который мы отправим новый пароль</label>
                    <br> <br>
                    <input type="email" class="form-control gray-bg" id="emailForm" name="emailForm" aria-describedby="emailHelp">
                    <br>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary text-dark" name="reset-sent" value="Отправить">
                    <br> <br>
                </div>
            </form>
        </div>
    </div>
</body>
</html>