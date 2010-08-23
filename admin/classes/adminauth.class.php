<?php

class AdminAuth {

    /** Список доступных страниц и действий
     * @var array
     */
    private static $_access;
    protected static $_isAuth;
    protected static $_params;

    public static function initModule() {
        define('ADMIN_TABLE', 'admin_table');
        define('ADMIN_GROUP_TABLE', 'admin_group_table');
        define('ADMIN_GROUP_ACCESS_TABLE', 'admin_group_access_table');
    }

    public static function login($login, $password, $crypted=false) {
        $login = DB::quote($login);
        $password = $crypted ? DB::quote($password) : DB::quote(Auth::crypt($password));
        $city_id = intval($_POST['city']);
        $admin = DB::fetch('SELECT * FROM ' . ADMIN_TABLE .
                        ' WHERE login=' . $login . ' AND password=' . $password . ' LIMIT 0,1');

        if (!empty($admin) and sizeof($admin) > 0 and ($city_id == $admin['city_id'] OR $admin['city_id'] == 0)) {
            self::$_isAuth = true;
            self::$_params = $admin;
            $group = DB::getRecord(ADMIN_GROUP_TABLE, "id = $admin[group_id]");
            $_SESSION['admin']['id'] = $admin['id'];
            $_SESSION['admin']['login'] = $admin['login'];
            $_SESSION['admin']['group'] = $group['title'];
            $_SESSION['admin']['is_auth'] = true;
            $_SESSION['admin']['city_id'] = $admin['city_id'] == 0 ? $city_id : $admin['city_id'];
            $_SESSION['admin']['city_latin'] = DB::getValue('city_list', 'city_latin', "id = " . $_SESSION['admin']['city_id']);
            $_SESSION['admin']['restaurant_id'] = DB::getValue(ADMIN_GROUP_TABLE, 'restaurant_id', 'id = ' . $admin['group_id']);
            $_SESSION['admin']['restaurant'] = DBP::getRecord('rest', 'id=' . $_SESSION['admin']['restaurant_id']);
            $admin_access = self::getAdminAccessList($admin['group_id']);
            if (!empty($admin_access) and sizeof($admin_access) > 0) {
                self::$_access = $admin_access;
                $_SESSION['admin']['access'] = $admin_access;
            }
            if ($_SESSION['admin']['access'] == 'superadmin') {
                $_SESSION['admin']['restaurant_id'] = 1;
                $_SESSION['admin']['restaurant'] = DBP::getRecord('rest', 'id=1');
            }
            return true;
        } else
            return false;
    }

    public static function getAdminAccessList($group_id) {
        if (DB::getValue(ADMIN_GROUP_TABLE, 'title', "id = $group_id") == 'superadmin')
            return 'superadmin';

        $array = array();
//        $admin_access=DB::fetch('SELECT * FROM '.ADMIN_GROUP_ACCESS_TABLE.' WHERE group_id="'.$group_id.'"');
//
//        if (!empty($admin_access)) {
//
//            foreach ($admin_access as $var) {
//                array_push($array,array($var['allow_page'] => $var['level']));
//            }
//        }
        //временное ГЕНИАЛЬНОЕ решение

        $array = array(
            'restCategory' => 7,
            'restDiet' => 7,
            'restMusic' => 7,
            'restMood' => 7,
            'restPayment' => 7,
            'restPhotos' => 7,
            'restTags' => 7,
            'restCook' => 7,
            'restDocs' => 7,
            'restMenu' => 7,
            'restPoster' => 7,
            'reviews' => 7,
            'worktime' => 7,
            'main' => 7,
            'discounts' => 7,
            'discountLog' => 7,
            'marketSettings' => 7,
            'marketMenu' => 7,
            'marketOrders' => 7,
            'marketTags' => 7,
            'restaurants' => 3,
        );
        return $array;
    }

    public static function logout() {
        unset($_SESSION['admin']);
        self::$_isAuth = false;
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