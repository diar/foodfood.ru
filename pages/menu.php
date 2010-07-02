<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница меню ресторана, по умолчанию действие View
 */
class menu_Page extends View {

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
     * Вывод меню
    */
    public static function viewAction ($uri) {
        $restaurant=is_numeric($uri) ? MD_Restaurant::getById($uri) : MD_Restaurant::getByUri($uri);
        $menu = MD_Restaurant::getRestaurantMenu($restaurant['id']);
        $tags = MD_Restaurant::getRestaurantTags($restaurant['id']);
        $cooks = MD_Restaurant::getRestaurantCooks($restaurant['id']);
        $check_id = MD_Restaurant::value('rest_check_id',"id = '$restaurant[id]'");
        $check = DB::getValue('list_check','title',"id = '$check_id'");
        $have_menu_map = MD_Restaurant::haveMenuMap($restaurant['id']);
        if (empty($menu)) View::showError();
        self::$page['content']['restaurant'] = $restaurant;
        self::$page['content']['restaurant']['tags'] = $tags;
        self::$page['content']['restaurant']['cooks'] = $cooks;
        self::$page['content']['restaurant']['check'] = $check;
        self::$page['content']['menu_list'] = $menu;
        self::$page['site']['title'] = $restaurant['rest_title'].' | Меню';
        self::$page['content']['restaurant']['have_menu_map'] = $have_menu_map;
        self::showXSLT('pages/restaurant/menu');
    }

    /*
     * Вывод карты бара
    */
    public static function mapAction ($uri) {

        $restaurant=is_numeric($uri) ? MD_Restaurant::getById($uri) : MD_Restaurant::getByUri($uri);
        $menu = MD_Restaurant::getRestaurantMenuMap($restaurant['id']);
        if (empty($menu)) View::showError();
        $tags = MD_Restaurant::getRestaurantTags($restaurant['id']);
        $cooks = MD_Restaurant::getRestaurantCooks($restaurant['id']);
        $check_id = MD_Restaurant::value('rest_check_id',"id = '$restaurant[id]'");
        $check = DB::getValue('list_check','title',"id = '$check_id'");
        $have_menu = MD_Restaurant::haveMenu($restaurant['id']);
        self::$page['content']['restaurant'] = $restaurant;
        self::$page['content']['restaurant']['tags'] = $tags;
        self::$page['content']['restaurant']['cooks'] = $cooks;
        self::$page['content']['restaurant']['check'] = $check;
        self::$page['content']['restaurant']['have_menu'] = $have_menu;
        self::$page['site']['title'] = $restaurant['rest_title'].' | Карта бара';
        self::$page['content']['menu_list'] = $menu;
        self::showXSLT('pages/restaurant/menu_map');
    }
}