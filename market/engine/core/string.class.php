<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы со строками
 */
class String {

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule () {
        date_default_timezone_set('Europe/Moscow');
    }

    /**
     * Склонение после числительных
     * @param $number число
     * @param $nom именительный падеж
     * @param $gens родительный падеж, единственное число
     * @param $genl родительный падеж, множественное число
     * @return string;
     */
    public static function toDeclension ($number,$nom,$gens,$genl) {
        if (intval($number)==0) return 'нет '.$genl;
        $digit = $number % 10;
        $digit_two = $number % 100;
        if ($digit ==1 && $digit_two!=11) return $number.' '.$nom;
        elseif (
        ($digit == 2 && $digit_two!=12) ||
                ($digit == 3 && $digit_two!=13) ||
                ($digit == 4 && $digit_two!=14)
        ) return $number.' '.$gens;
        else return $number.' '.$genl;
    }

    /**
     * Получить название месяца
     * @return string;
     */
    public static function toMonth ($month,$nom=false) {
        if (!$nom) {
            switch ($month) {
                case 1 : return 'января';
                case 2 : return 'февраля';
                case 3 : return 'марта';
                case 4 : return 'апреля';
                case 5 : return 'мая';
                case 6 : return 'июня';
                case 7 : return 'июля';
                case 8 : return 'августа';
                case 9 : return 'сентября';
                case 10 : return 'октября';
                case 11 : return 'ноября';
                case 12 : return 'декабря';
            }
        } else {
            switch ($month) {
                case 1 : return 'январь';
                case 2 : return 'февраль';
                case 3 : return 'март';
                case 4 : return 'апрель';
                case 5 : return 'май';
                case 6 : return 'июнь';
                case 7 : return 'июль';
                case 8 : return 'август';
                case 9 : return 'сентябрь';
                case 10 : return 'октябрь';
                case 11 : return 'ноябрь';
                case 12 : return 'декабрь';
            }
        }
    }

    /**
     * Получить название недели
     * @return string;
     */
    public static function toWeek ($week) {
        switch ($week) {
            case 0 : return 'вс';
            case 1 : return 'пн';
            case 2 : return 'вт';
            case 3 : return 'ср';
            case 4 : return 'чт';
            case 5 : return 'пт';
            case 6 : return 'сб';
        }
    }

    /**
     * Проверка - является ли строка email-ом
     * @param $str строка
     * @return bool;
     */
    public static function isEmail ($str) {
        return preg_match('/^[[:alnum:]-_.]+[@].[[:alnum:]-_]+\.[[:lower:]]{2,4}$/i',$str);
    }

    /**
     * Проверка - является ли строка датой
     * @param $str строка
     * @return bool;
     */
    public static function isDate ($str) {
        return preg_match('/^[[:digit:]]{4,4}-[[:digit:]]{2,2}-[[:digit:]]{2,2}$/i',$str);
    }

    /**
     * Проверка - является ли строка логином
     * @param $str строка
     * @return bool;
     */
    public static function isLogin ($str) {
        return preg_match('/^[\da-zа-я\_\-\.]{2,10}$/iu', $str);
    }

    /**
     * Получить текущую дату
     * @return string;
     */
    public static function getDate () {
        $str=getdate();
        return $str['year'];
    }

    /**
     * Преобразовать номер телефона
     * @return string;
     */
    public static function toPhone ($str) {
        $str = preg_replace("/[^0-9]/",'',$str);
        $str = preg_replace("/^(79|89|9)/",'+79',$str);
        if (preg_match('/^[+]?[[:digit:]]{5,12}$/i',$str))
            return $str;
        else return false;
    }
    /**
     * Проверка - является ли строка номером
     * @return string;
     */
    public static function isPhone ($str) {
        $str = preg_replace("/[^0-9]/",'',$str);
        $str = preg_replace("/^(79|89|9)/",'+79',$str);
        if (preg_match('/^[+]?[[:digit:]]{5,12}$/i',$str))
            return true;
        else return false;
    }
}