<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница виджетов
 */
class widget_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Скидки
    */
    public static function discountAction ($id) {
        Debug::disable();
        Cache::disable();
        $discounts=MD_Discount::getDiscountBlock(array('count'=>7));

        // Добавляем переменные xslt
        self::$page['content']['discounts'] = $discounts;

        // Показываем страницу
        self::showXSLT('pages/widget/discount');
    }

    /*
     * Афиша
    */
    public static function posterAction ($id) {
        Debug::disable();
        Cache::disable();
        $posters=MD_Poster::getPosterBlockToday(array('count'=>8));

        // Добавляем переменные xslt
        self::$page['content']['posters'] = $posters;

        // Показываем страницу
        self::showXSLT('pages/widget/poster');
    }
}