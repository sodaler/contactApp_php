<?php
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : false;


session_start();

include 'app/db.conn.php';

if (isset($_POST['users']) && ($_SESSION['username'] === 'admin')) {
    $data = "SELECT * FROM users";
    $sth = $conn->prepare($data);
    $sth->execute();
    $usersRows = $sth->fetchAll();
    $usersList = array();
    $i = 0;
    foreach ($usersRows as $row) {
        $usersList[$i]['id'] = $row['id'];
        $usersList[$i]['username'] = $row['username'];
        $usersList[$i]['name'] = $row['name'];
        $i++;
    }
}

if ($mode == 'checkUsers') {
    require 'users.php';
}

exit;