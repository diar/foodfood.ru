<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Плагин для реализации разделения по городам
 */
class CityPlugin {

    /**
     * Текущий город, название на латинском
     * @var String
     */
    private static $_cityLatin = null;

    /**
     * Текущий город, название на русском
     * @var String
     */
    private static $_cityRus = null;

    /**
     * Текущий город, id
     * @var String
     */
    private static $_cityId = null;

    /**
     * Инициализация плагина
     * @return null
     */
    public static function initPlugin () {
        Router::addRouteParamLeft('city');
        $city_latin=Router::getRouteParam ('city');
        if (empty($city_latin) || !$city=DB::getRecord(
        'city_list','city_latin='.DB::quote($city_latin),null,array('cache'=>true)
        )) {
            self::initCity();
            Session::set('city_id',self::getCityId());
            Router::setPage ('/'.self::getCity().'/');
        } else {
            self::$_cityId= $city ['id'];
            self::$_cityLatin= $city ['city_latin'];
            self::$_cityRus= $city ['city'];
            Session::set('city_id',self::getCityId());
        }
    }

    /**
     * Получить название текущего города на латинском
     * @return string
     */
    public static function getCity () {
        return self::$_cityLatin;
    }

    /**
     * Получить название текущего города на русском
     * @return string
     */
    public static function getCityRus () {
        return self::$_cityRus;
    }

    /**
     * Получить id города
     * @return int
     */
    public static function getCityId () {
        return self::$_cityId;
    }

    /**
     * Получение названия города
     * @return bool
     */
    public static function initCity() {
        // Пробуем взять название города из настроек пользователя
        $city_id=Session::get('city_id');
        if (!empty($city_id)) {
            $city = DB::getRecord('city_list','id='.DB::quote($city_id));
            if (!empty($city) and count($city)>0) {
                self::$_cityId= $city ['id'];
                self::$_cityLatin= $city ['city_latin'];
                self::$_cityRus= $city ['city'];
                return true;
            }
        }
        // Получаем из конфига настройки города по умолчанию
        $city_latin = Config::getValue('route','default_city');
        $city = DB::getRecord('city_list','city_latin='.DB::quote($city_latin));
        if (!empty($city) and count($city)>0) {
            self::$_cityId= $city ['id'];
            self::$_cityLatin= $city ['city_latin'];
            self::$_cityRus= $city ['city'];
            return true;
        }
        // Пробуем определить название по ip
        $ip=Router::getClientIp();
        $post_string = '<ipquery><fields><city/></fields><ip-list><ip>'.$ip.'</ip></ip-list></ipquery>';
        if (!$socket  = fsockopen("194.85.91.253", 8090))
            return true;
        $query  = "POST /geo/geo.html HTTP/1.1\r\n";
        $query .= "Content-Length: ".strlen ($post_string)."\r\n";
        $query .= "\r\n".$post_string."\r\n\r\n";
        $response = '';
        fwrite($socket, $query);
        while (!feof($socket)) {
            $response .= fgets($socket, 2048);
        }
        fclose($socket);
        $xml = trim(substr($response, strpos($response,"\r\n\r\n")));
        if (!empty($xml)) return self::$_city;
        $doc = new DOMDocument;
        $doc->loadXML($xml);
        $xmlpath = new domxpath($doc);
        $ip_answer = $doc->getElementsByTagName("ip-answer")->item(0);
        $items     = $xmlpath->query("ip", $ip_answer);
        foreach ($items as $item) {
            $ip = $item->getAttribute('value');
            $city_rus=$xmlpath->query("city", $item)->item(0)->nodeValue;
            $city = DB::getRecord('city_list','city='.DB::quote($city_rus));
            if (!empty($city) and count($city)>0) {
                self::$_cityId= $city ['id'];
                self::$_cityLatin= $city ['city_latin'];
                self::$_cityRus= $city ['city'];
                return true;
            }
        }
        return true;
    }
}