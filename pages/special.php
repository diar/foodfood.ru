<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница виджетов
 */
class special_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        // Получаем список настроений
        $moods=MD_Mood::getMoods();
        // Получаем список тэгов
        $tags=MD_Mood::getTags();

        self::$page['site']['title'] = 'Участники конкурса';
        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'main_h';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Конкурс
    */
    public static function contestAction ($id) {
        // Показываем страницу
        self::$page['content']['users'] = MD_User::getUsersByInvites(array('count' => 20));
        self::showXSLT('pages/special/contest');
    }
}