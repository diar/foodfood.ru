<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с пользователями
 */
class User {


    /**
     * Название таблицы пользователей
     * @var string
     */
    private static $_table;
    /**
     * Бэкенд авторизации
     * @var string
     */
    private static $_backend;
    /**
     * Настройки пользователя
     * @var string
     */
    private static $_params = null;

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule() {
        self::$_backend = (Config::getValue('user','backend'));
        self::$_table = (Config::getValue('user','table_'.self::$_backend));
    }
    /**
     * Проверка авторизации пользователя
     * @return bool
     */
    public static function auth () {
        self::$_params=call_user_func(array('Auth', 'auth_'.self::$_backend));
        return self::$_params['is_auth'];
    }
    /**
     * Авторизация пользователя - все параметры внутри массива
     * @param string $login Логин
     * @param string $password Пароль
     * @param string $crypted Если true, то строка уже зашифрована
     * @return bool
     */
    public static function login ($params) {
        self::$_params=call_user_func(array('Auth', 'login_'.self::$_backend),$params);
        return self::$_params['is_auth'];
    }
    /**
     * Удаление авторизации пользователя
     * @return bool
     */
    public static function logout () {
        self::$_params['is_auth']=false;
        return call_user_func(array('Auth', 'logout_'.self::$_backend));
    }
    /**
     * Авторизован ли пользователь
     * @return bool
     */
    public static function isAuth() {
        return self::$_params['is_auth'];
    }

    /**
     * Генерация пароля
     * @return string;
     */
    public static function generatePassword () {
        return substr(md5(time()),rand(0,24),6);
    }
    /**
     * Задать настройки пользователя
     * @return null
     */
    public static function setParams ($params) {
        self::$_params = $params;
    }
    /**
     * Получить настройки пользователя
     * @return null
     */
    public static function getParams () {
        return self::$_params;
    }
    /**
     * Получить пользователя по id
     * @return bool
     */
    public static function getById($id) {
        return call_user_func(array('User', 'getById_'.self::$_backend),$id);
    }
    /**
     * Получить пользователя по id
     * @return bool
     */
    public static function getById_ls($id) {
        return DB::getRecord (
                self::$_table,'user_id='.DB::quote($id)
        );
    }

    /**
     * Получить пользователя по ключу сессии
     * @return User;
     */
    public static function getUserBySessionKey_ls($key) {
        $user = DB::getRecord(Config::getValue('session','table'),'session_key='.DB::quote($key),null,Array(
                'join'=>'user','left'=>'user_id','right'=>'user_id'
        ));
        return $user;
    }
    /**
     * Получить пользователя по ключу сессии
     * @return array;
     */
    public static function getSessionByUserId_ls($id) {
        $session = DB::getRecord(Config::getValue('session','table'),'user_id='.DB::quote($id));
        if (!empty($session)) return $session;
        else return null;
    }

    /**
     * Получить данные пользователя
     * @param string $param Параметр
     * @return mixed
     */
    public static function getParam($param) {
        return isset(self::$_params[$param]) ? self::$_params[$param] : null;
    }
    /**
     * Создать сессию
     * @param string $param Параметр
     * @return mixed
     */
    public static function createSession_ls($session,$key,$user_id) {
        if (!empty($session)) {
            DB::replace(Config::getValue('session','table'), Array(
                    'session_key' => DB::quote($key),
                    'user_id' => DB::quote($user_id),
                    'session_ip_create'=> DB::quote($session['session_ip_create']),
                    'session_ip_last'=>DB::quote(Router::getClientIp()),
                    'session_date_create'=>DB::quote($session['session_date_create']),
                    'session_date_last'=>'NOW()'
                    ),null,false);
        } else {
            DB::replace(Config::getValue('session','table'), Array(
                    'session_key' => DB::quote($key),
                    'user_id' => DB::quote($user_id),
                    'session_ip_create'=> DB::quote(Router::getClientIp()),
                    'session_ip_last'=>DB::quote(Router::getClientIp()),
                    'session_date_create'=>'NOW()',
                    'session_date_last'=>'NOW()'
                    ),null,false);
        }
    }
}