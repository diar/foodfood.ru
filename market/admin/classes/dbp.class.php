<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с базой данных, с помощью префиксов
 */
class DBP extends DB {

    /**
     * Префикс таблиц
     */
    protected  static $_prefix;

    public static function getPrefix () {
        return self::$_prefix;
    }

    /**
     * Метод вызывается сразу после загрузки класса
     * @return null
     */
    public static function initModule () {
        self::$_prefix = $_SESSION['admin']['city_latin']."_";
    }

    /**
     * Получить таблицу из базы данных в виде ассоциативного массива, упрощенный вариант
     * @param string $table название таблицы
     * @param string $where условие
     * @return array
     */
    public static function getRecords ($table,$where=null,$order=null,$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::getRecords(self::$_prefix.$table,$where,$order,$params);
    }

    /**
     * Получить строку из базы данных в виде ассоциативного массива, упрощенный вариант
     * @param string $table название таблицы
     * @param string $where условие
     * @return array
     */
    public static function getRecord ($table,$where='1=1',$order='id ASC',$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::getRecord(self::$_prefix.$table,$where,$order,$params);
    }

    /**
     * Получить значение из базы данных в виде строки
     * @param string $table название таблицы
     * @param filed  $filed название столбца
     * @param string $where условие
     * @return string
     */
    public static function getValue ($table,$field,$where='1=1',$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::getValue(self::$_prefix.$table,$field,$where,$params);
    }

    /**
     * Получить количество записей в таблице
     * @param string $table название таблицы
     * @param string $where условие
     * @return array
     */
    public static function getCount ($table,$where = null,$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::getCount (self::$_prefix.$table,$where,$params);
    }

    /**
     * Добавление данных в таблицу
     * @param string $table название таблицы
     * @param array  $data  ассоциативный массив данных
     * @param bool   $quote экраниерование значений, по умолчанию true
     * @return string
     */
    public static function insert ($table,$data,$quote=true,$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::insert (self::$_prefix.$table,$data,$quote,$params);
    }

    /**
     * Обновление данных в таблице
     * @param string $table  название таблицы
     * @param array  $data   ассоциативный массив данных
     * @param bool   $quote  экраниерование значений, по умолчанию true
     * @param string $where  условие обновления
     * @return string
     */
    public static function update ($table,$data,$where,$quote=true,$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::update (self::$_prefix.$table,$data,$where,$quote,$params);
    }

    /**
     * Удаление данных из таблицы
     * @param string $table название таблицы
     * @param string $where условие удаления
     * @return string
     */
    public static function delete ($table,$where,$params=null) {
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) $params['join']=self::$_prefix.$params['join'];
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        return parent::delete (self::$_prefix.$table,$where,$params);
    }
}