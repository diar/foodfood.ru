<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс, с которого наследуются все модели
 */
class Model extends DB {

    /**
     * Таблица по умолчанию, с которой работает данная модель
     * @var string
     */
    protected static $_table;
    /**
     * Присоедененная таблица по умолчанию, с которой работает данная модель
     * @var array
     */
    protected static $_join;
    /**
     * Включен ли кеш по умолчанию
     * @var bool
     */
    protected static $_cache;
    /**
     * Префикс таблиц
     */
    protected static $_prefix;

    /**
     * Метод вызывается сразу после загрузки класса
     * @return null
     */
    public static function initModule () {
        $prefix = Router::getRouteParam('city');
        !empty ($prefix) ? self::$_prefix= $prefix.'_' : self::$_prefix= Config::getValue('base', 'prefix').'_';
    }
    /**
     * Получить префикс модели
     * @return string
     */
    public static function getPrefix () {
        return self::$_prefix;
    }
    /**
     * Отключить кеш по умолчанию
     * @return string
     */
    public static function disableCache () {
        self::$_cache[get_called_class()] = false;
    }
    /**
     * Отключить кеш по умолчанию
     * @return string
     */
    public static function enableCache () {
        self::$_cache[get_called_class()] = true;
    }
    /**
     * Отключен ли кеш по умолчанию
     * @return string
     */
    public static function cached () {
        if (!empty(self::$_cache[get_called_class()])) return self::$_cache[get_called_class()];
        else return false;
    }
    /**
     * Получить название таблицы, с которой работает модель
     * @return string
     */
    public static function getModelTable () {
        if (!empty(self::$_table[get_called_class()])) return self::$_table[get_called_class()];
        else return false;
    }
    /**
     * Изменить название таблицы, с которой работает модель
     * @param string $table название таблицы
     * @return string
     */
    public static function setModelTable ($table) {
        self::$_table[get_called_class()] = $table;
    }
    /**
     * Получить название присоедененной таблицы, с которой работает модель
     * @return string
     */
    public static function getJoinTable () {
        if (!empty(self::$_join[get_called_class()])) return self::$_join[get_called_class()];
        else return false;
    }
    /**
     * Получить название присоедененной таблицы, с которой работает модель
     * @param array $table массив с параметрами таблицы
     * @return string
     */
    public static function setJoinTable ($table) {
        self::$_join[get_called_class()] = $table;
    }
    /**
     * Получить таблицу из базы данных в виде ассоциативного массива
     * @param string $where условие
     * @return array
     */
    public static function getAll($where=null,$order=null,$params=null) {
        $table = !empty($params['table']) ? $params['table'] : self::getModelTable();
        !empty ($params['select']) ? $select = $params['select'] : $select = '*';
        $select .= empty($params['no_prefix']) ?
                   ', '.self::getPrefix().$table.'.id AS '.$table.'_id' :
                    ', '.$table.'.id AS '.$table.'_id';
        $params['select'] = $select;
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        // Включаем или отключаем кеширование
        if (empty($params['cache']) && $cache=self::cached()) {
            $params['cache'] = $cache;
        }
        return parent::getRecords(self::$_prefix.self::getModelTable(),$where,$order,$params);
    }
    /**
     * Получить строку из базы данных в виде ассоциативного массива
     * @param string $where условие
     * @return array
     */
    public static function get ($where=null,$order=null,$params=null) {
        $table = !empty($params['table']) ? $params['table'] : self::getModelTable();
        !empty ($params['select']) ? $select = $params['select'] : $select = '*';
        $select .= empty($params['no_prefix']) ?
                   ', '.self::getPrefix().$table.'.id AS '.$table.'_id' :
                    ', '.$table.'.id AS '.$table.'_id';
        $params['select'] = $select;
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        // Включаем или отключаем кеширование
        if (empty($params['cache']) && $cache=self::cached()) {
            $params['cache'] = $cache;
        }
        return parent::getRecord(self::$_prefix.self::getModelTable(),$where,$order,$params);
    }
    /**
     * Получить значение из базы данных в виде строки
     * @param filed  $filed название столбца
     * @param string $where условие
     * @return string
     */
    public static function value ($field,$where=null,$params=null) {
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        return parent::getValue(self::$_prefix.self::getModelTable(),$field,$where,$params);
    }
    /**
     * Получить количество записей в таблице
     * @param string $where условие
     * @return array
     */
    public static function count ($where = null,$params=null) {
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        return parent::getCount (self::$_prefix.self::getModelTable(),$where,$params);
    }
    /**
     * Добавление данных в таблицу
     * @param array  $data  ассоциативный массив данных
     * @param bool   $quote экраниерование значений, по умолчанию true
     * @return string
     */
    public static function add ($data,$quote=true,$params=null) {
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        return parent::insert (self::$_prefix.self::getModelTable(),$data,$quote,$params);
    }
    /**
     * Обновление данных в таблице
     * @param array  $data   ассоциативный массив данных
     * @param bool   $quote  экраниерование значений, по умолчанию true
     * @param string $where  условие обновления
     * @return string
     */
    public static function upd ($data,$where,$quote=true,$params=null) {
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        return parent::update (self::$_prefix.self::getModelTable(),$data,$where,$quote,$params);
    }
    /**
     * Удаление данных из таблицы
     * @param string $where условие удаления
     * @return string
     */
    public static function del ($where,$params=null) {
        // Добавляем префикс к таблицам в параметрах
        if (!empty($params) && empty($params['no_prefix'])) {
            if (!empty($params['join'])) {
                if (!is_array($params['join'])) {
                    $params['join']=self::$_prefix.$params['join'];
                } else {
                    foreach ($params['join'] as &$join)
                        $join=self::$_prefix.$join;
                }
            }
            if (!empty($params['table'])) $params['table']=self::$_prefix.$params['table'];
        }
        // Добавляем присоединенные таблицы
        if (empty($params['join']) && $join=self::getJoinTable()) {
            $join['join'] = self::$_prefix.$join['join'];
            if (empty($params)) $params = Array();
            $params = array_merge ($params,$join);
        }
        return parent::delete (self::$_prefix.self::getModelTable(),$where,$params);
    }

    public static function  __callStatic($m, $a) {
        if (!empty ($a[0]) && substr($m, 0, 6)=='get_by') {
            $param = substr($m, 7);
            $arg = $a[0];
            return self::get($param.'='.self::quote($arg));
        } else return null;
    }

}