<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Market extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        
    }

    /**
     * Получить список районов
     * @return array
     */
    public static function getLocations () {
        return DB::getRecords(self::getPrefix().'list_location');
    }
    /**
     * Оформление заказа
     * @return array
     */
    public static function order ($name,$phone,$address,$trash) {
        // Проверяем номер телефона
        if (!$phone=String::toPhone($phone))
            $error="Введите номер телефона в правильном формате";
        
        if (!empty($error)) return $error;
        // Если все верно оформляем заказ
        $sms_user_text = 'Ваш заказ принят. Скоро вам позвонит менеджер ресторана';
        MD_Sms::sendSms($phone, $sms_user_text);
        
        return '<span style="color:green">Ваш заказ принят</span>';
    }
}