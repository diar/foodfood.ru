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
        self::$page['site']['title'] = "Доставка еды и пиво Казань";
        self::$page['site']['keywords'] = "еда казань, доставка еды казань, пиво казань, доставка пиво казань";
        self::$page['site']['description'] = '';
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Вывод главной страницы афиши
    */
    public static function indexAction ($id) {
        for ($i=1;$i<32;$i++) {
            $datetime = mktime(0, 0, 0, date('m'), $i, String::getDate());
            $date['week'] = String::toWeek(date('w',$datetime));
            $date['day'] = $i<10 ? '0'.$i : $i;
            $dates[]=$date;
        }
        for ($j=intval(String::getDate())-1;$j<=intval(String::getDate())+1;$j++) {
            for ($i=1;$i<13;$i++) {
                $pos = $i<10 ? '0'.$i : $i;
                $months[]=Array('month'=>$pos,'year'=>$j,'word'=>String::toMonth($i, true).' '.$j);
            }
        }
        self::$page['content']['banner']['type'] = 'vertical';
        self::$page['content']['banner']['class'] = 'right_banner';
        self::$page['content']['dates'] = $dates;
        self::$page['content']['months'] = $months;
        // Показываем страницу
        self::showXSLT('pages/poster/index');
    }

    /*
     * Показ одной афиши
    */
    public static function viewAction ($id) {
        self::$page['content']['poster'] = MD_Poster::getPoster($id);
        self::showXSLT('pages/poster/view');
    }

    /*
     * Вывод полного списка
    */
    public static function dateAjaxAction ($id) {
        $date = $_POST['date'];
        $datetime = mktime(0, 0, 0, $_POST['month'], $_POST['day'], String::getDate());
        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['date']['month']=String::toMonth(date('m',$datetime));
        self::$page['date']['day']=date('d',$datetime);
        self::$page['content'] = MD_Poster::getPostersToDate($date);
        // Показываем страницу
        self::showXSLT('pages/poster/to_date');
    }

    /*
     * Вывод rss
    */
    public static function rssAction ($id) {
        $date = date('Y.m.d');
        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['content'] = MD_Poster::getPostersToDate($date);
        // Показываем страницу
        self::showXSLT('pages/poster/rss');
    }

    /*
     * "Я пойду!"
    */
    public static function followAjaxAction ($id) {
        echo MD_Poster::follow($_POST['poster']);
    }

}