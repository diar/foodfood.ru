<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы запросами и url
 */
class Router {

    /**
     * Массив для хранения параметров роутера, взятых из файла конфига
     * @var Array
     */
    private static $_route = Array();

    /**
     * Значение uri, которое не нужно изменять
     * @var Array
     */
    private static $_offsetUri = '';

    /**
     * Массив для хранения параметров роутера (controller,action и т.д)
     * @var Array
     */
    private static $_params = Array();

    /**
     * Массив для хранения запросов GET
     * @var Array
     */
    private static $_requests = Array();

    /**
     * Массив для хранения URL переменных
     * @var Array
     */
    private static $_routeParams = Array('page','action','id');

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule () {
        // Разбор url и GET-запроса
        $req = explode ('?',$_SERVER['REQUEST_URI']);
        $uri=preg_replace("/\/+/",'/',$req[0]);
        $uri=preg_replace("/^\/(.*)\/?$/U",'\\1',$uri);
        $offset = Config::getValue('route', 'offset');
        $offset = !empty($offset) ? $offset : 0;
        self::$_params=explode('/',$uri);
        for ($i=0;$i<$offset;$i++) {
            self::$_offsetUri.='/'.array_shift(self::$_params);
        }
        if (!empty($req[1])) {
            $requests = explode('&',$req[1]);
            foreach ($requests as $request) {
                $get = explode('=',$request);
                self::$_requests[$get[0]]=!empty($get[1]) ? $get[1] : true;
            }
        }
        $ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/config/route.ini.php');
        foreach ($ini_array as $ini=>$value) {
            $sect=explode ('.',$ini);
            self::$_route[$sect[0]][$sect[1]]=$value;
        }
    }

    /**
     * Получить запрос GET
     * @param integer $index индекс внутри массива запросов
     * @return string
     */
    public static function getRequest ($index) {
        if (!empty (self::$_requests [$index]))
            return self::$_requests[$index];
    }

    /**
     * Получить настройки роутинга
     * @param $section раздел параметров
     * @param $param название параметра
     * @return string
     */
    public static function getRouteConfig ($section,$param) {
        if (isset (self::$_route[$section][$param])) return self::$_route[$section][$param];
        else return false;
    }

    /**
     * Задать настройки роутинга
     * @param $section раздел параметров
     * @param $params массив параметра
     * @return null
     */
    public static function setRouteConfig ($section,$params) {
        self::$_route[$section] = $params;
    }

    /**
     * Получить URL переменную по индексу
     * @param integer $index индекс внутри массива параметров
     * @return string
     */
    public static function getRouteIndex ($index) {
        if (is_numeric($index) and !empty (self::$_params [$index-1]))
            return self::$_params [$index-1];
    }

    /**
     * Получить URL переменную
     * @param string $param название параметра
     * @return string
     */
    public static function getRouteParam ($param) {
        $keys=array_keys(self::$_routeParams, $param);
        if (!empty($keys)) $var=self::getRouteIndex ($keys[0]+1);
        switch ($param) {
            case 'page'		: {
                    if (empty($var)) $var=Config::getValue('route','default_page');
                    if (empty($var)) $var='index';
                    break;
                }
            case 'action'	: {
                    if (empty($var)) $var=self::getRouteConfig('action',self::getRouteParam('page'));
                    if (empty($var)) $var=Config::getValue('route','default_action');
                    if (empty($var)) $var='index';
                    break;
                }
            default : {
                    if (empty($var)) $var=null;
                    break;
                }
        }
        return $var;
    }

    /**
     * Добавить URL переменную слева
     * @param string $param название параметра
     * @return null
     */
    public static function addRouteParamLeft ($param) {
        array_unshift(self::$_routeParams,$param);
    }

    /**
     * Получить смещение Uri
     * @return string
     */
    static function getOffsetUri() {
        return self::$_offsetUri;
    }

    /**
     * Перенаправление на страницу
     * @param string $path адрес страницы
     * @return null
     */
    public static function setPage ($page) {
        header('Location: '.self::getOffsetUri().$page, true, 303);
        die();
    }
    
    /**
     * Определение IP пользователя
     * @return string
     */
    static function getClientIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Определение Браузера пользователя
     * @return string
     */
    static function getClientUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}