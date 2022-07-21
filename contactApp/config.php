<?php

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

session_start();
$conn = "";
include 'app/db.conn.php';

$username = $_SESSION['username'];
$flag = false;
$new_img_name = '';
$uploadDir = 'uploads/';
$mode = $_REQUEST['mode'] ?? false;


$sql = "SELECT * FROM
                users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$username]);

$user = $stmt->fetch();

/**
 * @param mixed $row
 * @param array $list
 * @param int $i
 * @return array
 */
function getList(mixed $row, array $list, int $i): array
{
    $list[$i]['name'] = $row['name'];
    $list[$i]['email'] = $row['email'];
    $list[$i]['contact'] = $row['contact'];
    $list[$i]['text'] = $row['text'];
    $list[$i]['age_select'] = $row['age_select'];
    $list[$i]['found_select'] = $row['found_select'];
    $list[$i]['gender'] = $row['gender'];
    $list[$i]['file'] = $row['file'];
    $list[$i]['policy'] = $row['policy'];
    return $list;
}

if ((isset($_POST['check'])) || ($user['username'] === 'admin') || (isset($user))) {

    if ($user['username'] !== 'admin' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['found_select']) && isset($_POST['gender']) && isset($_POST['policy'])) {
        //fetching and storing the form data in variables
        $user_name = trim($_REQUEST['name']);
        $email = trim($_REQUEST['email']);
        $contact = trim($_REQUEST['contact']);
        $text = trim($_REQUEST['text']);
        $ageSelect = trim($_REQUEST['age_select']);
        $foundSelect = trim(implode(', ', $_REQUEST['found_select']));
        $gender = trim($_REQUEST['gender']);
        $policy = trim($_REQUEST['policy']);
        $login = $user['username'];

        // validation and operations with file
        if ((isset($_FILES['file'])) && (filesize($_FILES['file']['tmp_name']) < 8388608)) {
            $file_name = $_FILES['file']['name'];
            $tmp_name = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];

            # if there is not error occured while uploading
            if ($error === 0) {

                # get image extension store it in var
                $img_ex = pathinfo($file_name, PATHINFO_EXTENSION);

                # convert the image extension into lower case and store it in var
                $img_ex_lc = strtolower($img_ex);

                # creating array that stores allowed to upload image extension
                $allowed_exs = array("jpg", "jpeg", "png");

                # check if the image extension is present in $allowed_exs array
                if (in_array($img_ex_lc, $allowed_exs)) {
                    /* renaming the image with user's username
                       like: username.$img_ex_lc
                    */
                    $new_img_name = $username . "." . $_FILES["file"]["name"];

                    # creating upload path on root directory
                    $img_upload_path = 'uploads/' . $new_img_name;

                    # move uploaded image to ./upload folder
                    move_uploaded_file($tmp_name, $img_upload_path);
                }
            }
        }

        if (isset($_POST['check'])) {
            // insert data into table
            if (isset($new_img_name)) {
                try {
                    $sql = "INSERT INTO contact (name, email, contact, text, age_select, found_select, gender, file, policy, login) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$user_name, $email, $contact, $text, $ageSelect, $foundSelect, $gender, $new_img_name, $policy, $login]);
                    $flag = true;
                } catch (Exception $e) {
                    echo "Не удалось внести данные : " . $e->getMessage();
                }
            } else {
                try {
                    $sql = "INSERT INTO contact (name, email, contact, text, age_select, found_select, gender, policy, login) VALUES (?,?,?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$user_name, $email, $contact, $text, $ageSelect, $foundSelect, $gender, $policy, $login]);
                    $flag = true;
                } catch (Exception $e) {
                    echo "Не удалось внести данные : " . $e->getMessage();
                }
            }
        }
    }

    // read data from table and storing in array
    $data = "SELECT * FROM contact";
    $sth = $conn->prepare($data);
    $sth->execute();
    $rows = $sth->fetchAll();
    $list = array();
    $i = 0;
    if ($user['username'] !== 'admin') {
        foreach ($rows as $row) {
            if ($user['username'] === $row['login']) {
                $list = getList($row, $list, $i);
            }
        }
    } else {
        foreach ($rows as $row) {
            $list[$i]['contact_id'] = $row['contact_id'];
            $list = getList($row, $list, $i);
            $list[$i]['login'] = $row['login'];
            $i++;
        }
    }

    // send contact information to mail using smtp
    if ($user['username'] != 'admin' && $flag === true) {
        $title = "Информация о пользователе: $login";
        $body = "
    <h2>Новое письмо</h2>
    <b>Имя:</b> $login<br>
    <b>Почта:</b> $email<br>
    <b>Телефон:</b> $contact<br>
    <b>Информация о себе:</b> $text<br>
    <b>Откуда о нас узнали:</b> $foundSelect<br>
    <b>Пол:</b> $gender<br>
    <b>Изображение:</b> $new_img_name<br>
    <b>Соглашение с политикой:</b>$policy";

        // use PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->SMTPAuth = true;
//        $mail->SMTPDebug = 2;
            $mail->Debugoutput = function ($str, $level) {
                $GLOBALS['status'][] = $str;
            };

            // mail configuration
            // ИЗМЕНИТЬ *username* на свою почту и пароль для приложений в поле *password*
            $mail->Host = 'smtp.mail.ru';
            $mail->Username = 'misha_lector87@mail.ru';
            $mail->Password = 'Ze9NNf92e4TtR0mT6cbj';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // ssl configuration
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //
            $mail->setFrom('misha_lector87@mail.ru', 'Администратор');
            // ИЗМЕНИТЬ НА СВОЮ ПОЧТУ
            $mail->addAddress('misha_lector87@mail.ru');
            // send mail
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = $body;

            if ($mail->send()) {
                $result = "success";
            } else {
                $result = "error";
            }

        } catch (Exception $e) {
            $result = "error";
            $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
        }
    }
}

if ($mode == 'showTable') {
    require 'showMsg.php';
}

exit;



