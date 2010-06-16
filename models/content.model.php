<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Content extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('content');
        self::enableCache();
    }

    /**
     * Получить страницу
     * @param $uri Uri страницы
     * @param $params Параметры
     * @return array
     */
    public static function getContent ($uri,$params=null) {
        $content = self::get('content_uri='.self::quote($uri), null, array('no_prefix'=>true,'table'=>'content'));
        return $content;
    }
}