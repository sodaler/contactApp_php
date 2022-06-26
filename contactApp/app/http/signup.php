<?php
$conn = "";

if (isset($_POST['username']) &&
    isset($_POST['name']) &&
    isset($_POST['password'])) {

    # database connection file
    include '../db.conn.php';

    # get data from POST request and store them in var
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    # making URL data format
    $data = 'name=' . $name . '&username=' . $username;

    if (empty($name)) {
        # error message
        $em = "Введите имя!";

        # redirect to 'signup.php' and passing error message
        header("Location: ../../signup.php?error=$em");
        exit;
    } else if (empty($username)) {
        # error message
        $em = "Введите логин!";

        # redirect to 'signup.php' and passing error message
        header("Location: ../../signup.php?error=$em&$data");
        exit;
    } else if (empty($password)) {
        #error message
        $em = "Введите пароль!";

        # redirect to 'signup.php' and passing error message
        header("Location: ../../signup.php?error=$em&$data");
        exit;
    } else {
        # checking the database if the username is taken
        $sql = "SELECT username
                FROM users
                WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $em = "Логин ($username) уже занят";
            header("Location: ../../signup.php?error=$em&$data");
            exit;
        } else {
            // password hashing
            $password = password_hash($password, PASSWORD_DEFAULT);

            # inserting data into database
            $sql = "INSERT INTO users
                        (name, username, password)
                        VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $username, $password]);

            # success message
            $sm = "Аккаунт успешно создан!";

            header("Location: ../../index.php?success=$sm");
            exit;
        }
    }
} else {
    header("Location: ../../signup.php");
    exit;
}
