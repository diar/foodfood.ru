<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница карты сайта
 */
class sitemap_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Скидки
    */
    public static function sitemapAction ($id) {
        header('Content-type: text/xml');
        $city = CityPlugin::getCity();
        // Добавляем переменные xslt
        $url = array(
                array('loc'=>'http://foodfood.ru/','priority'=>'1','changefreq'=>'hourly'),
                array('loc'=>'http://foodfood.ru/'.$city.'/discount','priority'=>'0.8','changefreq'=>'hourly'),
                array('loc'=>'http://foodfood.ru/'.$city.'/poster','priority'=>'0.8','changefreq'=>'hourly'),
                array('loc'=>'http://foodfood.ru/'.$city.'/persons','priority'=>'0.8','changefreq'=>'hourly'),
                array('loc'=>'http://foodfood.ru/blog/','priority'=>'0.7','changefreq'=>'daily')
        );
        $restaurans = Model::getAll('is_hidden=0', null, array('table'=>'rest','select'=>'rest_uri'));
        $news=MD_News::getAll(null, 'id DESC LIMIT 0,10');
        foreach ($restaurans as $restauran) {
            $url[] = array(
                    'loc'=>'http://foodfood.ru/'.$city.'/restaurant/'.$restauran['rest_uri'],
                    'priority'=>'0.5','changefreq'=>'weekly'
            );
        }
        foreach ($news as $item) {
            $url[] = array(
                    'loc'=>'http://foodfood.ru/'.$city.'/news/'.$item['id'],
                    'priority'=>'0.5','changefreq'=>'weekly'
            );
        }
        self::$page['content'] = $url;

        // Показываем страницу
        self::showXSLT('pages/sitemap/sitemap');
    }
}