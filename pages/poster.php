<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница ресторана, по умолчанию действие View
 */
class poster_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        // Получаем список настроений
        $moods=MD_Mood::getMoods();
        // Получаем список тэгов
        $tags=MD_Mood::getTags();

        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['site']['title'] = "Бесплатная доставка пиццы, суши и роллы Казань";
        self::$page['site']['keywords'] = " пицца Казань, суши Казань, роллы Казань, доставка суши Казань, доставка ролл Казань, автосуши Казань, японская кухня Казань";
        self::$page['site']['description'] = '';
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Вывод полного списка
    */
    public static function indexAction ($id) {
        for ($i=-4;$i<5;$i++) {
            $date['week'] = String::toWeek(date('w',time()+$i*60*60*24));
            $date['day'] = date('d/m',time()+$i*60*60*24);
            $date['offset'] = $i;
            $dates[]=$date;
        }

        self::$page['site']['page'] = 'Афиша';
        self::$page['content']['banner']['type'] = 'vertical';
        self::$page['content']['banner']['class'] = 'right_banner';
        self::$page['content']['dates'] = $dates;
        self::$page['content']['poster_today'] = MD_Poster::getPostersToday();
        self::$page['content']['poster_tomorrow'] = MD_Poster::getPostersTomorrow();
        // Показываем страницу
        self::showXSLT('pages/poster/index');
    }
    
    /*
     * Показ одной афиши
    */
    public static function viewAction ($id) {
        self::$page['site']['page'] = 'Афиша';
        self::$page['content']['poster'] = MD_Poster::getPoster($id);
        self::showXSLT('pages/poster/view');
    }

    /*
     * Вывод полного списка
    */
    public static function dateAjaxAction ($id) {
        $date = date('Y:m:d',time()+$_POST['offset']*60*60*24);
        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['date']['month']=String::toMonth(date('m',time()+$_POST['offset']*60*60*24));
        self::$page['date']['day']=date('d',time()+$_POST['offset']*60*60*24);
        self::$page['poster'] = MD_Poster::getPostersToDate($date);
        // Показываем страницу
        self::showXSLT('pages/poster/to_date');
    }

    /*
     * "Я пойду!"
    */
    public static function followAjaxAction ($id) {
        echo MD_Poster::follow($_POST['poster']);
    }

}