<?php
session_start();

// подключение базы данных
require_once("../assets/db_connect.php");

// если пользователь не авторизован, то редирект на страницу авторизации
if (!isset($_SESSION['logged_user'])) {
  header('Location: ./auth.php');
  exit;
} else {
  // получаем всех пользователей, которые записались на доктора
  if ($_SESSION['user_role'] == 2) {
    $userId = $_SESSION['logged_user'];

    $notations = $mysql->query("SELECT * FROM `notation` WHERE `Doctor_id` = '$userId'");
  }

  if (isset($_POST["create-comment"])) {
    $userId = $_SESSION['logged_user'];
    $selectedUser = $_POST["user_list"];
    $comment = $_POST["commentForm"];

    $createComment = $mysql->query(
      "INSERT INTO `commentary` SET `Sender_id` = '$userId', `Recipient_id` = '$selectedUser', `Comment` = '$comment'"
    );

    header('Location: ./comments.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="../static/styles/styles.css">
  <title>Комментарии</title>
</head>

<body>
  <!-- подключаем header -->
  <?php require_once("../components/header.php"); ?>

  <?php if ($_SESSION['user_role'] == 2) { ?>
    <p class="text-center fs-1">Комментарии</p>

    <div class="container border border-dark p-5">
      <form action="" method="post">
        <p class="fs-3"><select name="user_list">
            <?php while ($notation = $notations->fetch_assoc()) { 
              $userId = $notation['User_id'];

              $user = $mysql->query("SELECT * FROM `user` WHERE `Id` = '$userId'");
              $user = $user->fetch_assoc();
      
              $userName = $user['Name'];
              $userSurname = $user['Surname'];
              $userPatr = $user['Patronymic'];
              $userFullname = $userName . ' ' . $userSurname . ' ' . $userPatr;
            ?>
              <option value="<?php echo $userId; ?>"><?php echo $userFullname; ?></option>
            <?php } ?>
          </select></p>

        <div class="row">
          <div class="mb-3 col">
            <label for="commentForm" class="fs-3">Комментарий:</label>
            <textarea type="text-field" class="form-control gray-bg" id="commentForm" name="commentForm"
              aria-describedby="emailHelp"></textarea>
          </div>
          <div class="text-center">
            <input type="submit" class="btn btn-lg btn-primary text-dark" name="create-comment" value="Отправить">
            <br> <br>
          </div>
      </form>
    </div>
  <?php } else if ($_SESSION['user_role'] == 1) { ?>
    <p class="text-center fs-1">Комментарии</p>

    <div class="container border border-dark p-5">
      <div class="">
        <p class="fs-3">Комментарий оставил: <!--{comm.doctor.FIO}--></p>
        <p class="fs-3">Комментарий: <!--{comm.text}--></p>
      </div>
      <form action="" method="post">
        <p class="fs-3"><select name="doctors_list">
            <option>Выбрать врача</option>
            <!--Подключите с бэка список пациентов-->
            <!--{for doctor in doctors}-->
            <option value=""><!--doctor.FIO--></option> <!--value="{doctor.id}"-->
            <!--{endfor}-->
          </select></p>

        <div class="row">
          <div class="mb-3 col">
            <label for="commtextForm" class="fs-3">Ответить</label>
            <textarea type="text-field" class="form-control gray-bg" id="commtextForm" name="commtextForm"
              aria-describedby="emailHelp"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary text-dark">Сохранить</button>
            <br> <br>
          </div>
      </form>
    </div>
  <?php } ?>



</body>

</html>