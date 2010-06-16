<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления комментариями
 */
class MD_Comment extends Model {

    /** Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('rest_comment');
        self::setJoinTable(
                Array('join'=>'rest','left'=>'rest_id','right'=>'id')
        );
        self::enableCache();
    }

    /** Обновить количество ресторанов у настроения
     * @return array
     */
    public static function calculateCommentCount () {
        self::setJoinTable(null);
        $restaurants = self::getAll(null,null,Array('table'=>'rest'));
        foreach ($restaurants as $restaurant) {
            
        }
    }
}