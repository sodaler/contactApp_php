<?php
session_start();

$username = $_SESSION['username'];

include 'app/db.conn.php';
try {
    $sql = "SELECT login FROM
                contact WHERE login=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();
} catch (Exception $e) {

}

if (isset($_SESSION['username']) && $_SESSION['username'] != 'admin' && !isset($_SESSION['email']) && !isset($user['login'])) {
    ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Свяжитесь с нами!</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="resource/logo.svg">
    </head>
    <body style="background-image: url(resource/crossword.png)">
    <header>
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="resource/logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                Abstract Website
            </a>
            <a href="logout.php" class="btn btn-dark">Logout</a>
        </nav>
    </header>
    <main class="mt-3">
        <div class="container mb-5 shadow rounded p-4 bg-light">
            <div class="row justify-content-center mt-4">
                <h2>Свяжитесь с нами! <span class="badge badge-secondary">вау! :)</span></h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-8 mt-4">
                    <form class="form needs-validation" method="POST" action="config.php?mode=showTable" enctype="multipart/form-data"
                          novalidate>
                        <?php
                        if (isset($_GET['email'])) {
                            $email = $_GET['email'];
                        } else {
                            $email = '';
                        }
                        ?>
                        <div class="form-group">
                            <label for="mailContact">Ваше имя:</label>
                            <input type="text" class="form-control" id="name"
                                   placeholder="Jenya" name="name" required>
                            <div class="valid-feedback">
                                Отличное имя!
                            </div>
                            <div class="invalid-feedback">
                                Пожалуйста, укажите имя.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mailContact">Ваш Email:</label>
                            <input type="email" class="form-control" id="mailContact"
                                   placeholder="name@example.com" name="email" value="<?=$email;?>" required>
                            <div class="valid-feedback">
                                Email введен верно!
                            </div>
                            <div class="invalid-feedback">
                                Пожалуйста, укажите Вашу почту.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact">Ваш телефон:</label>
                            <input type="text" class="form-control" id="contact"
                                   placeholder="+791234567890" name="contact" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" required>
                            <div class="valid-feedback">
                                Телефон указан верно!
                            </div>
                            <div class="invalid-feedback">
                                Пожалуйста, укажите корректный номер телефона.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select">Укажите ваш возраст: (необязательно)</label>
                            <select class="form-control" id="select" name="age_select">
                                <option value="">Выберите возраст</option>
                                <option>Менее 18 лет</option>
                                <option>18-25 лет</option>
                                <option>25-35 лет</option>
                                <option>35-45 лет</option>
                                <option>Более 45 лет</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="found_select">Откуда вы о нас узнали?</label>
                            <select multiple="multiple" class="form-control" id="found_select" name="found_select[]"
                                    required>
                                <option>Социальные сети</option>
                                <option>От друзей</option>
                                <option>На работе</option>
                                <option>На учебе</option>
                                <option>Из-за наших лекций</option>
                            </select>
                            <div class="valid-feedback">
                                Замечательно!
                            </div>
                            <div class="invalid-feedback">
                                Пожалуйста, выберите соответствующие поля.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="text">Расскажите о себе: (необязательно)</label>
                            <textarea class="form-control h-100" id="text" rows="3" name="text"></textarea>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Ваш пол:</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="radioOption1"
                                       value="Мужчина" required>
                                <label class="form-check-label" for="radioOption1">Мужчина</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="radioOption2"
                                       value="Женщина" required>
                                <label class="form-check-label" for="radioOption2">Женщина</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="radioOption3"
                                       value="Другое" required>
                                <label class="form-check-label" for="radioOption3">Другое</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file">Добавьте изображение (необязательно)</label>
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="policy" name="policy"
                                   required>
                            <label class="form-check-label" for="personalData">
                                Нажимая на кнопку, вы даете согласие на обработку персональных данных
                            </label>
                            <div class="valid-feedback">
                                Замечательно!
                            </div>
                            <div class="invalid-feedback">
                                Пожалуйста, согласитесь с нашей политикой.
                            </div>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-primary mt-2" value="Submit" name="check">
                            <input type="reset" class="btn btn-primary mt-2 float-right" value="Reset">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <nav class="navbar sticky-bottom bg-light">
            <div class="container-fluid">
                All rights reserved
            </div>
        </nav>
    </footer>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="validation.js"></script>
    </html>
    <?php
} else {
    if ($_SESSION['username'] === 'admin' || isset($_SESSION['email']) || isset($user['login'])) {
        header("Location: config.php?mode=showTable");
    }
    else {
        header("Location: index.php");
    }
    exit;
}
?>