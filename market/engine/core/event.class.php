<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с сигналами
 */
class Event {

    /** Массив из журнала сигналов
     * @var Array
     */
    private static $_events=Array();

    /** Инициализация модуля
     * @return null
     */
    public static function initModule () {

    }

    /** Добавление обработчика событий
     * @param string $sender    объект-источник
     * @param string $event     событие
     * @param string $listener  объект-приемник
     * @param string $func      обработчик
     * @return null
     */
    public static function addListener ($sender,$event,$listener,$func) {
        if (empty(self::$_events[$sender][$event])) self::$_events[$sender][$event] = Array ();
        array_push (self::$_events[$sender][$event],array(0=>$listener,1=>$func));
    }

    /** Удаление обработчика события
     * @param string $sender    объект-источник
     * @param string $event     событие
     * @param string $listener  объект-приемник
     * @return null
     */
    public static function removeListener ($sender,$event,$listener) {
        if (isset (self::$_events[$sender][$event][$listener]))
            unset(self::$_events[$sender][$event][$listener]);
    }

    /** Удаление всех обработчиков события
     * @param string $sender    объект-источник
     * @param string $event     событие
     * @return null
     */
    public static function removeAllListeners ($sender,$event) {
        if (isset (self::$_events[$sender][$event]))
            unset(self::$_events[$sender][$event]);
    }

    /** Отправка события
     * @param string $sender    объект-источник
     * @param string $event     событие
     * @return null
     */
    public static function sendEvent ($sender,$event) {
        if (isset (self::$_events[$sender][$event]))
            foreach (self::$_events[$sender][$event] as $execute) {
                if (method_exists($execute[0], $execute[1]))
                    call_user_func($execute);
                else
                    Error::setError('SYS','Ошибка вызова функции '.$execute[1].' у класса '.$execute[0]);
            }
    }
}