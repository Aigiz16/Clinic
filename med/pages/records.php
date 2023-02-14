<?php
session_start();

// подключение базы данных
require_once("../assets/db_connect.php");

// если пользователь не авторизован, то редирект на страницу авторизации
if (!isset($_SESSION['logged_user'])) {
  header('Location: ./auth.php');
  exit;
} else {
  // получаем все записи для доктора
  if ($_SESSION['user_role'] == 2) {
    $userId = $_SESSION['logged_user'];

    $notations = $mysql->query("SELECT * FROM `notation` WHERE `Doctor_id` = '$userId'");
  }

  // отмена записи
  if (isset($_GET["id"])) {
    $notationId = $_GET["id"];

    $delete = $mysql->query(
        "DELETE FROM `notation` WHERE `Id` = $notationId"
    );

    header('Location: ./records.php');
    exit;
  }
  
  // получаем всех докторов
  if ($_SESSION['user_role'] == 1) {
    $doctors = $mysql->query("SELECT * FROM `user` WHERE `Role_Id` = 2");
  }

  // создаем запись
  if (isset($_POST["create-record"])) {
    $userId = $_SESSION['logged_user'];
    $selectedDoctor = $_POST["doctors_list"];
    $recordDate = $_POST["dateForm"];

    $createRecord = $mysql->query(
      "INSERT INTO `notation` SET `User_id` = '$userId', `Doctor_id` = '$selectedDoctor', `Date` = '$recordDate'"
    );

    header('Location: ./records.php');
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
  <title>Записи</title>
</head>

<body>
  <!-- подключаем header -->
  <?php require_once("../components/header.php"); ?>

  <?php if ($_SESSION['user_role'] == 2) { ?>
    <p class="text-center fs-1">Записи</p>

    <div>

      <div class="container p-2 bd-highlight border border-dark">
        <div class="container d-flex p-2 bd-highlight justify-content-between">
          <div class="">ФИО пациента</div>
          <div class="">Время</div>
          <div class="">Отмена записи</div>
        </div>
        <hr>

        <?php while ($notation = $notations->fetch_assoc()) {
          $userId = $notation['User_id']; 

          $user = $mysql->query("SELECT * FROM `user` WHERE `Id` = '$userId'");
          $user = $user->fetch_assoc();

          $userName = $user['Name'];
          $userSurname = $user['Surname'];
          $userPatr = $user['Patronymic'];
          $userFullname = $userName . ' ' . $userSurname . ' ' . $userPatr;

        ?>
          <div class="container d-flex p-2 bd-highlight justify-content-between mt-2">
            <div class=""><?php echo $userFullname; ?></div>
            <div class=""><?php echo $notation['Date']; ?></div>
            <a href="./records.php?id=<?php echo $notation['Id']; ?>"><button class="btn btn-danger text-dark">Отмена</button></a>
          </div>
        <?php } ?>

        <form method="POST">
          <div class="text-center">
            <br> <br>
            <a href="../pdf/notations.php" target="_blank" class="btn btn-primary text-dark">Распечатать</a>
            <br> <br>
          </div>
        </form>
      </div>

    </div>
  <?php } else if ($_SESSION['user_role'] == 1) { ?>
    <p class="text-center fs-1">Запись на приём</p>

    <div class="container border border-dark p-5">
      <div class="">
        <p class="fs-3">ФИО врача:</p>
      </div>

      <form method="POST">
        <p class="fs-3"><select name="doctors_list">
            <?php while ($doctor = $doctors->fetch_assoc()) { ?>
              <option value="<?php echo $doctor['Id']; ?>"><?php echo $doctor['Name'] . ' ' . $doctor['Surname'] . ' ' . $doctor['Patronymic']; ?></option>
            <?php } ?>
          </select></p>
        <div class="row">
          <div class="mb-3 col">
            <label for="dateForm" class="fs-3">Время</label>
            <input type="datetime-local" class="form-control gray-bg" id="dateForm" name="dateForm"
              aria-describedby="emailHelp">
          </div>
          <div class="text-center">
            <input type="submit" class="btn btn-lg btn-primary text-dark" name="create-record" value="Записаться">
            <br> <br>
          </div>
      </form>
    </div>
  <?php } ?>
</body>

</html>