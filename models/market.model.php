<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления маркетом
 */
class MD_Market extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        
    }

    /**
     * Получить список заказов в маркете
     * @param $params Параметры
     * @return array
     */
    public static function getOrders($params=null) {
        empty($params['count']) ? $count = 20 : $count = $params['count'];
        $orders = self::getAll(
                        null, 'id DESC', array('table' => 'market_orders', 'limit' => $count)
        );
        foreach ($orders as &$order) {
            $order['date_format'] = date( 'd.m', strtotime($order['start_time']));
        }
        return $orders;
    }

}