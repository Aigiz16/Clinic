<?php
session_start();

// подключение базы данных
require_once("../assets/db_connect.php");

// если пользователь не авторизован, то редирект на страницу авторизации
if (!isset($_SESSION['logged_user'])) {
    header('Location: ./auth.php');
    exit;
} else {
  // получаем данные врачей
  $doctors = $mysql->query("SELECT * FROM `user` WHERE `Role_Id` = 2");

  // поиск врача по фамилии
  if (isset($_GET["doctor-search"])) {
    $doctorSurname = $_GET['surnameForm'];
    $doctors = $mysql->query("SELECT * FROM `user` WHERE `Surname` = '$doctorSurname' AND `Role_Id` = 2");
  }
  if (isset($_GET["doctor-clear"])) {
    header('Location: ./specialists.php');
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
  <title>Специалисты</title>
</head>

<body>
  <?php require_once("../components/header.php");?>

  <p class="text-center fs-1 mt-5">Наши специалисты</p>

  <div class="container justify-content-center border border-dark">
    <div>
      <form class="d-flex justify-content-center p-3" method="GET">
        <?php if (isset($_GET["doctor-search"])) { ?>
          <p>Врачи с фамилией <?php echo $doctorSurname; ?></p>
          <input type="submit" class="btn btn-primary text-dark" name="doctor-clear" value="Все врачи" style="margin-left: 10px">
        <?php } else { ?>
          <input class="form-control me-2" type="text" placeholder="Введите фамилию врача" aria-label="Search" name="surnameForm">
          <input type="submit" class="btn btn-primary text-dark" name="doctor-search" value="Найти">
        <?php } ?>
      </form>
    </div>

    <div class="doctors">
      <?php while ($doctor = $doctors->fetch_assoc()) { ?>
        <div class="p-2 doctor">
          <img src="../static/images/<?php if ($doctor['Image']) {echo $doctor['Image'];} else {echo 'profile.png';} ?>" alt="photo" class="photo row">
          <p class="text-start row">ФИО врача: <br> <?php echo $doctor['Name'] . ' ' . $doctor['Surname'] . ' ' . $doctor['Patronymic']; ?></p>
          <p class="text-start row">Специальность: <br> <?php echo $doctor['Speciality']; ?></p>
          <p class="text-start row">Рейтинг: <br> <?php echo $doctor['Rating']; ?></p>
        </div>
      <?php } ?>
    </div>

</body>

</html>