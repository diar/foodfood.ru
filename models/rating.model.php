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
     * Обновить рейтинг ресторана
     * @return null
     */
    public static function updateRating($id) {
        self::calculateFillings();
        self::upd(Array('rest_rating' => 'rest_karma+rest_filling'), null, false);
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
     * Вычислить среднее значение звездочек у ресторана
     * @return null
     */
    public static function calculateRatingStars($rest_id) {
        $rest_ratings = self::getRecords(Model::getPrefix() . 'rest_rating',
                        'rest_id=' . DB::quote($rest_id) . ' AND (rating_cook!=0 OR rating_service!=0 OR rating_design!=0)'
        );
        if ($rest_ratings) {
            $rating_cook_value = 0;
            $rating_cook_count = 0;
            $rating_service_value = 0;
            $rating_service_count = 0;
            $rating_design_value = 0;
            $rating_design_count = 0;
            foreach ($rest_ratings as $vote) {
                if ($vote['rating_cook']!=0){
                    $rating_cook_value += $vote['rating_cook'];
                    $rating_cook_count++;
                }
                if ($vote['rating_service']!=0){
                    $rating_service_value += $vote['rating_service'];
                    $rating_service_count++;
                }
                if ($vote['rating_design']!=0){
                    $rating_design_value += $vote['rating_design'];
                    $rating_design_count++;
                }
            }
            $rating_cook = round ($rating_cook_value / $rating_cook_count,1);
            $rating_service = round ($rating_service_value / $rating_service_count,1);
            $rating_design = round ($rating_design_value / $rating_design_count,1);
            self::upd(array(
                'rest_rating_cook'=>$rating_cook,
                'rest_rating_service'=>$rating_service,
                'rest_rating_design'=>$rating_design
            ), 'id='.$rest_id);
        }
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
            if ($already && $already['rating_target'] != 0)
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
            $admin = DB::getRecord('admin_group_table', 'restaurant_id=' . DB::quote($rest_id), null,
                            Array('join' => 'admin_table', 'left' => 'id', 'right' => 'group_id'));

            if (!empty($admin['email'])) {
                $text = 'На странице вашего ресторана оставлен отзыв следующего содержания: ' .
                        '"' . $text . '"';
                $mail = Mail::newMail($text, $admin['email'], 'foodfood.ru');
                $mail->Send();
            }
        }
        return 'OK';
    }

    /**
     * Изменить рэйтинг ресторана по звездочкам
     * @return string
     */
    public static function changeRatingStar($rest_id, $rating_param, $rating_value) {
        if (!User::isAuth()) {
            return 'NO_LOGIN';
        }
        if (!in_array($rating_param, array('rating_cook', 'rating_service', 'rating_design'))) {
            return "error";
        }
        $vote = DB::getCount(
                Model::getPrefix ().'rest_rating',
                'rest_id='.DB::quote($rest_id).' AND user_id='.User::getParam('user_id')
        );
        if ($vote==0) {
            DB::insert(Model::getPrefix ().'rest_rating', array(
                $rating_param => $rating_value,
                'rest_id'=>$rest_id,
                'user_id'=>User::getParam('user_id')
            ));
        } else {
            DB::update(Model::getPrefix ().'rest_rating', array(
                $rating_param => $rating_value
            ),'rest_id='.DB::quote($rest_id).' AND user_id='.User::getParam('user_id'));
        }
        self::calculateRatingStars($rest_id);
        return "OK";
    }

    /**
     * Получить значение голосования пользователем
     * @return array
     */
    public static function getUserVote($rest_id) {
        $vote = DB::getRecord(
                Model::getPrefix ().'rest_rating',
                'rest_id='.DB::quote($rest_id).' AND user_id='.User::getParam('user_id')
        );
        return $vote;
    }
}