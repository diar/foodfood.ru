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
        // Получаем список настроений
        $moods = MD_Mood::getMoods();
        // Получаем список тэгов
        $tags = MD_Mood::getTags();

        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['site']['title'] = 'Все кафе и рестораны Казани на FoodFood.ru';
        self::$page['site']['description'] = "Food food сочетает в себе полноценный ресторанный портал " .
                "с каталогом ресторанов и сообществом любителей вкусно поесть. " .
                "На портале представлены все кафе и рестораны города Казани с меню, фотографиями и отзывами. " .
                "На сайте есть возможность заказать банкет, забронировать стол, получить скидку и " .
                "конечно же представлена доставка еды. Каждому посетителю портала будет доступно в " .
                "интерактивной форме: Выбор ресторана; Просмотр меню; Афиши; Интерьера; Отзывы и рекомендации; " .
                "Скидки в кафе и ресторане; Доставка блюд. ";
        // получаем лицо foodfood которое желает приятного аппетита
        self::$page['person'] = MD_Person::getPerson();
        self::$page['content']['moods'] = $moods;
        self::$page['content']['tags'] = $tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Главная страница сайта
     */

    public static function indexAction($id) {
        // Получаем рекомендуемые рестораны
        $recomended = MD_Restaurant::getRecomended ();
        $recomended['banner']['type'] = 'vertical';
        $recomended['banner']['class'] = 'banner240n320';
        // Получаем новый ресторан
        $new_rest = MD_Restaurant::getNew();
        // Получаем список последних новостей
        $news = MD_News::getAll(null, 'id DESC LIMIT 0,5');
        // Получаем список статей и афиш
        $articles = MD_Article::getArticleBlocks(array('count' => 20));
        $posters = MD_Poster::getPosterBlocksWeek(array('count' => 20));
        // Получаем список скидок
        $discounts = MD_Discount::getDiscountBlock(array('count' => 7));
        // Получаем список отзывов
        $reviews = MD_Restaurant::getRestaurantsReviews(array('count' => 4));
        // Добавляем переменные xslt
        self::$page['content']['reviews'] = $reviews;
        self::$page['content']['articles'] = $articles;
        self::$page['content']['discounts'] = $discounts;
        self::$page['content']['posters'] = $posters;
        self::$page['content']['recomended'] = $recomended;
        self::$page['content']['new_rest'] = $new_rest;
        self::$page['content']['news'] = $news;

        // Показываем страницу
        self::showXSLT('pages/index/index');
    }

    /*
     * Получаем список ресторанов по настроению через ajax
     */

    public static function moodAjaxAction($id) {
        // Вычисляем количество выводимых ресторанов по ширине экрана
        self::$page['site']['city'] = CityPlugin::getCity();
        if (!empty($_POST['tags'])) {
            $tags = unserialize($_POST['tags']);
        } else {
            $tags = null;
        }
        $page_width = $_POST['width'];
        $offset = $_POST['offset'];
        $item_count = ceil(($page_width - 54) / 234);
        $restaurants = MD_Restaurant::getRestaurantsByMood(
                        $tags, $_POST['mood'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
        );
        $page_count = ceil(count(MD_Restaurant::getRestaurantsByMood(
                                        $tags, $_POST['mood'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                        )) / (3 * ($item_count - 1)));
        if (!empty($restaurants))
            foreach ($restaurants as &$rest) {
                preg_match('/^(.*?)\,/', $rest['rest_address'], $rest_address);
                if (!empty($rest_address[1])) {
                    $rest['rest_address'] = '(' . trim(preg_replace('/ул\.|Ул\.|пр\./', '', $rest_address[1])) . ')';
                }
            }
        // Добавляем переменные xslt
        self::$page['item_count'] = $item_count;
        self::$page['page_count'] = $page_count;
        self::$page['mood'] = $_POST['mood'];
        self::$page['restaurants'] = $restaurants;

        // Показываем страницу
        self::showXSLT('pages/index/search');
    }

    /*
     * Получаем список ресторанов по букве через ajax
     */

    public static function charAjaxAction($id) {
        // Вычисляем количество выводимых ресторанов по ширине экрана
        self::$page['site']['city'] = CityPlugin::getCity();
        if (!empty($_POST['tags'])) {
            $tags = unserialize($_POST['tags']);
        } else {
            $tags = null;
        }
        $page_width = $_POST['width'];
        $offset = $_POST['offset'];
        $item_count = ceil(($page_width - 54) / 234);
        $restaurants = MD_Restaurant::getRestaurantsByChar(
                        $tags, $_POST['char'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
        );
        $page_count = ceil(count(MD_Restaurant::getRestaurantsByChar(
                                        $tags, $_POST['char'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                        )) / (3 * ($item_count - 1)));
        if (!empty($restaurants))
            foreach ($restaurants as &$rest) {
                preg_match('/^(.*?)\,/', $rest['rest_address'], $rest_address);
                if (!empty($rest_address[1])) {
                    $rest['rest_address'] = trim(preg_replace('/ул\.|Ул\.|пр\./', '', $rest_address[1]));
                }
            }

        // Добавляем переменные xslt
        self::$page['item_count'] = $item_count;
        self::$page['page_count'] = $page_count;
        self::$page['char'] = $_POST['char'];
        self::$page['restaurants'] = $restaurants;

        // Показываем страницу
        self::showXSLT('pages/index/search');
    }

    /*
     * Получаем список ресторанов по букве через ajax
     */

    public static function searchAjaxAction($id) {
        // Вычисляем количество выводимых ресторанов по ширине экрана
        self::$page['site']['city'] = CityPlugin::getCity();
        if (!empty($_POST['tags'])) {
            $tags = unserialize($_POST['tags']);
        } else {
            $tags = null;
        }
        $page_width = $_POST['width'];
        $offset = $_POST['offset'];
        $item_count = ceil(($page_width - 54) / 234);
        $page_count = 0;
        switch ($_POST['search_by']) {
            case 'search_by_rest' :
                $restaurants = MD_Restaurant::searchRestaurantByTitle(
                                $tags, $_POST['text'], array('count' => 3 * ($item_count - 1), 'offset' => $offset, 'ext_search' => true)
                );
                if (!empty($restaurants))
                    $page_count = ceil(count(MD_Restaurant::searchRestaurantByTitle(
                                                    $tags, $_POST['text'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                                    )) / (3 * ($item_count - 1)));
                break;
            case 'search_by_cook' :
                $restaurants = MD_Restaurant::searchRestaurantByCook(
                                $tags, $_POST['text'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
                );
                if (!empty($restaurants))
                    $page_count = ceil(count(MD_Restaurant::searchRestaurantByCook(
                                                    $tags, $_POST['text'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                                    )) / (3 * ($item_count - 1)));
                break;
            case 'search_by_music' :
                $restaurants = MD_Restaurant::searchRestaurantByMusic(
                                $tags, $_POST['text'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
                );
                if (!empty($restaurants))
                    $page_count = ceil(count(MD_Restaurant::searchRestaurantByMusic(
                                                    $tags, $_POST['text'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                                    )) / (3 * ($item_count - 1)));
                break;
            case 'search_by_category' :
                $restaurants = MD_Restaurant::searchRestaurantByCategory(
                                $tags, $_POST['text'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
                );
                if (!empty($restaurants))
                    $page_count = ceil(count(MD_Restaurant::searchRestaurantByCategory(
                                                    $tags, $_POST['text'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                                    )) / (3 * ($item_count - 1)));
                break;
            case 'search_by_menu' :
                $restaurants = MD_Restaurant::searchRestaurantByMenu(
                                $tags, $_POST['text'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
                );
                if (!empty($restaurants))
                    $page_count = ceil(count(MD_Restaurant::searchRestaurantByMenu(
                                                    $tags, $_POST['text'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                                    )) / (3 * ($item_count - 1)));
                break;
            case 'search_by_address' :
                $restaurants = MD_Restaurant::searchRestaurantByAddress(
                                $tags, $_POST['text'], array('count' => 3 * ($item_count - 1), 'offset' => $offset)
                );
                if (!empty($restaurants))
                    $page_count = ceil(count(MD_Restaurant::searchRestaurantByAddress(
                                                    $tags, $_POST['text'], array('count' => 5000, 'offset' => 0, 'select' => 'id')
                                    )) / (3 * ($item_count - 1)));
                break;
        }
        if (!empty($restaurants)) {
            foreach ($restaurants as &$rest) {
                preg_match('/^(.*?)\,/', $rest['rest_address'], $rest_address);
                if (!empty($rest_address[1])) {
                    $rest['rest_address'] = trim(preg_replace('/ул\.|Ул\.|пр\./', '', $rest_address[1]));
                }
            }
        } else {
            echo '<div class="message">Поиск не дал результатов.';
        }
        // Добавляем переменные xslt
        self::$page['item_count'] = $item_count;
        self::$page['page_count'] = $page_count;
        self::$page['restaurants'] = $restaurants;

        // Показываем страницу
        self::showXSLT('pages/index/search');
    }

    /*
     * Получаем список ресторанов по настроению через ajax
     */

    public static function randomAjaxAction($id) {
        // Вычисляем количество выводимых ресторанов по ширине экрана
        self::$page['site']['city'] = CityPlugin::getCity();
        if (!empty($_POST['tags'])) {
            $tags = unserialize($_POST['tags']);
        } else {
            $tags = null;
        }
        $page_width = $_POST['width'];
        $offset = $_POST['offset'];
        $item_count = ceil(($page_width - 54) / 234);
        $restaurants = MD_Restaurant::getRestaurantsByRand(
                        $tags, array('count' => 3 * ($item_count - 1), 'offset' => $offset)
        );
        $page_count = ceil(count(MD_Restaurant::getRestaurantsByRand(
                                        $tags, array('count' => 5000, 'offset' => 0, 'select' => 'id')
                        )) / (3 * ($item_count - 1)));
        if (!empty($restaurants))
            foreach ($restaurants as &$rest) {
                preg_match('/^(.*?)\,/', $rest['rest_address'], $rest_address);
                if (!empty($rest_address[1])) {
                    $rest['rest_address'] = trim(preg_replace('/ул\.|Ул\.|пр\./', '', $rest_address[1]));
                };
            }

        // Добавляем переменные xslt
        self::$page['item_count'] = $item_count;
        self::$page['page_count'] = $page_count;
        self::$page['restaurants'] = $restaurants;

        // Показываем страницу
        self::showXSLT('pages/index/search');
    }

    /*
     * Получаем список ресторанов по настроению через ajax
     */

    public static function allAjaxAction($id) {
        // Вычисляем количество выводимых ресторанов по ширине экрана
        self::$page['site']['city'] = CityPlugin::getCity();
        if (!empty($_POST['tags'])) {
            $tags = unserialize($_POST['tags']);
        } else {
            $tags = null;
        }
        $page_width = $_POST['width'];
        $offset = $_POST['offset'];
        $item_count = ceil(($page_width - 55) / 225);
        $restaurants = MD_Restaurant::getRestaurantsAll(
                        $tags, array('count' => 3 * ($item_count - 1), 'offset' => $offset)
        );
        $page_count = ceil(count(MD_Restaurant::getRestaurantsAll(
                                        $tags, array('count' => 5000, 'offset' => 0, 'select' => 'id')
                        )) / (3 * ($item_count - 1)));
        if (!empty($restaurants))
            foreach ($restaurants as &$rest) {
                preg_match('/^(.*?)\,/', $rest['rest_address'], $rest_address);
                if (!empty($rest_address[1])) {
                    $rest['rest_address'] = trim(preg_replace('/ул\.|Ул\.|пр\./', '', $rest_address[1]));
                }
            }
        // Добавляем переменные xslt
        self::$page['item_count'] = $item_count;
        self::$page['page_count'] = $page_count;
        self::$page['restaurants'] = $restaurants;

        // Показываем страницу
        self::showXSLT('pages/index/search');
    }

}