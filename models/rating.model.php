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
    public static function initModel() {
        self::setModelTable('rest');
    }

    /**
     * Вычислить рейтинг ресторана
     * @return int
     */
    public static function calculate($id) {
        $karma = self::value('rest_karma', 'id=' . DB::quote($id));
        $filling = self::value('rest_filling', 'id=' . DB::quote($id));
        // Формула получения рейтинга
        $rating = $karma + $filling;
        return $rating;
    }

    /**
     * Обновить рейтинг ресторана
     * @return null
     */
    public static function updateRating($id) {
        $rating = self::calculate($id);
        self::upd(Array('rest_rating' => $rating), 'id=' . DB::quote($id));
    }

    /**
     * Вычислить наполненность контента у всех ресторанов
     * @return null
     */
    public static function calculateFillings() {
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
    public static function updateRatings() {
        self::calculateFillings();
        self::upd(Array('rest_rating' => 'rest_karma+rest_filling'), null, false);
    }

    /**
     * Добавить комментарий ресторану
     * @return string
     */
    public static function addcomment($rest_id, $rating_target, $text, $to_admin=false) {
        $text = (!empty($_POST['text']) && $_POST['text'] != "Нет слов...") ? $_POST['text'] : '';
        if (!User::isAuth()) {
            return 'NO_LOGIN';
        }
        // Проверяем не голосовал ли пользователь в течение 5 минут
        if ($text != '') {
            $fmin = DB::getRecord(
                            Model::getPrefix () . 'rest_comment',
                            'rest_id=' . DB::quote($rest_id) . ' AND user_id=' . User::getParam('user_id') .
                            ' AND comment_date > NOW() - INTERVAL 5 MINUTE'
            );
            if ($fmin)
                return 'FMIN';
        }
        // Если нажал плюс или минус
        if (intval($rating_target) != 0) {
            // Узнаем, не голосовал ли пользователь
            $already = DB::getRecord(
                            Model::getPrefix () . 'rest_rating',
                            'rest_id=' . DB::quote($rest_id) . ' AND user_id=' . User::getParam('user_id')
            );
            if ($already)
                return 'ALREADY';
            DB::insert(Model::getPrefix () . 'rest_rating', Array(
                        'rest_id' => $rest_id, 'user_id' => User::getParam('user_id'),
                        'rating_target' => $rating_target
                    ));
            DB::update(
                            Model::getPrefix () . 'rest',
                            Array('rest_karma' => 'rest_karma+' . intval($rating_target)),
                            'id=' . DB::quote($rest_id), false
            );
            self::updateRating($rest_id);
        }
        if (strlen($text) > 2000)
            return 'LENGTH';
        if (AntimatPlugin::check($text) == '***')
            return 'MAT';
        if ($text == '')
            return 'OK';
        // Если добавил комментарий
        DB::update(
                        Model::getPrefix () . 'rest',
                        Array('rest_comment_count' => 'rest_comment_count+1'),
                        'id=' . DB::quote($rest_id), false
        );
        DB::insert(Model::getPrefix () . 'rest_comment', Array(
                    'rest_id' => DB::quote($rest_id),
                    'user_id' => DB::quote(User::getParam('user_id')),
                    'text' => DB::quote($text),
                    'comment_date' => 'NOW()'
                        ), false);
        if ($to_admin) {
            // Отправляем оповещение ресторатору
            $admin = DB::getRecord('admin_group_table', 'restaurant_id='.DB::quote($rest_id), null,
                            Array('join' => 'admin_table', 'left' => 'id', 'right' => 'group_id'));

            if (!empty($admin['email'])) {
                $text = 'На странице вашего ресторана оставлен отзыв следующего содержания: '.
                        '"'.$text.'"';
                $mail = Mail::newMail($text, $admin['email'], 'foodfood.ru');
                $mail->Send();
            }
        }
        return 'OK';
    }

}