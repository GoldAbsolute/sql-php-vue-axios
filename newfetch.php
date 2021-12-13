<?php
//В процессе разработки я использовал OpenServer с его сервером Apache 2.4 и базой данных MySQL-5.7
$host = "localhost";
$user = "root";
$password = "";
$dbname = "testy";
$id = '';

$con = mysqli_connect($host, $user, $password, $dbname);
//Дополнительная защита для кириллицы
mysqli_set_charset($con, "utf8mb4_general_ci");
mysqli_query($con, "SET NAMES utf8");

if ($con->connect_error) {
    die("Ошибка подключения" . $con->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];
//В методе POST более удобная передача данных, которая в DELETE осуществляется через config, поэтому было принято решение для DELETE использовать POST
switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM `testys`";
        break;
    case 'POST':
        $added = json_encode($_POST["added"]);
        if (strlen($added) < 5) {
            $name = json_encode($_POST["name"]);
            $text = json_encode($_POST["text"]);
            $dated = json_encode($_POST["dated"]);
            $timed = json_encode($_POST["timed"]);

            $sql = "INSERT INTO `testys` (`name`, `date`, `time`, `text`) VALUES ($name,$dated,$timed,$text)";
            break;
        } else {
            $idx = json_encode($_POST["idx"]);
            $sql = "DELETE FROM `testys` WHERE id=($idx)";
            break;
        }

}

$result = mysqli_query($con, $sql);

if (!$result) {
    http_response_code(404);
    die(mysqli_error($con));
}

if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        echo ($i > 0 ? ',' : '') . json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
} elseif ($method == 'POST') {
    echo json_encode($result);
} else {
    echo mysqli_affected_rows($con);
}

$con->close();