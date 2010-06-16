<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с e-mail
 */
class Mail {

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule () {
        require_once (Config::getValue('path','libs').'phpmailer/class.phpmailer.php');
    }

    /**
     * Создание класса отправки e-mail
     * @return PHPMailer
     */
    public static function newMail ($body,$address,$subject) {
        $mail = new PHPMailer ();
        $mail->IsMail();
        $mail->SetFrom(Config::getValue('site','email'), Config::getValue('site','name'));
        $mail->AddAddress($address);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        return $mail;
    }
}