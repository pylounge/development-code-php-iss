<?php
require_once("router.php");
$title = "Web программирование";
$info = "";
$pagelink = Router::parse();
if ($pagelink == "")
{
    $pagelink = "index";
}

if (!file_exists("contents/$pagelink.php"))
{
    $pagelink = "404";
}

if (isset($_POST["send"])){
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $second_name = $_POST["second_name"];
    $birthdate = $_POST["birthdate"];
    $sex = $_POST["sex"];
    $activity = $_POST["activity"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $one_more_pass = $_POST["one_more_pass"];
    $email = $_POST["email"];

    if ($password != $one_more_pass){
        $info = "Пароли не совпадают";
    } else {
        $info = "Вы успешно зарегистрированны.";
    }
}

if (isset($_POST["enter-btn"])){
    $login = $_POST["login"];
    $password = $_POST["password"];

    if ($password == "123" && $login == "max"){
        $info = "Успешно";
    } else {
        $info = "Не успешно";
    }
}

require_once("template/header.php");
require_once("contents/$pagelink.php");
require_once("template/footer.php");
