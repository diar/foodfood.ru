<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_User extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        self::setModelTable('user');
    }

    /**
     * Получить пользователей, пригласивших друзей
     * @return null
     */
    public static function getUsersByInvites($params=null) {
        empty($params['count']) ? $count = 20 : $count = $params['count'];
        $users = self::getAll('1=1 GROUP BY user.user_id ORDER BY count DESC', null, array(
                    'table' => 'user_invite', 'no_prefix' => true, 'limit' => '0,' . $count,
                    'join' => 'user', 'left' => 'user_id', 'right' => 'user_id',
                    'select' => 'user_login,user.user_id,COUNT(*) as count,user_profile_avatar'
                ));
        return $users;
    }

    /**
     * Получить количество сообщений у пользователя
     * @return int
     */
    public static function getMessageCount($params=null) {
        $user = User::getParams();
        if (!$user['is_auth'])
            return null;
        $comments = self::fetch(
                'SELECT SUM(comment_count_new) as count_new FROM blog_talk_user '.
                'WHERE user_id=' . self::quote($user['user_id']) . ' AND talk_user_active=1'
                );
        $talks = self::fetch(
                'SELECT COUNT(talk_id) as count_new FROM blog_talk_user '.
                'WHERE user_id=' . self::quote($user['user_id']) . ' AND talk_user_active=1 '.
                'AND date_last IS NULL'
                );
        return $comments['count_new'] + $talks['count_new'];
    }

    /**
     * Получить аватар пользователя
     * @param @user Id пользователя или массив с его параметрами
     * @return int
     */
    public static function getUserAvatar($user, $size=100) {
        if (is_int($user)) {
            $user = self::fetch('SELECT user_profile_avatar FROM user WHERE user_id='.DB::quote($user));
        }
        if ($size!=100 && is_int($size)) {
            $user['user_profile_avatar']=str_replace('100x100', $size.'x'.$size, $user['user_profile_avatar']);
        }
        return $user['user_profile_avatar'];
    }

}