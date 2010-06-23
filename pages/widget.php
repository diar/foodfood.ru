<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница получения скидок
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
        $discounts=MD_Discount::getDiscountBlock(array('count'=>20));

        // Добавляем переменные xslt
        self::$page['content']['discounts'] = $discounts;

        // Показываем страницу
        self::showXSLT('pages/widget/discount');
    }
}