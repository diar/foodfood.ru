<?php
//define('DEBUG','');
header('Content-Type: text/html; charset=utf-8');
require_once 'autoload.php';
Session::startSession(false);
if (empty($_SESSION['admin']['is_auth'])) {
    header('Location: index.php', true, 303);
}
if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header('Location: index.php', true, 303);
    die();
}
$page = !empty($_GET['page']) ? htmlspecialchars($_GET['page']) : 'main';
$action = !empty($_GET['action']) ? htmlspecialchars($_GET['action']) : 'showList';

//Если лезем куда не надо
if (!preg_match('/^([a-zA-Z]+)$/',$page)) die();

//Есть ли в ГЕТ или ПОСТ запросе id
if (isset($_GET['id'])) {
    $elementID = intval($_GET['id']);
}
elseif (isset($_POST['id'])) {
    $elementID = intval($_POST['id']);
}
else {
    $elementID = -1;
}

//Надобность строки под вопросом.
$moduleInfo = DB::fetchAll("SELECT * FROM `modules`");

//Подготовка констант
define('DB_PAGE_TABLE',$page);
define('PAGE',$page);
define('ACTION',$action);
define('ELEMENT_ID',$elementID);

//Проверка на наличие файла модуля.
if (file_exists("pages/$page.php")) {
    include_once("pages/$page.php");
} else {
    die (trigger_error("Файл модуля $page не найден."));
}
//Проверка на наличие необходимого класса и метода.
if(method_exists($page,'initModule')) {
    call_user_func(array($page,'initModule'));
} else {
    die (trigger_error('Не найден метод или класс модуля.'));
}
Debug::addParam($_SESSION);
Debug::printParams();
