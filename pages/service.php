<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Служебные страницы сайта
 */
class service_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        // Получаем список настроений
        $moods=MD_Mood::getMoods();
        // Получаем список тэгов
        $tags=MD_Mood::getTags();

        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['site']['title'] = 'Регистрация на сайте';
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /**
     * Обратная связь
     */
    public static function callbackAjaxAction () {
        echo MD_Service::callback($_POST['text'],$_POST['mail']);
    }
}