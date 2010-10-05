<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с базой данных
 */
class DB {

    /**
     * Идентификатор подключения
     * @var PDO
     */
    protected static $_connection;

    /**
     * Метод вызывается сразу после загрузки класса
     * @return null
     */
    public static function initModule () {
        self::connectBase ();
    }

    /**
     * Подключение к базе данных
     * @return bool
     */
    public static function connectBase () {
        $config=Config::getSection('base');
        if (!empty($config)) {
            try {
                // Подсчет времени подключения к базе данных
                $mtime = explode(" ",microtime());
                $start= $mtime[1] + $mtime[0];

                // Подключение к базе данных
                self::$_connection = new PDO(
                        $config['bd'].':host='.$config['host'].';dbname='.$config['dbase'],
                        $config['login'], $config['password']
                        ) or Error::setError('SYS','Ошибка при подключении к базе данных');

                // Подсчет длительности выполнения
                $mtime = explode(" ",microtime());
                $time = $mtime[1] + $mtime[0] - $start;
                Debug::addParam('Подключение к базе данных','sql',$time);

                // Настройка кодировки подключения
                self::query("set character_set_client='utf8'");
                self::query("set character_set_results='utf8'");
                self::query("set collation_connection='utf8_general_ci'");
                return true;
            } catch (Exception $e) {
                Error::setError('SYS','Невозможно подключиться к базе данных: '.$e->getMessage());
            };
        }
        else Error::setError('SYS','Не заданы настройки для подключения к базе данных');
    }

    /**
     * Запрос - получение данных из базы
     * @param string $query запрос
     * @return PDOStatement
     */
    public static function query ($query) {
        // Подсчет времени начала запроса
        $mtime = explode(" ",microtime());
        $start= $mtime[1] + $mtime[0];
        // Выполнение запроса
        $result = self::$_connection->query($query);

        // Подсчет длительности выполнения
        $mtime = explode(" ",microtime());
        $time = $mtime[1] + $mtime[0] - $start;
        Debug::addParam($query,'sql',$time);
        return $result;
    }

    /**
     * Запрос - внесение изменений в базу данных
     * @param string $query запрос
     * @return int
     */
    public static function exec ($query) {
        // Подсчет времени начала запроса
        $mtime = explode(" ",microtime());
        $start= $mtime[1] + $mtime[0];
        // Выполнение запроса
        $result = self::$_connection->exec($query);

        // Подсчет длительности выполнения
        $mtime = explode(" ",microtime());
        $time = $mtime[1] + $mtime[0] - $start;
        Debug::addParam($query,'sql',$time);
        return $result;
    }

    /**
     * Запрос - получить ID последнего вставленного элемента
     * @return int
     */
    public static function lastInsertId () {
        return self::$_connection->lastInsertId();
    }

    /**
     * Получить таблицу из базы данных в виде ассоциативного массива
     * @param string $query запрос
     * @param bool $cache кешировать ли запрос
     * @return array
     */
    public static function fetchAll ($query,$cache=false) {
        if (!$cache) {
            $result = self::query($query);
            if (!empty($result)) return $result->fetchAll(PDO::FETCH_ASSOC);
            else return false;
        } else {
            $result=Cache::getValue(md5($query));
            if ($result) return $result;
            $result = self::query($query);
            if (!empty($result)) {
                $result = $result->fetchAll(PDO::FETCH_ASSOC);
                Cache::setValue(md5($query),$result);
                return $result;
            }
            else return false;
        }
    }

    /**
     * Получить строку из базы данных в виде ассоциативного массива
     * @param string $query запрос
     * @param bool $cache кешировать ли запрос
     * @return array
     */
    public static function fetch ($query,$cache=false) {
        if (!$cache) {
            $result = self::query($query);
            if (!empty($result)) return $result->fetch(PDO::FETCH_ASSOC);
            else return false;
        } else {
            $result=Cache::getValue(md5($query));
            if ($result) return $result;
            $result = self::query($query);
            if (!empty($result)) {
                $result = $result->fetch(PDO::FETCH_ASSOC);
                Cache::setValue(md5($query),$result);
                return $result;
            }
            else return false;
        }
    }

    /**
     * Получить таблицу из базы данных в виде ассоциативного массива, упрощенный вариант
     * @param string $table название таблицы
     * @param string $where условие
     * @param string $order сортировка
     * @param array $params параметры
     * @return array
     */
    public static function getRecords ($table,$where=null,$order=null,$params=null) {
        $table = !empty($params['table']) ? $params['table'] : $table;
        $from = ' `'.self::escape($table).'` ';
        if (!empty($params['join'])&&!empty($params['left'])&&!empty($params['right'])) {
            if (!is_array($params['join'])) {
                $from.=' LEFT JOIN `'.self::escape($params['join']).'` ON '.
                        self::escape($table).'.'.$params['left'].'='.
                        self::escape($params['join']).'.'.$params['right'].' ';
            } else {
                $i=0;
                foreach ($params['join'] as $join) {
                    $from.=' LEFT JOIN `'.self::escape($join).'` ON '.
                            self::escape($table).'.'.$params['left'][$i].'='.
                            self::escape($join).'.'.$params['right'][$i].' ';
                    $i++;
                }
            }
        }
        $select = !empty($params['select']) ? $params['select'] : '*';
        $order = $order!=null ? ' ORDER BY '.$order : ' ';
        if (!empty ($params['count'])) {
            $count=$params['count'];
            $offset=!empty($params['offset']) ? $params['offset']*$count : 0;
            $limit = ' LIMIT '.$offset.','.$count.' ';
        } else {
            $limit = !empty($params['limit']) ? ' LIMIT '.$params['limit'] : ' ';
        }
        $where==null ? $where=' ' : $where=' WHERE '.$where;
        $query='SELECT '.$select.' FROM'.$from.$where.$order.$limit;
        $cache=!empty($params['cache']) && $params['cache'];
        return self::fetchAll($query,$cache);
    }

