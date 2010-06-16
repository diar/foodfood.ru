<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница персон.
 */
class persons_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        // Получаем список настроений
        $moods=MD_Mood::getMoods();
        // Получаем список тэгов
        $tags=MD_Mood::getTags();

        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    public static function indexAction ($uri) {
        self::$page['site']['page'] = 'Лица foodfood';
        self::$page['content']['persons'] = MD_Person::getPersons();
        // Показываем страницу
        self::showXSLT('pages/persons/index');
    }

    public static function viewAjaxAction ($id) {
        self::$page['person'] = MD_Person::getPerson($id);
        // Показываем страницу
        self::showXSLT('pages/persons/view');
    }

    public static function viewAction ($id) {
        self::$page['site']['page'] = 'Лица foodfood';
        self::$page['content']['persons'] = MD_Person::getPersons();
        self::$page['content']['person_id'] = $id;
        // Показываем страницу
        self::showXSLT('pages/persons/index');
    }


}