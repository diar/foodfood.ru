<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Service extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        
    }

    /**
     * Обратная связь
     * @return null
     */
    public static function callback($text,$mail) {
        // Проверяем на соответствие данных
        $mail = strtolower($mail);
        if(trim($text)=='' || trim($mail)=='') {
            return "SPACE";
        }
        if (!String::isEmail($mail)) return "NOT_MAIL";

        $text = 'Обратная связь ['.$mail.']: '.$text;
        $mail = Mail::newMail($text,'support@foodfood.ru','foodfood.ru',$mail);
        $mail->Send();
        echo "OK";
    }

}