    /**
     * Получить строку из базы данных в виде ассоциативного массива, упрощенный вариант
     * @param string $table название таблицы
     * @param string $where условие
     * @param string $order сортировка
     * @param array $params параметры
     * @return array
     */
    public static function getRecord ($table,$where=null,$order=null,$params=null) {
        $table = !empty($params['table']) ? $params['table'] : $table;
        $from = ' `'.self::escape($table).'` ';
        if (!empty($params['join'])&&!empty($params['left'])&&!empty($params['right'])) {
            if (!is_array($params['join'])) {
                $from.=' LEFT JOIN `'.self::escape($params['join']).'` ON '.
                        self::escape($table).'.'.$params['left'].'='.
                        self::escape($params['join']).'.'.$params['right'].' ';
            } else {
                $i=0;
                foreach ($params['join'] as $join) {
                    $from.=' LEFT JOIN `'.self::escape($join).'` ON '.
                            self::escape($table).'.'.$params['left'][$i].'='.
                            self::escape($join).'.'.$params['right'][$i].' ';
                    $i++;
                }
            }
        }
        $select = !empty($params['select']) ? $params['select'] : '*';
        $order = $order!=null ? ' ORDER BY '.$order : ' ';
        $limit = !empty($params['limit']) ? ' LIMIT '.$params['limit'] : ' LIMIT 0,1 ';
        if ($where!=null) {
            is_numeric($where) ? $where=' WHERE '.$table.'.id='.self::quote($where) : $where=' WHERE '.$where;
        } else {
            $where=' ';
        }
        $query='SELECT '.$select.' FROM'.$from.$where.$order.$limit;
        $cache=!empty($params['cache']) && $params['cache'];
        return self::fetch($query,$cache);
    }

    /**
     * Получить значение из базы данных в виде строки
     * @param string $table название таблицы
     * @param filed  $filed название столбца
     * @param string $where условие
     * @return string
     */
    public static function getValue ($table,$field,$where='1=1',$params=null) {
        $table = !empty($params['table']) ? $params['table'] : $table;
        $query='SELECT '.$field.' FROM '.self::escape($table).' WHERE '.$where.' LIMIT 0,1';
        $cache=!empty($params['cache']) && $params['cache'];
        $row=self::fetch($query,$cache);
        if (!empty ($row[$field])) return $row[$field];
        else return null;
    }

    /**
     * Получить количество записей в таблице
     * @param string $table название таблицы
     * @param string $where условие
     * @return array
     */
    public static function getCount ($table,$where = null,$params=null) {
        $sql = "SELECT COUNT(*) FROM `".$table."`";
        if (!empty ($where))
            $sql .=" WHERE ".$where;
        $record = self::fetch($sql);
        if (!empty($record['COUNT(*)'])) return intval($record['COUNT(*)']);
        else return 0;
    }

    /**
     * Экранирование запроса
     * @param string $string строка, которую нужно экранировать
     * @return string
     */
    public static function escape($string) {
        return mysql_escape_string ($string);
    }

    /**
     * Экранирование и добавление кавычки
     * @param string $string строка, которую нужно экранировать
     * @return string
     */
    public static function quote($string) {
        return self::$_connection->quote($string);
    }

    /**
     * Добавление данных в таблицу
     * @param string $table название таблицы
     * @param array  $data  ассоциативный массив данных
     * @param bool   $quote экраниерование значений, по умолчанию true
     * @return string
     */
    public static function insert ($table,$data,$quote=true,$params=null) {
        $table = !empty($params['table']) ? $params['table'] : $table;
        $into = ' `'.self::escape($table).'` ';
        foreach ($data as $item=>$value) {
            $names[]=self::escape($item);
            $quote ? $values[]=self::quote($value)  : $values[]=$value;
        }
        $name=implode (', ',$names);
        $value=implode (', ',$values);
        $query = 'INSERT INTO'.$into.'('.$name.') VALUES ('.$value.')';
        return self::exec($query);
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
        $table = !empty($params['table']) ? $params['table'] : $table;
        $into = ' `'.self::escape($table).'` ';
        foreach ($data as $item=>$value) {
            $quote ?  $sets[]=$item.'='.self::quote($value) : $sets[]=$item.'='.$value;
        }
        $where==null ? $where=' ' : $where=' WHERE '.$where;
        $set=implode (', ',$sets);
        $query = 'UPDATE'.$into.'SET '.$set.$where;
        return self::exec($query);
    }

    /**
     * Замена данных в таблице
     * @param string $table  название таблицы
     * @param array  $data   ассоциативный массив данных
     * @param bool   $quote  экраниерование значений, по умолчанию true
     * @param string $where  условие обновления
     * @return string
     */
    public static function replace ($table,$data,$where=null,$quote=true,$params=null) {
        $table = !empty($params['table']) ? $params['table'] : $table;
        $into = ' `'.self::escape($table).'` ';
        foreach ($data as $item=>$value) {
            $quote ?  $sets[]=$item.'='.self::quote($value) : $sets[]=$item.'='.$value;
        }
        $where==null ? $where=' ' : $where=' WHERE '.$where;
        $set=implode (', ',$sets);
        $query = 'REPLACE INTO'.$into.'SET '.$set.$where;
        return self::exec($query);
    }

    /**
     * Удаление данных из таблицы
     * @param string $table название таблицы
     * @param string $where условие удаления
     * @return string
     */
    public static function delete ($table,$where,$params=null) {
        $query = 'DELETE FROM `'.self::escape($table).'` WHERE '.$where;
        return self::exec($query);
    }
}