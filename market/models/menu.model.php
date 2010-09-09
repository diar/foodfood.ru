<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Menu extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        self::setModelTable('market_menu');
        self::setJoinTable(
                        Array('join' => 'rest', 'left' => 'rest_id', 'right' => 'id')
        );
    }

    /**
     * Получить список типов меню
     * @return array
     */
    public static function getMenuTypes() {
        return DB::getRecords('list_market_menu_type');
    }

    /**
     * Получить список типов меню
     * @return array
     */
    public static function getMenuTags($current_tags, $type=null) {
        $tags = DB::getRecords('list_market_menu_tag');
        foreach ($tags as &$tag) {
            if (in_array($tag['uri'], $current_tags))
                $tag['current'] = 1;
        }
        return $tags;
    }

    /**
     * Получить список типов меню
     * @return array
     */
    public static function getDishByType($type_id, $location) {
        $dish = self::getAll(
                'type_id=' . self::quote($type_id) . 
                ' AND in_market=1 AND rest_location_id='.DB::quote($location),'RAND()'
        );
        foreach ($dish as &$item) {
            if (mb_strlen($item['description'], 'UTF-8') > 50) {
                $item['description'] = mb_substr($item['description'], 0, 50, 'UTF-8') . '...';
            }
        }
        return $dish;
    }

    /**
     * Получить фотографии блюда
     * @param $params Параметры
     * @return array
     */
    public static function getDishPhotos($id, $params=null) {
        empty($params['count']) ? $count = 20 : $count = $params['count'];
        empty($params['offset']) ? $offset = 0 : $offset = $params['offset'];
        self::setJoinTable(null);
        $photos = self::getAll("dish_id = " . DB::quote($id), null, array('table' => 'market_photo'));
        return $photos;
    }

}