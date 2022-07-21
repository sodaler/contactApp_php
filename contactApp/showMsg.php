<?php

if (isset($_SESSION['username'])) {
    ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Панель администратора</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="resource/logo.svg">
    </head>
    <body style="background-image: url(resource/crossword.png)">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="resource/logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                Abstract Website
            </a>
            <div class="navbar-collapse">
                <?php if ($_SESSION['username'] === 'admin')  {?>
                <h5>Панель администратора</h5>
                <?php } ?>
            </div>
            <form class="form needs-validation" method="POST" action="checkUsers.php?mode=checkUsers" enctype="multipart/form-data"
                  novalidate>
                <div>
                    <?php if ($_SESSION['username'] === 'admin')  {?>
                    <input type="submit" class="btn btn-outline-primary" value="Пользователи" name="users">
                    <?php } ?>
                    <a href="logout.php" class="btn btn-outline-danger ms-auto">Выйти</a>
                </div>
            </form>
        </nav>
    </header>
    <main>
        <div class="container mt-3">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <?php if ($_SESSION['username'] === 'admin') { ?>
                    <th class="th-sm">Id</th>
                    <?php } ?>
                    <th class="th-sm">Name</th>
                    <th class="th-sm">Email</th>
                    <th class="th-sm">Contact</th>
                    <th class="th-sm">Text</th>
                    <th class="th-sm">Age</th>
                    <th class="th-sm">Found</th>
                    <th class="th-sm">Gender</th>
                    <th class="th-sm">File</th>
                    <th class="th-sm">Policy</th>
                    <th class="th-sm">Img</th>
                    <?php if ($_SESSION['username'] === 'admin') { ?>
                    <th class="th-sm">Login</th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $row): ?>
                    <tr>
                        <?php if ($_SESSION['username'] === 'admin') { ?>
                        <td><?php echo $row['contact_id']; ?></td>
                        <?php } ?>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['text']; ?></td>
                        <td><?php echo $row['age_select']; ?></td>
                        <td><?php echo $row['found_select']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['file']; ?></td>
                        <td><?php echo $row['policy']; ?></td>
                        <td><img src="uploads/<?php echo $row['file']; ?>" style="height: 100px; width: 100px;"
                                 onerror="this.src='uploads/programmer.png'" alt=""></td>
                        <?php if ($_SESSION['username'] === 'admin') { ?>
                        <td><?php echo $row['login']; ?></td>
                        <?php } ?>

                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <?php if ($_SESSION['username'] === 'admin') { ?>
                    <th>Id
                    </th>
                    <?php } ?>
                    <th>Name
                    </th>
                    <th>Email
                    </th>
                    <th>Contact
                    </th>
                    <th>Text
                    </th>
                    <th>Age
                    </th>
                    <th>Found
                    </th>
                    <th>Gender
                    </th>
                    <th>File
                    </th>
                    <th>Policy
                    </th>
                    <th>Img
                    </th>
                    <?php if ($_SESSION['username'] === 'admin') { ?>
                    <th>Login
                    </th>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </main>
    </body>
    <script type="text/javascript" src="modules/js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <?php if ($_SESSION['username'] === 'admin') { ?>
    <script src="table.js"></script>
    <?php } ?>
    </html>
    <?php
} else {
    header("Location: index.php");
    exit;
}
?>