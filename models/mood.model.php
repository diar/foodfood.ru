<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Mood extends Model {

    /** Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('rest_mood');
        self::setJoinTable(
                Array('join'=>'rest','left'=>'rest_id','right'=>'id')
        );
        self::enableCache();
    }

    /** Получить список настроений
     * @return array
     */
    public static function getMoods () {
        self::setJoinTable(null);
        $moods = self::getAll(null,'`order` DESC',array('table'=>'list_mood','no_prefix'=>true));
        return $moods;
    }

    /** Получить список тэгов
     * @return array
     */
    public static function getTags () {
        self::setJoinTable(null);
        $tags = self::getAll(null,'`list_tag`.`order` ASC ',array('table'=>'list_tag','no_prefix'=>true));
        return $tags;
    }

    /** Обновить количество ресторанов у настроения
     * @return array
     */
    public static function calculateMoodCount () {
        self::setJoinTable(null);
        $moods = self::getAll(null,null,array('table'=>'list_mood','no_prefix'=>true));
        foreach ($moods as $mood) {
            $rest_count=count(
                    self::getAll(
                    'mood_id='.$mood['id'].' AND is_hidden=0',null,
                    Array('join'=>'rest','left'=>'rest_id','right'=>'id','select'=>'rest_id')
                    )
            );
            self::upd(Array('rest_count'=>$rest_count), 'id='.$mood['id'], null,
                    array('table'=>'list_mood','no_prefix'=>true)
            );
        }
    }
}