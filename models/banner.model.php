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
    public static function initModel() {
        self::setModelTable('banners');
    }

    /** Получить случайную запись
     * @return string
     */
    public static function getRecordRand($params) {
        $banner = self::get('vertical=' . DB::quote($params['vertical']) . ' AND count>0', 'RAND()');
        self::upd(array('count' => 'count-1'), 'id=' . $banner['id'], false);
        $banner['city'] = CityPlugin::getCity();
        return $banner;
    }

    /** Получить баннер
     * @return string
     */
    public static function getRecord($target_type, $target_id) {
        if (!empty($target_id)) {
            $banner = self::get(
                            'position=' . DB::quote($target_type) .
                            ' target_id LIKE %|' . DB::quote($target_id) . '|% AND count>0',
                            'RAND()'
            );
        }
        if (empty($banner)) {
            $banner = self::get('position=' . DB::quote($target_type) . ' AND count>0', 'RAND()');
        }
        if (empty($banner)) {
            $banner = self::get('position="main_h" AND count>0', 'RAND()');
        }
        if (!empty($banner)) {
            self::upd(array('count' => 'count-1'), 'id=' . $banner['id'], false);
            switch ($banner['position']) {
                case 'rest_h' :
                case 'main_h' :
                    $banner['width'] = 770;
                    $banner['height']= 160;
                case 'rest_v' :
                case 'main_v' :
                    $banner['width'] = 240;
                    $banner['height']= 350;
            }
            $banner['city'] = CityPlugin::getCity();
            return $banner;
        } else {
            return null;
        }
    }

}