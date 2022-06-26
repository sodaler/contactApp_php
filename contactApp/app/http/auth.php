<?php
session_start();

$conn = '';

# check if username, password submitted
if (isset($_POST['username']) &&
    isset($_POST['password'])) {

    # database connection file
    include '../db.conn.php';

    # get data from POST request and store them in var
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='admin'";

    if (empty($username)) {
        # error message
        $em = "Введите логин!";

        # redirect to 'index.php' and passing error message
        header("Location: ../../index.php?error=$em");
        exit;
    } else if (empty($password)) {
        # error message
        $em = "Введите пароль!";

        # redirect to 'index.php' and passing error message
        header("Location: ../../index.php?error=$em");
        exit;
    } else {
        $sql = "SELECT * FROM
                users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        # if the username is exist
        if ($stmt->rowCount() === 1) {
            # fetching user data
            $user = $stmt->fetch();

            if ($user['username'] === $username) {

                if (password_verify($password, $user['password'])) {

                    # creating the session
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['user_id'] = $user['user_id'];

                    if ($user['username'] === 'admin') {
                        header("Location: ../../config.php?mode=showTable");
                    } else {
                        header("Location: ../../contact.php");
                    }
                } else {
                    $em = "Неверный логин или пароль!";
                    header("Location: ../../index.php?error=$em");
                }
            } else {
                $em = "Неверный логин или пароль!";
                header("Location: ../../index.php?error=$em");
            }
        } else {
            $em = "Неверный логин или пароль!";
            header("Location: ../../index.php?error=$em");
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}