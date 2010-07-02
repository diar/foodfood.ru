<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница авторизации
 */
class auth_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        // Получаем список настроений
        $moods=MD_Mood::getMoods();
        // Получаем список тэгов
        $tags=MD_Mood::getTags();

        self::$page['site']['city'] = CityPlugin::getCity();
        self::$page['site']['title'] = $content['content_title'];
        self::$page['content']['moods']=$moods;
        self::$page['content']['tags']=$tags;
        self::$page['header']['banner']['type'] = 'horizontal';
        self::$page['header']['banner']['class'] = 'banner770';
    }

    /*
     * Главная страница авторизации
    */
    public static function indexAction ($id) {
        self::$page['content']['invite_code']=Router::getRouteIndex(3);
        self::showXSLT('pages/auth/auth');
    }

    public static function getPromoAjaxAction () {
        if (User::isAuth()) {
            echo 'http://foodfood.ru/kazan/auth/pr'.Session::get('user_id');
        } else {
            echo 'Вам необходимо авторизоваться';
        }
    }
    

    /**
     * Авторизация по ajax
     */
    public static function loginAjaxAction () {
        echo MD_Auth::login($_POST['login'], $_POST['password'], $_POST['remember']);
    }

    /**
     * Страница авторизации
     */
    public static function loginAction () {
        $remember = !empty($_POST['remember']) ? true : false;
        MD_Auth::login($_POST['login'], $_POST['password'], $remember);
        // Доделать!!!!!!!
        self::$page['content']['message']='Логин или пароль неверны';
        self::showXSLT('pages/auth/auth');
    }

    /**
     * Страница изменения пароля
     */
    public static function passwdAjaxAction () {
        echo MD_Auth::passwd($_POST['login']);
    }

    /**
     * Регистрация по ajax
     */
    public static function registrationAjaxAction () {
        echo MD_Auth::registration($_POST['name'],$_POST['mail'],$_POST['phone']);
    }

    /**
     * Выход
     */
    public static function logoutAction () {
        User::logout();
        Router::setPage($_SERVER['HTTP_REFERER']);
    }
}