<?php
header('Content-Type: text/html; charset=utf-8');
//define('DEBUG','');// Включаем файл конфига с дебагом
include_once 'autoload.php';
Session::startSession(false);
Config::setValue('site', 'disabled', false);
if (!empty ($_SESSION['admin']) && $_SESSION['admin']['is_auth']) {
    header('Location: admin.php?page=main', true, 303);
    die();
}
if (!empty($_POST['login']) and !empty($_POST['password'])) {
    if(AdminAuth::login($_POST['login'],$_POST['password'])) {
        header('Location: admin.php?page=main', true, 303);
        die();
    } else {
        echo "Ошибка авторизации";
    }
}
Debug::addParam($_SESSION);
$content['city'] = DB::getRecords('city_list');
echo View::getXSLT($content, 'blocks/admin_auth');
Debug::printParams();