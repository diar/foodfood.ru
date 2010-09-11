<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Главная страница, по умолчанию действие Index
 */
class index_Page extends View {
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
     * Главная страница сайта
     */
    public static function indexAction($id) {
        $locations = MD_Market::getLocations();
        $menu_types = MD_Menu::getMenuTypes();
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
        $current_location = !empty($_COOKIE['market_location']) ? intval($_COOKIE['market_location']) : 0;
        $rest_menu = DB::getRecords(MD_Menu::getPrefix().'rest','in_market = 1 AND rest_location_id ='.$current_location);
        
        // Показываем страницу
        self::$page['trash']['description'] = $description;
        self::$page['trash']['count'] = $gen_count;
        self::$page['trash']['price'] = $gen_price;
        self::$page['content']['locations'] = $locations;
        self::$page['content']['current_location'] = $current_location;
        self::$page['content']['menu_types'] = $menu_types;
        self::$page['content']['rest_menu'] = $rest_menu;
        self::showXSLT('pages/index/index');
    }

    /*
     * Вывод формы оформление заказа
     */

    public static function orderAjaxAction($id) {
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : Array();
        $gen_price = 0;
        foreach ($trash AS $dish) {
            foreach ($dish['items'] as $item) {
                $gen_price+=$item['price'] * $item['count'];
            }
        }
        self::$page['trash'] = $trash;
        self::$page['trash']['price'] = $gen_price;
        self::showXSLT('pages/ajax/order');
    }

    /*
     * Оформление заказа
     */

    public static function orderSubmitAjaxAction($id) {
        echo MD_Market::order($_POST['name'], $_POST['phone'], $_POST['address'], $_SESSION['trash']);
    }

    /*
     * Вывод списка меню
     */
    public static function menuAjaxAction($id) {
        if (!empty($_POST['menu_tags'])) {
            $current_tags = unserialize($_POST['menu_tags']);
        } else {
            $current_tags = Array();
        }
        $menu_tags = MD_Menu::getMenuTags($current_tags);
        $dishes = MD_Menu::getDishByType($_POST['menu_type_id'],$_POST['location']);
        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['dishes'] = $dishes;
        self::$page['menu_tags'] = $menu_tags;
        self::showXSLT('pages/ajax/dish');
    }

    /*
     * Добавить блюдо в корзину
     */
    public static function addAjaxAction($id) {
        // Это пиздец
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : Array();
        $dish_id = intval($_POST['dish_id']);
        $rest_id = intval($_POST['rest_id']);
        $price = intval($_POST['price']);
        $portion = intval($_POST['portion']);
        $title = $_POST['title'];
        if (empty($trash[$dish_id])) {
            $trash[$dish_id] = Array(
                'rest_id' => $rest_id, 
                'title' => $title,
                'dish_id' => $dish_id,
                'items' => array(
                    $portion => array('count' => 1, 'price' => $price, 'portion' => $portion)
                )
            );
        } elseif (empty($trash[$dish_id]['items'][$portion])) {
            $trash[$dish_id]['items'][$portion] = array('count' => 1, 'price' => $price, 'portion' => $portion);
        } else {
            $trash[$dish_id]['items'][$portion]['count'] += 1;
        }
        $_SESSION['trash'] = $trash;
        $gen_price = 0;
        $gen_count = 0;
        foreach ($trash AS $dish) {
            foreach ($dish['items'] as $item) {
                $gen_price+=$item['price'] * $item['count'];
                $gen_count+=$item['count'];
            }
        }
        if ($gen_price < 300)
                $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ';

        else
             $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ' .
                'Все доставим за 40 минут, если пробок не будет. ' .
                'Еще позвоним и все уточним, спасибо. ';
        echo $description;
    }

    /*
     * Удалить блюдо из корзины
     */
    public static function removeAjaxAction($id) {
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : Array();
        $dish_id = intval($_POST['dish_id']);
        $portion = intval($_POST['portion']);
        if (!empty($trash[$dish_id]['items'][$portion])) {
            unset($trash[$dish_id]['items'][$portion]);
        }
        if (empty($trash[$dish_id]['items'])) {
            unset($trash[$dish_id]);
        }
        $_SESSION['trash'] = $trash;
        $gen_price = 0;
        $gen_count = 0;
        foreach ($trash AS $dish) {
            foreach ($dish['items'] as $item) {
                $gen_price+=$item['price'] * $item['count'];
                $gen_count+=$item['count'];
            }
        }
        if ($gen_price < 300)
                $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ';
               
        else
             $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ' .
                'Все доставим за 40 минут, если пробок не будет. ' .
                'Еще позвоним и все уточним, спасибо. ';
        echo $description;
        
    }

    /*
     * Увеличить кол-во блюда в корзине
     */
    public static function plusAjaxAction($id) {
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : Array();
        $dish_id = intval($_POST['dish_id']);
        $portion = intval($_POST['portion']);
        if (!empty($trash[$dish_id]['items'][$portion])) {
            $trash[$dish_id]['items'][$portion]['count']++;
        }
        $_SESSION['trash'] = $trash;
        $gen_price = 0;
        $gen_count = 0;
        foreach ($trash AS $dish) {
            foreach ($dish['items'] as $item) {
                $gen_price+=$item['price'] * $item['count'];
                $gen_count+=$item['count'];
            }
        }
        if ($gen_price < 300)
                $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ';

        else
             $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ' .
                'Все доставим за 40 минут, если пробок не будет. ' .
                'Еще позвоним и все уточним, спасибо. ';
        echo $description;
    }

    /*
     * Уменьшить кол-во блюда в корзине
     */
    public static function minusAjaxAction($id) {
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : Array();
        $dish_id = intval($_POST['dish_id']);
        $portion = intval($_POST['portion']);
        if (!empty($trash[$dish_id]['items'][$portion])) {
            $trash[$dish_id]['items'][$portion]['count']--;
        }
        if ($trash[$dish_id]['items'][$portion]['count']==0) {
            unset($trash[$dish_id]['items'][$portion]);
        }
        if (empty($trash[$dish_id]['items'])) {
            unset($trash[$dish_id]);
        }
        $_SESSION['trash'] = $trash;
        $gen_price = 0;
        $gen_count = 0;
        foreach ($trash AS $dish) {
            foreach ($dish['items'] as $item) {
                $gen_price+=$item['price'] * $item['count'];
                $gen_count+=$item['count'];
            }
        }
        if ($gen_price < 300)
                $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ';

        else
             $description = 'Всего в корзине <span class="count">' . $gen_count . '</span> блюд на сумму ' .
                '<span class="price">' . $gen_price . '</span> руб. ' .
                'Все доставим за 40 минут, если пробок не будет. ' .
                'Еще позвоним и все уточним, спасибо. ';
        echo $description;
    }

    public static function set_locationAjaxAction($id){
        setcookie("market_location", $_POST['location'],time()+3600*24*20,"/");
    }

}