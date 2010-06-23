<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Poster extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('rest_poster');
        self::setJoinTable(
                Array('join'=>'rest','left'=>'rest_id','right'=>'id')
        );
        self::enableCache();
    }
    /**
     * Получить афишу
     * @return int
     */
    public static function getPoster($id) {
        $poster=self::get($id,null,array(
                'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'));
        if (!empty($poster)) {
            $poster['date_month'] = String::toMonth($poster['date_month']);
        }
        return $poster;
    }
    /**
     * Получить афиши ресторана
     * @return array
     */
    public static function getRestaurantPosters ($rest_id) {
        // Получаем список элементов афиши
        $posters = self::getAll('(date>=CURDATE() OR date_end>=CURDATE()) AND rest_id='.DB::quote($rest_id),'date DESC',array(
                'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
        ));
        if (!empty($posters)) foreach ($posters as &$poster) {
                $poster['date_month'] = String::toMonth($poster['date_month']);
            }
        return $posters;
    }
    /**
     * Получить афиши на сегодня
     * @return array
     */
    public static function getPostersToDate ($date,$params=null) {
        // Получаем список элементов афиши
        $date=self::quote($date);
        $posters = self::getAll(
                'is_hidden=0 AND poster_type = "poster" AND (date='.$date.' or '.
                '(date<='.$date.' and date_end>='.$date.') or (repeat_week=1 AND '.
                '(DAYOFWEEK(date)=DAYOFWEEK('.$date.') or '.
                '(DAYOFWEEK('.$date.')-1>=repeat_week_start and DAYOFWEEK('.$date.')-1<=repeat_week_end) or '.
                '(repeat_week_end+1<=repeat_week_start and NOT(DAYOFWEEK('.$date.')<=repeat_week_start and DAYOFWEEK('.$date.')-1>repeat_week_end)) OR '.
                '(repeat_week_end=repeat_week_start))))'
                ,'rest_rating DESC',array(
                'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
        ));
        $news = self::getAll(
                'is_hidden=0 AND poster_type = "news" AND (date='.$date.' or '.
                '(date<='.$date.' and date_end>='.$date.') or (repeat_week=1 AND '.
                '(DAYOFWEEK(date)=DAYOFWEEK('.$date.') or '.
                '(DAYOFWEEK('.$date.')-1>=repeat_week_start and DAYOFWEEK('.$date.')-1<=repeat_week_end) or '.
                '(repeat_week_end+1<=repeat_week_start and NOT(DAYOFWEEK('.$date.')<=repeat_week_start and DAYOFWEEK('.$date.')-1>repeat_week_end)) OR '.
                '(repeat_week_end=repeat_week_start))))'
                ,'rest_rating DESC',array(
                'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
        ));
        $actions = self::getAll(
                'is_hidden=0 AND poster_type = "action" AND (date='.$date.' or '.
                '(date<='.$date.' and date_end>='.$date.') or (repeat_week=1 AND '.
                '(DAYOFWEEK(date)=DAYOFWEEK('.$date.') or '.
                '(DAYOFWEEK('.$date.')-1>=repeat_week_start and DAYOFWEEK('.$date.')-1<=repeat_week_end) or '.
                '(repeat_week_end+1<=repeat_week_start and NOT(DAYOFWEEK('.$date.')<=repeat_week_start and DAYOFWEEK('.$date.')-1>repeat_week_end)) OR '.
                '(repeat_week_end=repeat_week_start))))'
                ,'rest_rating DESC',array(
                'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
        ));
        $poster_array['posters']['items'] = $posters;
        $poster_array['actions']['items'] = $actions;
        $poster_array['news']['items'] = $news;
        return $poster_array;
    }
    /**
     * Получить афиши на сегодня
     * @return array
     */
    public static function getPostersToday ($params=null) {
        // Получаем список элементов афиши
        $posters = self::getAll(
                'is_hidden=0 AND (date=CURDATE() or '.
                '(date<=CURDATE() and date_end>=CURDATE()) or (repeat_week=1 AND '.
                '(DAYOFWEEK(date)=DAYOFWEEK(CURDATE()) or '.
                '(DAYOFWEEK(CURDATE())-1>=repeat_week_start and DAYOFWEEK(CURDATE())-1<=repeat_week_end) or '.
                ')'
                ,'rest_rating DESC',array(
                'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
        ));
        if (!empty($posters)) foreach ($posters as &$poster) {
                $poster['date_month'] = String::toMonth($poster['date_month']);
                if (strlen($poster['anounce'])>60) {
                    $poster['anounce'] = mb_substr($poster['anounce'],0,60,'UTF-8').'...';
                }
            }
        return $posters;
    }

    /**
     * Получить афиши по блокам (для главной)
     * @return array
     */
    public static function getPosterBlocksWeek ($params) {
        $count = !empty($params['count']) ? $params['count'] : 20;
        // Получаем список элементов афиши
        $posters = self::getAll(
                'is_hidden=0 AND ('.
                '(date>=CURDATE() and date<=CURDATE()+INTERVAL 7 DAY) or '.
                '('.
                '(date>=CURDATE() or date_end>=CURDATE()) and '.
                '(date<=CURDATE()+INTERVAL 7 DAY or date_end<=CURDATE()+INTERVAL 7 DAY) '.
                ')'.
                ') GROUP BY rest_uri',
                'RAND(), rest_rating', array(
                'limit'=>'0,'.$count,
                'select'=>'rest_title,rest_id,rest_uri,title, anounce,img, '.
                        'DAY(date) AS date_day,MONTH(date) AS date_month'
                )
        );
        if (count($posters)<$count) {
            $posters_second = self::getAll(
                    'is_hidden=0 AND repeat_week=1 AND ('.
                    '(DAYOFWEEK(date)=DAYOFWEEK(CURDATE())) or '.
                    '(DAYOFWEEK(CURDATE())>repeat_week_start OR DAYOFWEEK(CURDATE())-1<=repeat_week_end)'.
                    ') GROUP BY rest_uri',
                    'RAND(), rest_rating DESC', array(
                    'limit'=>'0,'.$count,
                    'select'=>'rest_title,rest_id,rest_uri,title, anounce,img, '.
                            'DAY(date) AS date_day,MONTH(date) AS date_month'
                    )
            );
            if (count($posters_second)>0) {
                $posters_second=array_merge($posters, $posters_second);
                $posters = Array();
                if (!empty($posters_second)) foreach($posters_second as $poster) {
                        if (empty($posters[$poster['rest_poster_id']])) {
                            $posters[$poster['rest_poster_id']]=$poster;
                        }
                    }
            }
        }
        // Проверяем на уникальность афиш
        foreach ($posters as $key=>$poster) {
            foreach ($posters as $poster_second) {
                if ($poster['rest_poster_id']!=$poster_second['rest_poster_id']) {
                    similar_text($poster['anounce'], $poster_second['anounce'],$perc);
                    if ($perc>80) {
                        unset($posters[$key]);
                    }
                }
            }
        }
        // Заворачиваем элементы афиши в блоки
        $i = 0;
        if (!empty ($posters)) {
            foreach ($posters as $poster) {
                $poster['date_month'] = String::toMonth($poster['date_month']);
                if (strlen($poster['anounce'])>60) {
                    $poster['anounce'] = mb_substr($poster['anounce'],0,60,'UTF-8').'...';
                }
                $block[$i%3] = $poster;
                $i++;
                if ($i%3==0 || count($posters)==$i) {
                    $poster_blocks[]=$block;
                    $block=Array();
                }
            }
            return $poster_blocks;
        } else return null;
    }
    /**
     * Получить афиши по блокам (для главной)
     * @return array
     */
    public static function getPosterBlocksToday ($params) {
        $count = !empty($params['count']) ? $params['count'] : 20;
        // Получаем список элементов афиши
        $posters = self::getAll(
                'is_hidden=0 AND (date=CURDATE() or '.
                '(date<=CURDATE() and date_end>=CURDATE())'.
                ') GROUP BY rest_uri',
                'RAND(), rest_rating DESC', array(
                'limit'=>'0,'.$count,'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
                )
        );
        if (count($posters)<$count) {
            $posters_second = self::getAll(
                    'is_hidden=0 AND repeat_week=1 AND ('.
                    '(DAYOFWEEK(date)=DAYOFWEEK(CURDATE())) or '.
                    '(DAYOFWEEK(CURDATE())>repeat_week_start OR DAYOFWEEK(CURDATE())-1<=repeat_week_end)'.
                    ') GROUP BY rest_uri',
                    'RAND(), rest_rating DESC', array(
                    'limit'=>'0,'.$count,'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
                    )
            );
            if (count($posters_second)>0) {
                $posters_second=array_merge($posters, $posters_second);
                $posters = Array();
                foreach($posters_second as $poster) {
                    if (empty($posters[$poster['rest_poster_id']])) {
                        $posters[$poster['rest_poster_id']]=$poster;
                    }
                }
            }
        }

        // Заворачиваем элементы афиши в блоки
        $i = 0;
        if (!empty ($posters)) {
            foreach ($posters as $poster) {
                $poster['date_month'] = String::toMonth($poster['date_month']);
                if (strlen($poster['anounce'])>60) {
                    $poster['anounce'] = mb_substr($poster['anounce'],0,60,'UTF-8').'...';
                }
                $block[$i%3] = $poster;
                $i++;
                if ($i%3==0 || count($posters)==$i) {
                    $poster_blocks[]=$block;
                    $block=Array();
                }
            }
            return $poster_blocks;
        } else return null;
    }
    /**
     * Получить афиши по блокам (для главной)
     * @return array
     */
    public static function getPosterBlocksTomorrow ($params) {
        $date=self::quote(date('Y:m:d',time()+60*60*24));
        $count = !empty($params['count']) ? $params['count'] : 20;
        // Получаем список элементов афиши
        $posters = self::getAll(
                'is_hidden=0 AND (date='.$date.' or '.
                '(date<='.$date.' and date_end>='.$date.')'.
                ') GROUP BY rest_uri',
                'RAND(), rest_rating DESC', array(
                'limit'=>'0,'.$count,'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
                )
        );
        if (count($posters)<$count) {
            $posters_second = self::getAll(
                    'is_hidden=0 AND repeat_week=1 AND ('.
                    '(DAYOFWEEK(date)=DAYOFWEEK('.$date.')) or '.
                    '(DAYOFWEEK('.$date.')>repeat_week_start OR DAYOFWEEK('.$date.')-1<=repeat_week_end)'.
                    ') GROUP BY rest_uri',
                    'RAND(), rest_rating DESC', array(
                    'limit'=>'0,'.$count,'select'=>'*, DAY(date) AS date_day,MONTH(date) AS date_month'
                    )
            );
            if (count($posters_second)>0) {
                $posters_second=array_merge($posters, $posters_second);
                $posters = Array();
                foreach($posters_second as $poster) {
                    if (empty($posters[$poster['rest_poster_id']])) {
                        $posters[$poster['rest_poster_id']]=$poster;
                    }
                }
            }
        }
        // Заворачиваем элементы афиши в блоки
        $i = 0;
        if (!empty ($posters)) {
            foreach ($posters as $poster) {
                $poster['date_month'] = String::toMonth($poster['date_month']);
                if (strlen($poster['anounce'])>60) {
                    $poster['anounce'] = mb_substr($poster['anounce'],0,60,'UTF-8').'...';
                }
                $block[$i%3] = $poster;
                $i++;
                if ($i%3==0 || count($posters)==$i) {
                    $poster_blocks[]=$block;
                    $block=Array();
                }
            }
            return $poster_blocks;
        } else return null;
    }

    /**
     * "Я пойду!"
     * @return string
     */
    public static function follow ($id) {
        if (!User::isAuth()) {
            return 'NO_LOGIN';
        }
        $foll = DB::getRecord(
                Model::getPrefix ().'rest_poster_followers',
                'poster_id='.DB::quote($id).' AND user_id='.User::getParam('user_id')
        );
        if ($foll) return 'ALREADY';
        DB::insert(Model::getPrefix ().'rest_poster_followers', Array(
                'poster_id'=>$id,'user_id'=>User::getParam('user_id')
        ));
        return 'OK';
    }
}