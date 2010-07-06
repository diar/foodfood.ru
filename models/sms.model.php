<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением ресторанов
 */
class MD_Sms extends Model {
    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('log_sms');
    }
}