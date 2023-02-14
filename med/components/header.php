<?php
    if (isset($_POST["logout-sent"])) {
        $_SESSION['logged_user'] = null;
        $_SESSION['user_role'] = null;
        header('Location: ../pages/auth.php');
    }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../pages/account.php">Личный кабинет</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../pages/specialists.php">Специалисты</a>
                </li>
                <?php if ($_SESSION['user_role'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../pages/records.php">Запись на приём</a>
                    </li>
                <?php } else if ($_SESSION['user_role'] == 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../pages/records.php">Записи</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../pages/comments.php">Комментарии</a>
                </li>
            </ul>
            <form method="POST">
                <input type="submit" class="btn btn-primary btn-lg text-dark" name="logout-sent" value="Выйти">
            </form>
        </div>
    </div>
</nav>