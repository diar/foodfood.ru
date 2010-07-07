<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_USer extends Model {

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
        $users = self::getAll('1=1 GROUP BY user.user_id ORDER BY count DESC', $order, array(
                    'table' => 'user_invite', 'no_prefix'=>true,'limit'=>'0,'.$count,
                    'join' => 'user', 'left' => 'user_id', 'right' => 'user_id',
                    'select'=>'user_login,user.user_id,COUNT(*) as count,user_profile_avatar'
                ));
        return $users;
    }

}