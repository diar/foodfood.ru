<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница ресторана, по умолчанию действие View
 */
class content_Page extends View {

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

    /*
     * Вывод полного списка
    */
    public static function indexAction ($id) {
        self::$page['content']['banner']['type'] = 'vertical';
        self::$page['content']['banner']['class'] = 'right_banner';
        
        // Показываем страницу
        self::showXSLT('pages/poster/index');
    }
    
    /*
     * Показ одной афиши
    */
    public static function viewAction ($id) {
        $content = MD_Content::getContent($id);
        self::$page['site']['page'] = $content['content_title'];
        self::$page['content']['page'] = $content;
        self::showXSLT('pages/content/view');
    }

}