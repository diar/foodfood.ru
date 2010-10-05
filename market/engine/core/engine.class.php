<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Основной класс движка
 */
include_once 'autoload.php';

class Engine {
    
    /** Инициализация движка, подключение модулей
     * @return null
     */
    public static function initModule () {
        /* Подключение модуля отладки */
        Event::addListener('Engine','START','Debug','startTimer');
        Event::addListener('Engine','STOP','Debug','printParams');
        /* Подключение модуля сессии */
        Event::addListener('Engine','START','Session','startSession');
        /* Проверка авторизации пользователя */
        Event::addListener('Engine','START','User','auth');
        /* Подключение активных плагинов */
       // Event::addListener('Engine','START','CityPlugin','initPlugin');
        //Event::addListener('Engine','STOP','StatisticPlugin','initPlugin');
        /* Отображение страницы */
        Event::addListener('Engine','START','View','showPage');
        /* Подключение обработки ошибок */
        Event::addListener('Error','SYS','Engine','stopModule');
        /* Старт движка */
        Event::sendEvent('Engine','START');
        //------- Здесь идет работа движка--------
        /* Завершение работы движка */
        Event::sendEvent('Engine','STOP');
    }

    /** Завершение работы скрипта
     * @return null
     */
    public static function stopModule () {
        foreach (Error::getErrorByCode('SYS') as $error)
            echo $error;
        die();
    }
}