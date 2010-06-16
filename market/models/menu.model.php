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
    public static function initModel () {
        self::setModelTable('market_menu');
        self::setJoinTable(
                Array('join'=>'rest','left'=>'rest_id','right'=>'id')
        );
    }

    /**
     * Получить список типов меню
     * @return array
     */
    public static function getMenuTypes () {
        return DB::getRecords('list_market_menu_type');
    }

    /**
     * Получить список типов меню
     * @return array
     */
    public static function getMenuTags ($current_tags,$type=null) {
        $tags = DB::getRecords('list_market_menu_tag');
        foreach($tags as &$tag) {
            if (in_array($tag['uri'], $current_tags))
                $tag['current'] = 1;
        }
        return $tags;
    }

    /**
     * Получить список типов меню
     * @return array
     */
    public static function getDishByType ($type_id,$tags=null) {
        $dish = self::getAll('type_id='.self::quote($type_id).' AND in_market=1');
        $partners = Array();
        $dish_ids = Array ();
        foreach ($dish as $item) {
            $dish_ids[]=$item['market_menu_id'];
        }
        foreach ($dish as $item) {
            $item['price_old']=$item['price'] + 50;
            $partners[$item['rest_id']]['dish'][] = $item;
            $partners[$item['rest_id']]['title'] = $item['rest_title'];
        }
        return $partners;
    }
}