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
        self::setModelTable('market_products');
        // self::setJoinTable(Array('join' => 'list_market_box', 'left' => 'id', 'right' => 'packing'));
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
                        ' AND in_market=1 AND rest_location_id=' . DB::quote($location), 'RAND()'
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

    /**
     * Получить список товаров
     * @param $parent_id если null, то все..
     * @param $param - доп параметр
     * @return array
     */
    public static function getProducts($parent_id = null, $param = null) {
        $where = '1=1';
        $parent_id = intval($parent_id);
        if ($parent_id > 0)
            $where .=" AND parent_id = '$parent_id'";
        if ($param == 'new')
            $where .=" AND type = 1";
        if ($param == 'sale')
            $where .=" AND discount > 0";
        $products = self::getAll($where, ' RAND()');

        foreach ($products as &$item) {
            if (mb_strlen($item['description'], 'UTF-8') > 50) {
                $item['description'] = mb_substr($item['description'], 0, 50, 'UTF-8') . '...';
            }

            $price = unserialize($item['size_price']);
            $item['price'] = $price[0]['price'];
            if ($item['discount'] > 0)
                $item['discount_price'] = $item['price'] - ($item['price'] * ($item['discount'] / 100));
        }
        return $products;
    }

    /**
     * Получить товар
     * @param $url
     * @param $id
     * @return array
     */
    public static function getProduct($url = null, $id = null) {
        $where = '1=1';
        if ($url)
            $where .=" AND url = '$url'";
        if ($id)
            $where .=" AND id = '$id'";

        $product = self::get($where);

        $product['size_price'] = $price = unserialize($product['size_price']);
        $product['price'] = $price[0]['price'];
        $product['packing'] = DB::getValue('list_market_box', 'title', 'id =' . $product['packing']);
        if ($product['discount'] > 0) {
            foreach ($product['size_price'] as &$item) {
                $item['old_price'] = $item['price'];
                $item['price'] = $item['price'] - ($item['price'] * ($product['discount'] / 100));
            }

            $product['discount_price'] = $product['price'] - ($product['price'] * ($product['discount'] / 100));
        }
        return $product;
    }

}