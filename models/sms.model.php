<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель отправки смс
 */
class MD_Sms extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        
    }

    /**
     * Отправка sms
     * @return bool
     */
    public static function sendSms($phone, $text) {
        $result = Sms::sendSms($phone, $text);
        if (!empty($result) && !empty($result['status'])) {
            self::add(array(
                        'sms_phone' => $phone,
                        'sms_text' => $text,
                        'sms_status' => $result['status']
                    ),true,array('no_prefix'=>true,'table'=>'log_sms'));
            if ($result['status'] == 'accepted') {
                return true;
            } else {
                return false;
            }
        } else {
            self::add(array(
                        'sms_phone' => $phone,
                        'sms_text' => $text,
                        'sms_status' => 'error'
                    ),true,array('no_prefix'=>true,'table'=>'log_sms'));
            return false;
        }
    }

}