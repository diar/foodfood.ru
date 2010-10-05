<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с sms
 */
class Sms {

    /**
     * Логин, Пароль и Отправитель
     * @var <type>
     */
    private static $_login;
    private static $_password;
    private static $_sender;
    protected static $_gates = Array (
            'beeline' => 'sms.beemail.ru',
            'megafon' => 'sms.mgsm.ru',
            'mts' => 'sms.gate.ru'
    );

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule () {
        self::$_login=Config::getValue('sms','login');
        self::$_password=Config::getValue('sms','password');
        self::$_sender=Config::getValue('sms','sender');
    }

    /**
     * Отправляет текстовое сообщение
     * @param string $phone номер телефона
     * @param string $text текст сообщения
     * @return array
     */
    public static function sendSms ($phone,$text) {
        return self::sendSmsByPost ($phone,$text);
    }

    /**
     * Получить остаток на счете
     * @return integer
     */
    public static function getCredit () {
        return self::getCreditByGet ();
    }

    /**
     * Проверить статус сообщения
     * @param string $smsId идентификатор сообщения
     * @return string
     */
    public static function getStatus ($smsId) {
        return self::getStatusByGet ($smsId);
    }

    /**
     * Отправляет текстовое сообщение, с помощью GET
     * @param string $phone номер телефона
     * @param string $text текст сообщения
     * @param string $sender отправитель
     * @return array
     */
    public static function sendSmsByGet ($phone,$text) {
        $text=urlencode($text);
        $phone=urlencode($phone);
        $login=self::$_login;
        $password=self::$_password;
        $sender=self::$_sender;
        try {
            @$handle = fopen("http://$login:$password@gate.prostor-sms.ru/send/?phone=$phone&text=$text&sender=$sender", "r");
            @$contents = stream_get_contents($handle);
            @fclose($handle);
            $resp = explode ('=',$contents);
            if (!empty($resp [0])) $response['sms_id']=$resp [0];
            if (!empty($resp [1])) $response['status']=$resp [1];
            if (!empty($response)) return $response;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Отправляет текстовое сообщение, с помощью POST
     * @param string $phone номер телефона
     * @param string $text текст сообщения
     * @param string $sender отправитель
     * @return array
     */
    public static function sendSmsByPost ($phone,$text) {

        $text=$text;
        $phone=$phone;
        $login=self::$_login;
        $password=self::$_password;
        $sender=self::$_sender;

        $xmlCode = "<?xml version='1.0' encoding='UTF-8'?><data>
            <login>$login</login>
            <password>$password</password>
            <action>send</action>
            <text>$text</text>
            <to number='$phone'></to>
            <source>$sender</source>
        </data>";
        $curl = curl_init();


        curl_setopt($curl, CURLOPT_URL, 'https://transport.sms-pager.com:7214/send.xml');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlCode);
        $res = curl_exec($curl);

        if (!$res) {
            $error = curl_error($curl) . '(' . curl_errno($curl) . ')';
            $return['status'] == $error;
            return $return;
        } else {
            $return['status'] = 'accepted';
            return $return;
        }

    }

    /**
     * Отправляет текстовое сообщение, с помощью WSDL
     * @param string $phone номер телефона
     * @param string $text текст сообщения
     * @param string $sender отправитель
     * @return array
     */
    public static function sendSmsByWSDL ($phone,$text) {
        $client = new SoapClient(
                'http://api.prostor-sms.ru/WebService.asmx?wsdl',
                array(
                        'encoding'=>'UTF-8',
                        'location'=>'api.prostor-sms.ru',
                )
        );
        $result = $client->SendTextMessage (
                self::$_login, self::$_password,$phone,$text,'Food','true','false','3'
        );

        $ret['status']=$result->СommandStatus;
        $ret['value']=$result->messageld;
        return $ret;
    }

    /**
     * Получить остаток на счете, с помощью GET
     * @return integer
     */
    public static function getCreditByGet () {
        $login=self::$_login;
        $password=self::$_password;
        try {
            @$handle = fopen("http://$login:$password@gate.prostor-sms.ru/credits/", "r");
            @$contents = stream_get_contents($handle);
            @fclose($handle);
            $resp = explode ('=',$contents);
            if (!empty($resp [1])) return $resp [1];
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Получить остаток на счете, с помощью WSDL
     * @return integer
     */
    public static function getCreditByWSDL () {
        $client = new SoapClient('http://api.prostor-sms.ru/WebService.asmx?wsdl');
        $result = $client->GetCreditBalance (self::$_login, self::$_password);
        $ret['status']=$result->GetCreditBalanceResult;
        $ret['value']=$result->creditBalance;
        return $ret;
    }

    /**
     * Проверить статус сообщения, с помощью GET
     * @param string $smsId идентификатор сообщения
     * @return string
     */
    public static function getStatusByGet ($smsId) {
        $login=self::$_login;
        $password=self::$_password;
        try {
            @$handle = fopen("http://$login:$password@gate.prostor-sms.ru/status/?id=$smsId", "r");
            @$contents = stream_get_contents($handle);
            @fclose($handle);
            $resp = explode ('=',$contents);
            if (!empty($resp [1])) return $resp [1];
        } catch (Exception $e) {
            return null;
        }
    }
}