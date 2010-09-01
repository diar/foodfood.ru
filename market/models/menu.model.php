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
    public static function getDishByType($type_id, $tags=null) {
        $dish = self::getAll('type_id=' . self::quote($type_id) . ' AND in_market=1');
        $partners = Array();
        foreach ($dish as $item) {
            $portions = explode('%', $item['portion']);
            if (mb_strlen($item['description'], 'UTF-8')) {
                $item['description'] = mb_substr($item['description'], 0, 80, 'UTF-8') . '...';
            }
            $price = explode('%', $item['price']);
            $second_portions = !empty($item['second_portion']) ? explode('%', $item['second_portion']) : null;

            if (count($portions) > 0 && count($price) == count($portions)) {
                $z = 0;
                foreach ($portions as $portion) {
                    $f_protions['portion'] = $portion;
                    $f_protions['price'] = $price[$z];
                    if (isset($second_portions[$z]))
                        $f_protions['second_portion'] = $second_portions[$z];
                    $z++;
                    $item['portions'][] = $f_protions;
                }
            }
            $partners[$item['rest_id']]['dish'][] = $item;
            $partners[$item['rest_id']]['title'] = $item['rest_title'];
        }
        return $partners;
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