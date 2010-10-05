<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для отладки скриптов
 */
class Debug {

    /** Время начала выполнения скрипта
     * @var integer
     */
    private static $_startTime;

    /** Длительность выполнения sql-запросов
     * @var integer
     */
    private static $_sqlTime = 0;

    /** Параметры для дебага
     * @var array
     */
    private static $_params;

    /** Включен ли дебаг
     * @var array
     */
    private static $_enabled;

    /** Печатает переменную в отформатированном виде
     * @param $var переменная
     * @return null;
     */
    public static function dump ($var) {
        switch (gettype($var)) {
            case 'array':
                echo '<span style="color:#171;font-weight:bold;">Array (',sizeof($var),') [</span><br />';
                foreach ($var as $name=>$item) {
                    echo '<div style="padding-left:30px;">';
                    echo '<span style="color:blue">'.
                            $name.'</span> <span style="color:#171">=></span> ';
                    self::dump($item);
                    echo '</div>';
                }
                echo '<span style="color:#171;font-weight:bold;">];</span>';
                break;
            case 'string':
                echo '<span style="color:red">"'.htmlspecialchars($var).
                        '"</span> : string (',strlen($var),'), <br />';
                break;
            default :
                echo '<span style="color:red">'.$var.'</span> : '.
                        gettype($var).' (',strlen($var),'), <br />';
                break;
        }
    }

    /** Печатает переменную в отформатированном виде
     * @param $var переменная
     * @return null;
     */
    public static function dumpSql ($var) {
        $replace=array('SELECT','INSERT','DELETE','UPDATE','FROM','WHERE','ORDER BY','INTO','SET','LIMIT');
        foreach ($replace as $value)
            $var = str_replace($value, '<span style="color:blue">'.$value.'</span>', $var);
        echo $var.'<br />';
    }

    /** Инициализация модуля
     * @return null
     */
    public static function initModule () {
        if (Config::getValue('debug','enable')==true &&
                (empty($_SERVER['HTTP_X_REQUESTED_WITH']) or $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' )) {
            self::$_enabled = true;
        } else {
            self::$_enabled = false;
        }

        self::$_startTime = $_SERVER['REQUEST_TIME'];
    }

    /** Получить текущее время выполнения скрипта
     * @return string
     */
    public static function getExecuteTime () {
        $mtime = explode(" ",microtime());
        return ($mtime[1] + $mtime[0] - self::$_startTime);
    }

    /** Получить общую длительность исполнения SQL
     * @return string
     */
    public static function getSqlTime () {
        return self::$_sqlTime;
    }

    /** Отключить дебаг на данной странице
     * @return null
     */
    public static function disable () {
        self::$_enabled = false;
    }

    /** Включить дебаг на данной странице
     * @return null
     */
    public static function enable () {
        self::$_enabled = true;
    }

    /** Получить текущее время выполнения скрипта
     * @return string
     */
    public static function startTimer () {
        $mtime = explode(" ",microtime());
        self::$_startTime = $mtime[1] + $mtime[0];
    }

    /** Напечатать время выполнения скрипта
     * @return null
     */
    public static function printExecuteTime () {
        echo '<br />Время выполнения скрипта: ',round (self::getExecuteTime (),5),' секунд';
    }

    /** Добавить параметр для дебага
     * @return null
     */
    public static function addParam ($var,$type='string',$time=0) {
        if (Config::getValue('debug','enable')==true) {
            if ($type=='sql') {
                self::$_params[$type][]=$var.'<span style="color:#922"> ['.round ($time,5).']</span>';
                self::$_sqlTime+=$time;
            } else {
                self::$_params[$type][]=$var;
            }
        }
    }

    /** Напечатать переданные на дебаг параметры скрипта
     * @return null
     */
    public static function printParams () {
        if (self::$_enabled) {
            echo '<br /><hr /><span style="color:#922">Время выполнения скрипта: '.
                    round (self::getExecuteTime ()-self::getSqlTime (),5).' секунд</span><br />';
            echo '<span style="color:#922">Время выполнения sql-запросов: '.
                    round (self::getSqlTime (),5).' секунд</span><br />';
            echo '<span style="color:#922">Общее время выполнения: '.
                    round (self::getExecuteTime (),5).' секунд</span><br />';
            if (!empty(self::$_params))
                foreach (self::$_params as $param_type=>$params)
                    switch ($param_type) {
                        case 'string' :
                            echo '====== [дампы переменных] ======<br />';
                            foreach ($params as $param)
                                self::dump($param).'<br />';
                            break;
                        case 'sql' :
                            echo '====== [выполненные запросы] ======<br />';
                            foreach ($params as $param)
                                self::dumpSql($param).'<br />';
                            break;
                    }
        }
    }
}