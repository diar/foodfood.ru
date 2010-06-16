<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Banner extends Model {

    /** Инициализация модели
     * @return string
     */
    public static function initModel () {
        self::setModelTable('banners');
    }

    /** Получить случайную запись
     * @return string
     */
    public static function getRecordRand ($params) {
        $banner=self::get('vertical='.DB::quote($params['vertical']).' AND count>0','RAND()');
        self::upd(array('count'=>'count-1'),'id='.$banner['id'],false);
        $banner['city']=CityPlugin::getCity();
        return $banner;
    }
}