<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с авторизацией
 */
class Auth {
    /**
     * Название таблицы пользователей
     * @var string
     */
    private static $_table;
    /**
     * Бэкенд авторизации
     * @var string
     */
    private static $_backend;

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule() {
        self::$_backend = (Config::getValue('user','backend'));
        self::$_table = (Config::getValue('user','table_'.self::$_backend));
    }

    /**
     * Получить название таблицы пользователей
     * @return string
     */
    public static function getTable () {
        return self::$_table;
    }

    /**
     * Проверка авторизации пользователя (livestreet)
     * @return bool
     */
    public static function auth_ls () {
        $user_id = Session::get('user_id');
        if ($user_id and $params=User::getById($user_id)) {
            $params['is_auth']=true;
        }
        elseif (!empty($_COOKIE['key'])) {
            $user = User::getUserBySessionKey_ls($_COOKIE['key']);
            if (!empty($user)) {
                $params = self::login_ls(
                        Array('login'=>$user['user_mail'],'password'=>$user['user_password'],'crypted'=>true)
                );
            }
            else {
                $params['is_auth'] = false;
            }
        } else {
            $params['is_auth'] = false;
        }
        return $params;
    }

    /**
     * Авторизация пользователя - все параметры внутри массива (livestreet)
     * @param string $params[login] Логин
     * @param string $params[password] Пароль
     * @param string $params[crypted] Если true, то строка уже зашифрована
     * @return bool
     */
    public static function login_ls ($params) {
        $login=$params['login'];
        $remember = !empty ($params['remember']) ? $params['remember'] : false;
        $crypted = !empty ($params['crypted']) ? $params['crypted'] : false;
        $password=$crypted ? DB::quote($params['password']) : DB::quote(self::crypt($params['password']));
        if (String::isEmail($login)) {
            $params=DB::getRecord(
                    self::$_table,'user_mail='.DB::quote($login).' AND user_password='.$password
            );
        } elseif ($phone = String::toPhone($login)) {
            $params=DB::getRecord(
                    self::$_table,'user_phone='.DB::quote($phone).' AND user_password='.$password
            );
        }
        if (!empty($params) and sizeof($params)>0) {
            // Генерим ключ авторизации
            $key=md5(time().$params['user_login']);
            $sesssion = User::getSessionByUserId_ls($params['user_id']);
            User::createSession_ls($sesssion,$key,$params['user_id']);
            // Записываем в куки
            if ($remember) {
                setcookie('key',$key,time()+3600*24*10,'/');
            }
            Session::set('user_id',$params['user_id']);
            unset($params['user_password']);
            $params['is_auth']=true;
            return $params;
        } else {
            $params['is_auth']=false;
            return $params;
        }
    }
    /**
     * Удаление авторизации пользователя (livestreet)
     * @return bool
     */
    public static function logout_ls () {
        setcookie('key',null,time()-3600,'/');
        Session::drop('user_id');
        return true;
    }
    /**
     * Шифрование строки
     * @param string $string Строка
     * @return string
     */
    public static function crypt ($string) {
        return md5($string);
    }
}