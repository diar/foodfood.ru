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
        // Получаем дополнительные параметры
        $photos = MD_Menu::getDishPhotos($id);
        // Показываем страницу
        self::$page['trash']['description'] = $description;
        self::$page['trash']['count'] = $gen_count;
        self::$page['trash']['price'] = $gen_price;
        self::$page['content']['locations'] = $locations;
        self::$page['content']['dish'] = MD_Menu::get(2);
        self::$page['content']['dish']['photos'] = $photos;
        self::showXSLT('pages/dish/view');
    }

}