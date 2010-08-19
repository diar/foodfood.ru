<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления знакомствами
 */
class MD_Dating extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        self::setModelTable('rest_dating');
        self::enableCache();
    }

    /**
     * Получить пользователей, которые оставили приглашения
     * @return array
     */
    public static function getUsers($rest_id,$params=null) {
        $users = self::getAll('rest_id='.DB::quote($rest_id), null, array(
                    'table' => Model::getPrefix().'rest_dating','no_prefix'=>true,
                    'join' => 'user', 'left' => 'user_id', 'right' => 'user_id',
                    'select' => 'user_profile_avatar,user_login,user.user_id'
                ));
        $followers = Array();
        foreach($users as $user) {
            $user['avatar'] = MD_User::getUserAvatar($user,48);
            array_push($followers, $user);
        }
        return $followers;
    }

    /**
     * Получить пользователя, который оставил приглашение
     * @return array
     */
    public static function getUser($rest_id,$user_id,$params=null) {
        $follower = self::get('rest_id='.DB::quote($rest_id).' AND user.user_id='.DB::quote($user_id), null, array(
                    'table' => Model::getPrefix().'rest_dating','no_prefix'=>true,
                    'join' => 'user', 'left' => 'user_id', 'right' => 'user_id',
                    'select' => 'user_profile_avatar,user_login,user.user_id,dating_topicality,'.
                                'dating_time,dating_target,dating_text'
                ));
        return $follower;
    }

    /*
     * Оставить приглашение
     */
    public static function invite($rest_id, $dating_topicality, $dating_time, $dating_target, $dating_text) {
       
        $user = User::getParams();
        if (!$user['is_auth'])
            return 'NO_LOGIN';
        $user_follow = self::get('user_id=' . $user['user_id'] . ' AND rest_id=' . DB::quote($rest_id));
        if (!empty($user_follow)) {
            return 'ALREADY';
        }
        self::add(array(
                    'user_id' => DB::quote($user['user_id']),
                    'rest_id' => DB::quote($rest_id),
                    'dating_topicality' => DB::quote($dating_topicality),
                    'dating_time' => DB::quote($dating_time),
                    'dating_target' => DB::quote($dating_target),
                    'dating_text' => DB::quote($dating_text),
                    'dating_limit' => 'NOW() + INTERVAL 3 MONTH'
                ),false);
        return 'OK';
    }

    /*
     * Принять приглашение приглашение
     */
    public static function follow($rest_id,$rest_title, $user_id) {
        $follower = User::getParams();
        if (!$follower['is_auth'])
            return 'NO_LOGIN';
        $inviter = self::get('rest_id='.DB::quote($rest_id).' AND user.user_id='.DB::quote($user_id), null, array(
                    'table' => Model::getPrefix().'rest_dating','no_prefix'=>true,
                    'join' => 'user', 'left' => 'user_id', 'right' => 'user_id',
                    'select' => 'user_phone'
                ));
        if (empty($inviter)) {
            return 'NO_INVITE';
        }
        $text = $follower['user_login'].' хочет с тобой сходить в ресторан "'.$rest_title.'", его номер '.
                $follower['user_phone'].', свяжись с ним, www.foodfood.ru';
        MD_Sms::sendSms($inviter['user_phone'], $text);
        return "OK";
    }

}