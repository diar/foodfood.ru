<?php
/**
 * Реализация автоматического подключения классов ядра
 * Если у класса есть метод initModule, он вызывается автоматически
 * @param $class Название класса
 * @return null
 */
function __autoload ($class) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/admin/classes/'.strtolower($class).'.class.php')) {
        include_once ($_SERVER['DOCUMENT_ROOT'].'/admin/classes/'.strtolower($class).'.class.php');
        if (method_exists($class, 'initModule')) {
            call_user_func(array($class, 'initModule'));
        }
    }
    elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/core/'.strtolower($class).'.class.php')) {
        include_once ($_SERVER['DOCUMENT_ROOT'].'/engine/core/'.strtolower($class).'.class.php');
        if (method_exists($class, 'initModule')) {
            call_user_func(array($class, 'initModule'));
        }
    }
}