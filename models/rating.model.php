<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления рейтингом ресторанов
 */
class MD_Rating extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('rest');
    }

    /**
     * Вычислить рейтинг ресторана
     * @return int
     */
    public static function calculate ($id) {
        $karma = self::value('rest_karma', 'id='.DB::quote($id));
        $filling = self::value('rest_filling', 'id='.DB::quote($id));
        // Формула получения рейтинга
        $rating = $karma + $filling;
        return $rating;
    }

    /**
     * Обновить рейтинг ресторана
     * @return null
     */
    public static function updateRating ($id) {
        $rating = self::calculate($id);
        self::upd(Array('rest_rating'=>$rating), 'id='.DB::quote($id));
    }

    /**
     * Вычислить наполненность контента у всех ресторанов
     * @return null
     */
    public static function calculateFillings () {
        // Обнуление показателей
        self::fetchAll('UPDATE kazan_rest SET rest_filling=0');
        // Подсчет наполненности фотографий
        self::fetchAll(
                'UPDATE kazan_rest SET rest_filling=rest_filling+10 WHERE id IN (
                    SELECT rest_id FROM (
                        SELECT rest_id, COUNT(*) AS count FROM kazan_rest_photo GROUP BY rest_id
                    ) as photo WHERE count>5
                )'
        );
        // Подсчет наполненности описания
        self::fetchAll(
                'UPDATE kazan_rest SET rest_filling=rest_filling+10
                    WHERE LENGTH(rest_description)>30'
        );
        // Подсчет наполненности информации
        self::fetchAll(
                'UPDATE kazan_rest SET rest_filling=rest_filling+10
                  WHERE TRIM(rest_address)!="" AND TRIM(rest_phone)!="" AND
                  TRIM(rest_phone)!="rest_google_code" AND rest_logo=1'
        );
    }

    /**
     * Обновить рейтинги всех ресторанов
     * @return null
     */
    public static function updateRatings () {
        self::calculateFillings();
        self::upd(Array('rest_rating'=>'rest_karma+rest_filling'),null,false);
    }

    /**
     * Уменьшить рейтинг ресторана
     * @return string
     */
    public static function minusRating ($id) {
        if (!User::isAuth()) {
            return 'NO_LOGIN';
        }
        $comm = DB::getRecord(
                Model::getPrefix ().'rest_comment',
                'rest_id='.DB::quote($id).' AND user_id='.User::getParam('user_id')
        );
        $text = !empty($_POST['text']) ? $_POST['text'] : '';
        if ($comm) return 'ALREADY';
        if (strlen($text)>1000) return 'LENGTH';
        if (AntimatPlugin::check($text) == '***') return 'MAT';
        DB::insert(Model::getPrefix ().'rest_comment', Array(
                'rest_id'=>$id,'user_id'=>User::getParam('user_id'),
                'text'=>$text
        ));
        if ($text!='') {
            DB::update(
                    Model::getPrefix ().'rest',
                    Array('rest_karma'=>'rest_karma-1','rest_comment_count'=>'rest_comment_count+1'),
                    'id='.DB::quote($id),false
            );
        } else {
            DB::update(
                    Model::getPrefix ().'rest',
                    Array('rest_karma'=>'rest_karma-1'),
                    'id='.DB::quote($id),false
            );
        }
        self::updateRating($id);
        return 'OK';
    }

    /**
     * Увеличить рейтинг ресторана
     * @return string
     */
    public static function plusRating ($id) {
        if (!User::isAuth()) {
            return 'NO_LOGIN';
        }
        $comm = DB::getRecord(
                Model::getPrefix ().'rest_comment',
                'rest_id='.DB::quote($id).' AND user_id='.User::getParam('user_id')
        );
        $text = !empty($_POST['text']) ? $_POST['text'] : '';
        if ($comm) return 'ALREADY';
        if (strlen($text)>1000) return 'LENGTH';
        if (AntimatPlugin::check($text) == '***') return 'MAT';
        DB::insert(Model::getPrefix ().'rest_comment', Array(
                'rest_id'=>$id,'user_id'=>User::getParam('user_id'),
                'text'=>$text
        ));
        if ($text!='') {
            DB::update(
                    Model::getPrefix ().'rest',
                    Array('rest_karma'=>'rest_karma+1','rest_comment_count'=>'rest_comment_count+1'),
                    'id='.DB::quote($id),false
            );
        } else {
            DB::update(
                    Model::getPrefix ().'rest',
                    Array('rest_karma'=>'rest_karma+1'),
                    'id='.DB::quote($id),false
            );
        }
        self::updateRating($id);
        return 'OK';
    }

    /**
     * Добавить комментарий ресторану
     * @return string
     */
    public static function addcomment ($id) {
        if (!User::isAuth()) {
            return 'NO_LOGIN';
        }
        $comm = DB::getRecord(
                Model::getPrefix ().'rest_comment',
                'rest_id='.DB::quote($id).' AND user_id='.User::getParam('user_id')
        );
        $text = !empty($_POST['text']) ? $_POST['text'] : '';
        if ($comm) return 'ALREADY';
        if (strlen($text)>1000) return 'LENGTH';
        if (AntimatPlugin::check($text) == '***') return 'MAT';
        DB::insert(Model::getPrefix ().'rest_comment', Array(
                'rest_id'=>$id,'user_id'=>User::getParam('user_id'),
                'text'=>$text
        ));
        DB::update(
                Model::getPrefix ().'rest',
                Array('rest_comment_count'=>'rest_comment_count+1'),
                'id='.DB::quote($id),false
        );
        return 'OK';
    }
}