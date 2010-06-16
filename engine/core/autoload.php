<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Реализация автоматического подключения классов ядра и модулей,
 * Если у класса есть метод initModule, он вызывается автоматически
 * У модуля метод initModule НЕ вызывается автоматически
 * @param $class Название класса
 * @return null
 */
function __autoload ($class) {
    if (substr_count($class,'Plugin')==0 and substr_count($class,'MD_')==0) {
        try {
            include_once ($_SERVER['DOCUMENT_ROOT'].'/engine/core/'.strtolower($class).'.class.php');
            if (method_exists($class, 'initModule')) {
                call_user_func_array(array('Event', 'sendEvent'),array($class,'INIT'));
                call_user_func(array($class, 'initModule'));
                call_user_func_array(array('Event', 'sendEvent'),array($class,'AFTER'));
            }
        } catch (Exception $e) {
            Error::setError('SYS',$e->getMessage());
        }
    }elseif ( substr_count($class,'MD_')==1) {
        try {
            $class_file = str_replace('MD_', '', $class);
            include_once (Config::getValue('path','models').strtolower($class_file).'.model.php');
            if (method_exists($class, 'initModel')) call_user_func(array($class, 'initModel'));
        } catch (Exception $e) {
            Error::setError('SYS',$e->getMessage());
        }
    } else {
        try {
            $class_file = str_replace('Plugin', '', $class);
            include_once (Config::getValue('path','plugins').strtolower($class_file).'.plugin.php');
        } catch (Exception $e) {
            Error::setError('SYS',$e->getMessage());
        }
    }
}