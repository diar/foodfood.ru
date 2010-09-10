<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Главная страница, по умолчанию действие Index
 */
class dish_Page extends View {

    /*
     * Инициализация контроллера
     */
    public static function initController($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['site']['keywords'] = 'пицца, суши, роллы, доставка пиццы, доставка суши и роллы Казань';
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Вывод блюда
     */
    public static function viewAction($id) {
        $locations = MD_Market::getLocations();
        // Формируем описание корзины
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : null;
        
        if (sizeof($trash) > 0) {
            $gen_price = 0;
            $gen_count = 0;
            foreach ($trash AS $dish) {
                foreach ($dish['items'] as $item) {
                    $gen_price+=$item['price'] * $item['count'];
                    $gen_count+=$item['count'];
                }
            }
            $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                    '<span class="price">' . $gen_price . '</span> руб. ' .
                    'Все доставим за 40 минут, если пробок не будет. ' .
                    'Еще позвоним и все уточним, спасибо. ';
        } else {
            $description = '';
            $gen_count = 0;
            $gen_price = 0;
        }
        //получаем меню.. Нужно вывести его layout
        $menu_types = MD_Menu::getMenuTypes();
        $current_location = !empty($_COOKIE['market_location']) ? intval($_COOKIE['market_location']) : 0;
        $rest_menu = DB::getRecords(MD_Menu::getPrefix().'rest','in_market = 1 AND rest_location_id ='.$current_location);
        // Подготавливаем вывод блюда
        $dish = MD_Menu::get($id);
        $dish['portion'] = explode("%", $dish['portion']);
        $dish['price'] = explode("%", $dish['price']);
        $dish['second_portion'] = explode("%", $dish['second_portion']);
        // Получаем дополнительные параметры
        $photos = MD_Menu::getDishPhotos($id);

        // Показываем страницу
        self::$page['trash']['description'] = $description;
        self::$page['trash']['count'] = $gen_count;
        self::$page['trash']['price'] = $gen_price;
        self::$page['content']['locations'] = $locations;
        self::$page['content']['dish'] = $dish;
        self::$page['content']['current_location'] = $current_location;

        //Debug::dump($_COOKIE);
        self::$page['content']['dish']['photos'] = $photos;
        self::$page['content']['dish']['menu_types'] = $menu_types;
        self::$page['content']['dish']['rest_menu'] = $rest_menu;
        self::showXSLT('pages/dish/view');
    }

}