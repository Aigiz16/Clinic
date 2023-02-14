<?php 
session_start();

// подключение базы данных
require_once("../assets/db_connect.php");

// переменные для данных пользователя
$userEmail = "";
$userName = "";
$userSurname = "";
$userPatr = "";
$userDate = "";
$userPhone = "";
$userSnils = "";
$userOms = "";
$userSpec = "";
$userEducation = "";

// если пользователь не авторизован, то редирект на страницу авторизации
if (!isset($_SESSION['logged_user'])) {
    header('Location: ./auth.php');
    exit;
} else {
	$userId = $_SESSION['logged_user'];
	// получаем данные авторизованного пользователя
	$result = $mysql->query("SELECT * FROM `user` WHERE `Id` = '$userId'");
    // конвертируем в массив
    $user = $result->fetch_assoc();

	// заполняем данными пользователя переменные
	$userEmail = $user["Email_login"];
	$userName = $user["Name"];
	$userSurname = $user["Surname"];
	$userPatr = $user["Patronymic"];
	$userDate = $user["Date_Of_Birth"];
	$userPhone = $user["Phone"];
	$userSnils = $user["Number_Snils"];
	$userOms = $user["Number_Oms"];
	$userSpec = $user["Speciality"];
	$userEducation = $user["Education"];

	// сохранение данных пациента
	if (isset($_POST["user-save"])) {
		$userEmail = $_POST["emailForm"];
		$userName = $_POST["nameForm"];
		$userSurname = $_POST["secnameForm"];
		$userPatr = $_POST["patronymicForm"];
		$userDate = $_POST["dateForm"];
		$userPhone = $_POST["numForm"];
		$userSnils = $_POST["numsnilsForm"];
		$userOms = $_POST["numomsForm"];

		// обновляем базу данных
		$saveUser = $mysql->query(
			"UPDATE `user` SET `Email_login` = '$userEmail', `Name` = '$userName', `Surname` = '$userSurname',
			`Patronymic` = '$userPatr', `Date_Of_Birth` = '$userDate', `Phone` = '$userPhone', `Number_Snils` = '$userSnils',
			`Number_Oms` = '$userOms' WHERE `Id` = '$userId'"
		);

		if ($saveUser) {
			header('Location: ./account.php');
		} else {
			echo "Что-то пошло не так";
		}
	}

	// сохранение данных доктора
	if (isset($_POST["doctor-save"])) {
		$userEmail = $_POST["emailForm"];
		$userName = $_POST["nameForm"];
		$userSurname = $_POST["secnameForm"];
		$userPatr = $_POST["patronymicForm"];
		$userDate = $_POST["dateForm"];
		$userPhone = $_POST["numForm"];
		$userSpec = $_POST["specForm"];
		$userEducation = $_POST["eduForm"];

		// обновляем базу данных
		$saveDoctor = $mysql->query(
			"UPDATE `user` SET `Email_login` = '$userEmail', `Name` = '$userName', `Surname` = '$userSurname',
			`Patronymic` = '$userPatr', `Date_Of_Birth` = '$userDate', `Phone` = '$userPhone', `Speciality` = '$userSpec',
			`Education` = '$userEducation' WHERE `Id` = '$userId'"
		);

		if ($saveDoctor) {
			header('Location: ./account.php');
		} else {
			echo "Что-то пошло не так";
		}
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
	<title>Личный кабинет</title>
</head>

<body>
	<?php require_once("../components/header.php"); ?>

	<p class="text-center fs-1 mt-5">Личный кабинет</p>

	<div class="container d-flex justify-content-center">
		<div class="d-inline-flex justify-content-center p-3 border border-dark">
			<?php if ($_SESSION['user_role'] == 1) { ?>
				<form method="POST">
					<div class="row">
						<div class="mb-3 col">
							<label for="emailForm">Электронная почта</label>
							<input value="<?php echo $userEmail; ?>" type="email" class="form-control gray-bg" id="emailForm" name="emailForm"
								aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="patronymicForm">Отчество (при наличии)</label>
							<input value="<?php echo $userPatr; ?>" type="text" class="form-control gray-bg" id="patronymicForm" name="patronymicForm"
								aria-describedby="emailHelp">
						</div>
					</div>
					<div class="row">
						<div class="mb-3 col">
							<label for="nameForm">Ваше имя</label>
							<input value="<?php echo $userName; ?>" type="text" class="form-control gray-bg" id="nameForm" name="nameForm"
								aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="numsnilsForm">Номер СНИЛСа</label>
							<input value="<?php echo $userSnils; ?>" type="text" class="form-control gray-bg" id="numsnilsForm" name="numsnilsForm"
								aria-describedby="emailHelp">
						</div>
					</div>
					<div class="row">
						<div class="mb-3 col">
							<label for="secnameForm">Ваша фамилия</label>
							<input value="<?php echo $userSurname; ?>" type="text" class="form-control gray-bg" id="secnameForm" name="secnameForm"
								aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="numomsForm">Номер ОМС</label>
							<input value="<?php echo $userOms; ?>" type="text" class="form-control gray-bg" id="numomsForm" name="numomsForm"
								aria-describedby="emailHelp">
						</div>
					</div>
					<div class="row">
						<div class="mb-3 col">
							<label for="dateForm">Дата рождения</label>
							<input value="<?php echo $userDate; ?>" type="date" class="form-control gray-bg" id="dateForm" name="dateForm"
								aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="numForm">Номер телефона</label>
							<input value="<?php echo $userPhone; ?>" type="text" class="form-control gray-bg" id="numForm" name="numForm"
								aria-describedby="emailHelp">
							<br>
						</div>
					</div>
					<div class="text-center">
						<input type="submit" class="btn btn-primary text-dark" name="user-save" value="Сохранить">
						<br> <br>
					</div>
				</form>
			<?php } else if ($_SESSION['user_role'] == 2) { ?>
				<form method="POST">
					<div class="row">
						<div class="mb-3 col">
							<label for="emailForm">Электронная почта</label>
							<input value="<?php echo $userEmail; ?>" type="email" class="form-control gray-bg" id="emailForm" name="emailForm" aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="patronymicForm">Отчество (при наличии)</label>
							<input value="<?php echo $userPatr; ?>" type="text" class="form-control gray-bg" id="patronymicForm" name="patronymicForm" aria-describedby="emailHelp">
						</div>
					</div>
			
					<div class="row">
						<div class="mb-3 col">
							<label for="nameForm">Ваше имя</label>
							<input value="<?php echo $userName; ?>" type="text" class="form-control gray-bg" id="nameForm" name="nameForm" aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="specForm">Специальность</label>
							<input value="<?php echo $userSpec; ?>" type="text" class="form-control gray-bg" id="specForm" name="specForm" aria-describedby="emailHelp">
						</div>
					</div>
			
					<div class="row">
						<div class="mb-3 col">
							<label for="secnameForm">Ваша фамилия</label>
							<input value="<?php echo $userSurname; ?>" type="text" class="form-control gray-bg" id="secnameForm" name="secnameForm" aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="eduForm">Образование</label>
							<input value="<?php echo $userEducation; ?>" type="text" class="form-control gray-bg" id="eduForm" name="eduForm" aria-describedby="emailHelp">
						</div>
					</div>
			
					<div class="row">
						<div class="mb-3 col">
							<label for="dateForm">Дата рождения</label>
							<input value="<?php echo $userDate; ?>" type="date" class="form-control gray-bg" id="dateForm" name="dateForm" aria-describedby="emailHelp">
						</div>
						<div class="mb-3 col">
							<label for="numForm">Номер телефона</label>
							<input value="<?php echo $userPhone; ?>" type="text" class="form-control gray-bg" id="numForm" name="numForm" aria-describedby="emailHelp">
							<br>
						</div>
					</div>
			
					<div class="text-center">
						<input type="submit" class="btn btn-primary text-dark" name="doctor-save" value="Сохранить">
						<br> <br>
					</div>
				</form>
			<?php } ?>
		</div>
	</div>
</body>

</html>