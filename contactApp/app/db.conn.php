<?php

# server name
$sName = "localhost";
# username
$uName = "root";
# password
$pass = "";

# database name
$db_name = "testdb1";

# creating database connection
try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    echo "Ошибка в подключении : " . $ex->getMessage();
}