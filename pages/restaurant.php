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
     * Бронь столика
    */
    public static function reservAjaxAction ($id) {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $name = $_POST['name'];
        $phone = String::toPhone($_POST['phone']);
        $count = $_POST['count'];
        $text = $_POST['text'];
        $rest_id = intval($_POST['rest_id']);
        $rest_phone = MD_Restaurant::value('rest_reserv_phone','id ='.$rest_id);
        $rest_title = MD_Restaurant::value('rest_title','id ='.$rest_id);
        $rest_text = "Бронь в $rest_title.Дата:$date.Время:$time.Имя:$name.тел:$phone.человек:$count.Текст:$text";
        Sms::sendSmsByGet($rest_phone, $rest_text);
        $text = 'Вам перезвонят через 5 минут';
        Sms::sendSmsByGet($phone, $text);
        echo 'OK';

    }
}