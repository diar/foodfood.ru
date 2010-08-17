<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница ресторана, по умолчанию действие View
 */
class restaurant_Page extends View {

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
     * Получение скидок
    */
    public static function viewAction ($uri) {
        // Получаем ссылку на следующий и предыдущий рестораны
        $params = explode ('-',$uri);
        $uri = $params[0];
        $mood = !empty($params[1]) ? $params[1] : 'none';
        $offset = !empty($params[2]) ? intval($params[2]) : 1;
        $next = MD_Restaurant::getRestaurantNext($mood, $offset);
        $prev = MD_Restaurant::getRestaurantPrev($mood, $offset);
        // Получаем информацию о ресторане
        $restaurant=is_numeric($uri) ? MD_Restaurant::getById($uri) : MD_Restaurant::getByUri($uri);
        // Если ресторана не существует, показываем ошибку
        if (empty($restaurant)) View::showError();
        // Получаем информацию о скидках
        $partner= MD_Discount::getPartnerById($restaurant['id']);
        // Получаем новости и фото ресторана
        $posters = MD_Poster::getRestaurantPosters($restaurant['id']);
        $tags = MD_Restaurant::getRestaurantTags($restaurant['id']);
        $reviews = MD_Restaurant::getRestaurantReviews($restaurant['id'],array('count'=>10));
        $photos = MD_Restaurant::getRestaurantPhotos($restaurant['id']);
        $categories = MD_Restaurant::getRestaurantCategories($restaurant['id']);
        $cooks = MD_Restaurant::getRestaurantCooks($restaurant['id']);
        $diets = MD_Restaurant::getRestaurantDiets($restaurant['id']);
        $musics = MD_Restaurant::getRestaurantMusics($restaurant['id']);
        $payments = MD_Restaurant::getRestaurantPayments($restaurant['id']);
        $worktime = MD_Restaurant::getRestaurantWorktime($restaurant['id']);
        $have_menu = MD_Restaurant::haveMenu($restaurant['id']);
        $have_menu_map = MD_Restaurant::haveMenuMap($restaurant['id']);
        $mood_title = DB::getValue('list_mood','title',"uri = '$mood'");
        $title = 'Ресторан '.$restaurant['rest_title'].'. Меню, скидки, акции и заказ столиков на FoodFood.ru';
        $description = str_replace('"', '\'', $restaurant['rest_description']);
        $user_vote = MD_Rating::getUserVote($restaurant['id']);
        $followers = MD_Restaurant::getFollowers($restaurant['id']);

        // Добавляем переменные xslt
             
        self::$page['site']['title'] = $title;
        self::$page['site']['description'] = preg_replace('/<[^>]*>|\\r|\\n/i', '', $description);
        self::$page['person'] = MD_Person::getLikePerson($restaurant['id']);
        self::$page['content']['restaurant'] = $restaurant;
        self::$page['content']['discount'] = MD_Discount::getPartnerById($restaurant['id']);
        self::$page['content']['restaurant']['posters'] = $posters;
        self::$page['content']['restaurant']['mood_title'] = $mood_title;
        self::$page['content']['restaurant']['partner'] = $partner;
        self::$page['content']['restaurant']['tags'] = $tags;
        self::$page['content']['restaurant']['reviews'] = $reviews;
        self::$page['content']['restaurant']['photos'] = $photos;
        self::$page['content']['restaurant']['categories'] = $categories;
        self::$page['content']['restaurant']['cooks'] = $cooks;
        self::$page['content']['restaurant']['diets'] = $diets;
        self::$page['content']['restaurant']['musics'] = $musics;
        self::$page['content']['restaurant']['payments'] = $payments;
        self::$page['content']['restaurant']['worktime'] = $worktime;
        self::$page['content']['restaurant']['have_menu'] = $have_menu;
        self::$page['content']['restaurant']['have_menu_map'] = $have_menu_map;
        self::$page['content']['restaurant']['user_vote'] = $user_vote;
        self::$page['content']['restaurant']['followers'] = $followers;
        // Временное решение для баннера на страницах пяти ресторанов
        if ($restaurant['id'] == 96 || $restaurant['id'] == 196 || $restaurant['id'] == 207 ||
                $restaurant['id'] == 191 || $restaurant['id'] == 200)
            self::$page['content']['restaurant']['tmp_banner'] = true;
        if ($restaurant['id'] == 133 || $restaurant['id'] == 156 || $restaurant['id'] == 66 ||
                $restaurant['id'] == 152 || $restaurant['id'] == 110 || $restaurant['id'] == 111)
            self::$page['content']['restaurant']['tmp_banner2'] = true;
        self::$page['content']['navigate']['next'] = $next;
        self::$page['content']['navigate']['prev'] = $prev;
        self::$page['content']['navigate']['mood'] = $mood;
        self::$page['content']['navigate']['offset'] = $offset;

        // Показываем страницу
        self::showXSLT('pages/restaurant/view');
    }

    /*
     * Добавить комментарий для ресторана или изменить рэйтинг
    */
    public static function commentAjaxAction ($id) {
        $text = !empty ($_POST['text']) ? $_POST['text'] : '';
        $to_admin = $_POST['to_admin']=='true' ? true : false;
        $rating_target = !empty ($_POST['target']) ? $_POST['target'] : '';
        echo MD_Rating::addComment($id,$rating_target,$text,$to_admin);
    }

    /*
     * Изменить рэйтинг ресторана по звездочкам
    */
    public static function ratingAjaxAction ($id) {
        echo MD_Rating::changeRatingStar($id,$_POST['rating_param'],$_POST['rating_value']);
    }

    /*
     * Бронь столика
    */
    public static function reservAjaxAction ($id) {
        echo MD_Restaurant::reserv(
                $_POST['rest_id'],$_POST['date'],$_POST['time'],$_POST['name'],$_POST['phone'],$_POST['count'],$_POST['text']
        );
    }

    /*
     * Пошли со мной в ресторан
    */
    public static function followAjaxAction ($id) {
        echo MD_Restaurant::follow($id);
    }
}