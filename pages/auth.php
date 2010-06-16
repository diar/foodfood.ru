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
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Главная страница авторизации
    */
    public static function indexAction ($id) {
        if(!User::isAuth()) self::loginAction();
        else Router::setPage('/');
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