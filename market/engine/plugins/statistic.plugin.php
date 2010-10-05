<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Плагин для реализации разделения по городам
 */
class StatisticPlugin {

    /**
     * Инициализация плагина
     * @return null
     */
    public static function initPlugin () {
        //Подсчет статистики
        if (!defined('NO_STAT')) {
            $ip = Router::getClientIp();
            $count = DB::getValue('statistic', 'count', 'ip='.DB::quote($ip));
            if (empty($count)) $count = 0;
            DB::replace('statistic', Array('ip'=>$ip,'count'=>$count+1));
        }
    }
}