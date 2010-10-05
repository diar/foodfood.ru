<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Главная страница, по умолчанию действие Index
 */
class user_Page extends View {
    /*
     * Инициализация контроллера
     */

    public static function initController($action) {

    }

    /*
     * авторизация по аяякс
     */

    public static function loginAjaxAction($id) {
        echo MD_Auth::login($_POST['login'], $_POST['password'], $_POST['remember']);
    }

    /*
     * Регистрация по аякс
     */

    public static function registrationAjaxAction($id) {
        echo MD_Auth::registration($_POST['name'], $_POST['mail'], $_POST['phone']);
    }

    /*
     * Страница входа
     */

    public static function authAction() {
        $error = null;
        if (!empty($_POST['login']) && !empty($_POST['login'])) {


            $remember = !empty($_POST['remember']) ? true : false;
            $login = MD_Auth::login($_POST['login'], $_POST['password'], $remember);

            switch ($login) {
                case 'SPACE':
                    $error = 'Заполните поле телефон и пароль';
                    break;
                case 'NOT_EXIST':
                    $error = 'Неверный логин или пароль';
                    break;
                case 'OK':
                    header('location: /');
                    die();
                    break;
                case 'LOGIN':
                    $error = 'Неверный логин';
                    break;
                default :
                    $error = $login;
                    break;
            }
        }
        self::$page['header']['content']['error'] = $error;
        self::showXSLT('pages/user/auth');
    }

    /**
     * Восстановление пароля
     */
    public static function rememberAction() {
        $error = null;
        if (!empty($_POST['login'])) {
            $response = MD_Auth::passwd($_POST['login']);
            switch ($response) {
                case 'SPACE':
                    $error = 'Введите e-mail';
                    break;
                case 'OK':
                    $error = 'Пароль выслан';
                    break;
                case 'LOGIN':
                    $error = 'Неверный логин';
                    break;
            }
        }
        self::$page['header']['content']['message'] = $error;
        self::showXSLT('pages/user/remember');
    }

    /**
     * Регистрация
     */
    public static function registrationAction() {
        $error = null;

        if (!empty($_POST['email']) && !empty($_POST['name'])) {
            if (!isset($_POST['apply']) or $_POST['apply'] == false)
                $error = "Ознакомтесь с правилами";
            else {
                $response = MD_Auth::registration($_POST['name'], $_POST['email']);
                switch ($response) {
                    case 'SPACE':
                        $error = 'Заполните все поля предложенной формы';
                        break;
                    case 'OK':
                        $error = 'Регистрация прошла успешно, пароль выслан на e-mail';
                        break;
                    case 'NOT_MAIL':
                        $error = 'Неверный адрес электронный почты';
                        break;
                    case 'MAIL_EXIST':
                        $error = 'Вы уже зарегистрированы, <a href="/user/remember">восстановить пароль?</a>';
                        break;
                    default :
                        $error = 'Неизвестная ошибка';
                        break;
                }
            }
        }
        self::$page['header']['content']['message'] = $error;
        self::showXSLT('pages/user/registration');
    }


    /**
     * 
     */
    public static function trashAction() {
        $itog = 0;
        $trash = $_SESSION['trash'];
        if (sizeof($trash) > 0) {
            foreach ($trash as &$item) {
                $present = $item['is_present'] > 0 ? 200 : 0;
                $itog += $item['gen_price'] = $item['count'] * $item['price'] + $present;
                $item['tmb_image'] = DB::getValue('kazan_market_products', 'tmb_image',"id = '$item[item_id]'");
            }
        }
        if (!empty($_POST))
        self::$page['header']['content']['message'] = 'Заказ принят. Скоро с Вами свяжуться';
        self::$page['header']['content']['itog'] = $itog;
        self::$page['header']['content']['trash'] = $trash;

        self::showXSLT('pages/user/trash');
    }

    /**
     * Выход
     */
    public static function logoutAction() {
        User::logout();
        Router::setPage("/");
    }

}