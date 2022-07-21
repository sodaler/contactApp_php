<!doctype html>
<html lang="en">
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
            <h5>Панель администратора</h5>
        </div>
        <div>
        <a href="config.php?mode=showTable" class="btn btn-outline-primary">Контакты</a>
        <a href="logout.php" class="btn btn-outline-danger ms-auto">Выйти</a>
        </div>
    </nav>
</header>
<main>
    <div class="container mt-3">
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Id</th>
                <th class="th-sm">Login</th>
                <th class="th-sm">Name</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($usersList as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Id
                </th>
                <th>Login
                </th>
                <th>Name
                </th>
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
<script src="table.js"></script>
</html>