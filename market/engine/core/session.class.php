<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с сессиями
 */
class Session {
    private static $_id=null;
    private static $_data=array();

    /**
     * Использовать или нет стандартный механизм сессий
     * @var bool
     */
    private static $_useCache;

    /**
     * Инициализация модуля
     */
    public static function initModule() {
        self::$_useCache = Config::getValue('session','use_cache');
    }

    /**
     * Старт сессии
     */
    public static function startSession($cache=null) {
        if (isset($cache)) {
            self::$_useCache=$cache;
        }
        if (!self::$_useCache) {
            session_name(Config::getValue('session','name'));
            session_set_cookie_params(
                    Config::getValue('session','timeout'),
                    Config::getValue('cookie','path'),
                    Config::getValue('cookie','host')
            );
            if(!session_id()) {
                session_regenerate_id();
            }
            session_start();
        } else {
            self::setId();
            self::readData();
        }
    }


    /**
     * Устанавливает уникальный идентификатор сессии
     */
    public static function setId() {
        //Если идентификатор есть в куках то берем его
        if (!empty($_COOKIE[Config::getValue('session','name')])) {
            self::$_id=$_COOKIE[Config::getValue('session','name')];
        } else {
            //Иначе создаём новый и записываем его в куку
            self::$_id=self::generateId();
            setcookie(
                    Config::getValue('session','name'),
                    self::$_id,time()+Config::getValue('session','timeout'),
                    Config::getValue('cookie','path'),
                    Config::getValue('cookie','host')
            );
        }
    }

    /**
     * Получает идентификатор текущей сессии
     */
    public static function getId() {
        return self::$_id;
    }

    /**
     * Гинерирует уникальный идентификатор
     * @return unknown
     */
    public static function generateId() {
        return md5(time());
    }

    /**
     * Читает данные сессии
     */
    public static function readData() {
        self::$_data=Cache::getValue(self::$_id);
    }

    /**
     * Сохраняет данные сессии
     */
    public static function save() {
        Cache::setValue(self::$_data,self::$_id,array(),Config::getValue('session','timeout'));
    }

    /**
     * Получает значение из сессии
     * @param string $sName
     * @return unknown
     */
    public static function get($name) {
        if (!self::$_useCache) {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
        } else {
            return isset(self::$_data[$name]) ? self::$_data[$name] : null;
        }
    }

    /**
     * Записывает значение в сессию
     * @param string $sName
     * @param unknown_type $data
     */
    public static function set($name,$data) {
        if (!self::$_useCache) {
            $_SESSION[$name]=$data;
        } else {
            self::$_data[$name]=$data;
            self::save();
        }
    }

    /**
     * Удаляет значение из сессии
     * @param string $sName
     */
    public static function drop($name) {
        if (!self::$_useCache) {
            unset($_SESSION[$name]);
        } else {
            unset(self::$_data[$name]);
            self::save();
        }
    }

    /**
     * Получает разом все данные сессии
     * @return array
     */
    public static function getData() {
        if (!self::$_useCache) {
            return $_SESSION;
        } else {
            return self::$_data;
        }
    }

    /**
     * Завершает сессию, дропая все данные
     */
    public static function dropSession() {
        if (!self::$_useCache) {
            unset($_SESSION);
            session_destroy();
        } else {
            unset(self::$_id);
            unset(self::$_data);
            setcookie(
                    Config::getValue('session','name'),
                    '',1,
                    Config::getValue('cookie','path'),
                    Config::getValue('cookie','host')
            );
        }
    }
}