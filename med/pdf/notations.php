<?php
session_start();

// подключение базы данных
require_once("../assets/db_connect.php");

// подключаем библиотеку
require_once('./tcpdf.php');

// если пользователь не авторизован, то редирект на страницу авторизации
if (!isset($_SESSION['logged_user'])) {
    header('Location: ../pages/auth.php');
    exit;
} else {
    // получаем все записи для доктора
    if ($_SESSION['user_role'] == 2) {
        $userId = $_SESSION['logged_user'];

        $notations = $mysql->query("SELECT * FROM `notation` WHERE `Doctor_id` = '$userId'");
    } else {
        header('Location: ./main.php');
        exit();
    }

    // генерируем pdf

    // create new PDF document
    $pdf = new TCPDF("p", "mm", "a4", true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Поликлиника №5');
    $pdf->SetTitle('Печать записей');

    // set font
    $pdf->SetFont('dejavusans', '', 14);

    // add a page
    $pdf->AddPage();

    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);

    // set cell margins
    $pdf->setCellMargins(1, 1, 1, 1);

    // set color for background
    $pdf->SetFillColor(255, 255, 215);

    while ($notation = $notations->fetch_assoc()) {
        $userId = $notation['User_id'];

        $user = $mysql->query("SELECT * FROM `user` WHERE `Id` = '$userId'");
        $user = $user->fetch_assoc();

        $userName = $user['Name'];
        $userSurname = $user['Surname'];
        $userPatr = $user['Patronymic'];
        $userFullname = $userName . ' ' . $userSurname . ' ' . $userPatr;


        $pdf->MultiCell(119, 10, $userFullname, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 10, $notation['Date'], 1, 'L', 0, 1, '', '', true);

        $pdf->Ln(4);
    }

    //Close and output PDF document
    $pdf->Output('print.pdf', 'I');
}
?>