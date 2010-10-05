<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с настройками
 */
class Config {

    /**
     * Массив с конфигурационными параметрами
     * @var array
     */
    static $_config = Array();

    /**
     * Инициализация настроек
     * @return null
     */
    public static function initModule () {
        self::readAll ();
    }

    /**
     * Чтение конфигурации
     * @return array
     */
    public static function readAll () {
        // -- Получение системных из файла
        if (defined('DEBUG'))
            $ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/config/config.debug.ini.php');
        else
            $ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/config/config.stable.ini.php');
        foreach ($ini_array as $ini=>$value) {
            $sect=explode ('.',$ini);
            if ($sect[0]=='path') $value=$_SERVER['DOCUMENT_ROOT'].$value;
            self::$_config[$sect[0]][$sect[1]]=$value;
        }
        // -- Получение настроек сайта
        $ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/config/site.ini.php');
        foreach ($ini_array as $ini=>$value) {
            $sect=explode ('.',$ini);
            self::$_config[$sect[0]][$sect[1]]=$value;
        }
        return self::$_config;
    }

    /**
     * Запись конфигурации в файл
     * @param $sections  массив разделов параметров
     * @param $file название файла
     * @return bool
     */
    public static function write ($sections,$file) {
        $output = "";
        foreach ($sections as $section) {
            switch ($section) {
                case 'site' : $output .= "; Настройки сайта \n";break;
                case 'menu' : $output .= "; Настройка меню (заголовок::page::action) \n";break;
                case 'sms'  : $output .= "; Настройка отправки смс \n";break;
            }
            if (!empty(self::$_config[$section])) {
                foreach (self::$_config[$section] as $param=>$value) {
                    $output .= $section.".".$param." = ".$value."\n";
                }
            }
        }
        try {
            $f = fopen( $file , "w+" );
            fwrite ($f , $output, strlen($output));
            fclose ($f);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Получить запись кофигурации
     * @param $section раздел параметров
     * @param $value название параметра
     * @return string
     */
    public static function getValue ($section,$value) {
        if (isset (self::$_config[$section][$value])) return self::$_config[$section][$value];
        else return false;
    }

    /**
     * Изменить запись кофигурации
     * @param $section раздел параметров
     * @param $value название параметра
     * @param $param новое значение
     * @return string
     */
    public static function setValue ($section,$value,$param) {
        self::$_config[$section][$value]=$param;
    }

    /**
     * Получить раздел кофигурации в виде массива
     * @param $section раздел параметров
     * @return array
     */
    public static function getSection ($section) {
        if (isset (self::$_config[$section])) return self::$_config[$section];
        else return false;
    }
}