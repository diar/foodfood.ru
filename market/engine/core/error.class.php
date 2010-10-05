<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для обработки ошибок
 */
class Error {
    
    /** Массив ошибок во время исполнения скрипта
     * @var Array
     */
    private static $_errors = Array ();
    
    /** Инициализация модуля
     * @return null
     */
    public static function initModule () {
        
    }

    /** Запись ошибки в журнал
     * @param string $code  код ошибки, если SYS то скрипт завершает работу
     * @param string $error текст ошибки
     * @return null
     */
    static function setError ($code,$error) {
        self::$_errors [$code][]=$error;
        Event::sendEvent('Error',$code);
    }

    /** Получить ошибки по коду в виде массива
     * @param code код ошибки
     * @return array
     */
    static function getErrorByCode ($code) {
        return self::$_errors [$code];
    }
}