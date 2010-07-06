<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Auth extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {

    }

    /**
     * Регистрация
     * @return string
     */
    public static function registration ($name,$mail,$phone,$params=null) {
        // Проверяем на соответствие данных
        $mail = strtolower($mail);
        if(trim($name)=='' || trim($mail)=='' || trim($phone)=='') {
            return "SPACE";
        }
        if (!String::isEmail($mail)) return "NOT_MAIL";
        if (!String::isPhone($phone)) return "NOT_PHONE";

        // Проверяем не зарегистрирован ли уже пользователь
        $u_phone=DB::getValue(Auth::getTable(), 'user_id', 'user_phone='.DB::quote(String::toPhone($phone)));
        $u_mail=DB::getValue(Auth::getTable(), 'user_id', 'user_mail='.DB::quote($mail));
        if (!empty($u_phone)) return "PHONE_EXIST";
        if (!empty($u_mail)) return "MAIL_EXIST";

        // Регистрируем
        $password = substr(md5(time()), 0, 5);
        DB::insert(Auth::getTable(), Array(
                'user_phone'=>DB::quote(String::toPhone($phone)),
                'user_password'=>DB::quote(md5($password)),
                'user_login'=>DB::quote($name),
                'user_mail'=>DB::quote($mail),
                'user_activate'=>1,
                'user_date_register'=>'NOW()',
                'user_ip_register'=>DB::quote(Router::getClientIp()),
                ), false);
        $text = 'Вы зарегистрировались на сайте foodfood.ru. Ваш пароль '.$password;
        Sms::sendSms(String::toPhone($phone), $text);
        self::login($mail, $password, false);
        return "OK";
    }

    /**
     * Авторизация
     * @return string
     */
    public static function login ($login,$password,$remember,$params=null) {
        if(trim($login)=='' || trim($password)=='') {
            return "SPACE";
        }
        if (String::isEmail($login) or String::toPhone($login)) {
            $auth = Array (
                    'login'=>$login,
                    'password'=>$password,
                    'remember'=>$remember,
                    'crypted'=>true
            );
            if (User::login($auth)) return "OK";
            else return "NOT_EXIST";
        }
        return "LOGIN";
    }

    /**
     * Изменить пароль
     * @return string
     */
    public static function passwd ($login,$params=null) {
        if(trim($login)=='') {
            return "SPACE";
        }
        $result = false;
        if (String::isEmail($login)) {
            // Меняем пароль
            $password = substr(md5(time()), 0, 5);
            $result = DB::update(
                    Auth::getTable(), Array('user_password'=>md5($password)), 'user_mail='.DB::quote($login)
            );
            $phone=DB::getValue(Auth::getTable(), 'user_phone', 'user_mail='.DB::quote($login));
        }
        elseif ($phone = String::toPhone($login)) {
            // Меняем пароль
            $password = substr(md5(time()), 0, 5);
            $result = DB::update(
                    Auth::getTable(), Array('user_password'=>md5($password)), 'user_phone='.DB::quote($phone)
            );
        }
        if ($result) {
            $text = 'Ваш новый пароль на сайте foodfood.ru: '.$password;
            Sms::sendSms(String::toPhone($phone), $text);
            return "OK";
        } else {
            return "LOGIN";
        }
    }


    /**
     * Функция учитывания приглашенных другими пользователями
     */

    public static function invite ($invite,$new_user_id) {
        $user_id = str_replace('pr', '', $invite);
        $new_user_id = intval($new_user_id);
        DB::insert('user_invite', '')
    }
}