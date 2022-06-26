<?php
    session_start();

    if (!isset($_SESSION['username'])) {
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добро пожаловать!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="resource/logo.svg">
</head>
<body style="background-image: url(resource/crossword.png)">
<main class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded bg-light">
        <form method="post" action="app/http/auth.php" >
            <div class="d-flex justify-content-center align-items-center flex-column hello">
                <img src="resource/signLogo.png" class="w-25 ms-3">
                <h3 class="display-4 fs-1 text-center">Авторизация</h3>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?= htmlspecialchars($_GET['error']);?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_GET['success']);?>
            </div>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Логин</label>
                <input type="text" class="form-control" name="username">
            </div>

            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button type="submit" class="btn btn-primary" name="login">Войти</button>
            <a href="signup.php">Регистрация</a>
        </form>
    </div>
</main>
</body>
</html>
<?php
    } else {
        header("Location: contact.php");
        exit;
    }
?>