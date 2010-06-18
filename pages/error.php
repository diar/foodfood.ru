<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница вывода ошибки
 */
class error_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        
    }

    /*
     * Ошибка 404
    */
    public static function indexAction ($id) {
        self::showXSLT('pages/error/404');
    }

    /*
     * Сайт отключен
    */
    public static function disabledAction ($id) {
        echo "Извините, над сайтом производятся профилактические работы";
    }
}