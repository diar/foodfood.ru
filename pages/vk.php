<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница получения скидок
 */
class vk_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Получение скидок
    */
    public static function restaurantAction ($id) {
        $left = round((1273434854 - time())/(24*60*60));
        Debug::disable();
        Cache::disable();
        if (empty($id)) {
            $partner = MD_Discount::getPartner();
        } else {
            $partner = MD_Discount::getPartnerByUri($id);
        }

        if (empty($partner)) {
            self::showError();
        }

        $restaurants = MD_Discount::getPartnersActive ();

        if (!empty ($_GET['api_result'])) {
            $user_info = json_decode($_GET['api_result'], true);
            $user_info = $user_info['response'][0];
            $user_name = $user_info['first_name'].' '.$user_info['last_name'];
        } elseif (!empty ($_GET['user_name'])) {
            $user_name = $_GET['user_name'];
        }

        //парсинг переменных
        self::$page['content']['partner'] = $partner;
        self::$page['content']['left'] = $left;
        self::$page['content']['restaurants'] = $restaurants;
        self::$page['content']['user_name'] = $user_name;
        // Показываем страницу
        self::showXSLT('blocks/vkontakte');

    }

    /*
     * Ajax действие получения скидки
    */
    public static function getAjaxAction ($id) {
        // Получаем данные из POST
        echo MD_Discount::getDiscount($_POST['phone'],$_POST['email'],$_POST['name'],$id);
    }
}