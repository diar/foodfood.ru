<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением ресторанов
 */
class MD_Restaurant extends Model {
    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('rest');
    }
    /**
     * Получить рекомендованные рестораны и блюда
     * @param $params Параметры
     * @return array
     */
    public static function getRecomended ($params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $recomended=self::getAll('is_hidden=0','rest_rating DESC, rest_order DESC LIMIT '.$offset.','.$count);
        if (!empty($recomended)) {
            foreach ($recomended as &$item) {
                $item['rest_comment_count'] = String::toDeclension(
                        $item['rest_comment_count'],'отзыв','отзыва','отзывов'
                );
                if ($item['rest_rating']>0)
                    $item['rating_complete'] = intval($item['rest_rating']/143*100);
                else
                    $item['rating_complete'] = 0;
            }
        }
        return $recomended;
    }
    /**
     * Получить новый ресторан
     * @param $params Параметры
     * @return array
     */
    public static function getNew ($params=null) {
        $new=self::get('is_hidden=0','id DESC');
        return $new;
    }
    /**
     * Получить список id ресторанов по тэгам
     * @param $tags Список тэгов
     * @param $tags Список id
     * @param $params Параметры
     * @return array
     */
    public static function getRestListByTags ($tags,$rest,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        if (!empty($tags)) {
            $by_tag=self::getAll(
                    'rest_id IN ('.implode(',',$rest).')','rest_rating DESC',
                    Array('join'=>'rest_tag','left'=>'id','right'=>'rest_id','select'=>'tag_id,rest_id')
            );
            $rest = Array();
            if (!empty($by_tag)) {
                foreach ($by_tag as $tag) {
                    $rest_id = $tag['rest_id'];
                    if (empty($rest[$rest_id]))
                        $rest[$rest_id]=Array();
                    array_push($rest[$rest_id], $tag['tag_id']);
                }
            }
            $restaurants = Array();
            // Тупой код, но по другому пока не придумали
            foreach ($rest as $key=>$item) {
                $exist = true;
                foreach ($tags as $tag) {
                    if (!in_array($tag, $item))
                        $exist = false;
                }
                if ($exist) {
                    array_push($restaurants, $key);
                }
            }
            return $restaurants;
        } else {
            return $rest;
        }
    }
    /**
     * Получить список ресторанов по массиву id
     * @param $rest Массив id
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantsByIds ($rest,$params=null) {
        empty ($params['order']) ? $order='rest_rating DESC, rest_order DESC' : $order=$params['order'];
        if (!empty($rest)) {
            $restaurants=self::getAll('id IN ('.implode(',',$rest).')',$order,$params
            );
        } else {
            $restaurants = null;
        }
        return $restaurants;
    }
    /**
     * Получить все рестораны
     * @param $tags Список тэгов
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantsAll ($tags,$params=null) {
        // Получаем список всех ресторанов
        $all=self::getAll(
                'is_hidden=0','rest_rating DESC, rest_order DESC',Array('select'=>'id')
        );
        if (!empty($all)) {
            foreach ($all as &$item) {
                $item = $item['id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$all);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Получить ресторан по настроению
     * @param $tags Список тэгов
     * @param $mood Настроение
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantsByMood ($tags,$mood,$params=null) {
        $mood_id=DB::getValue('list_mood', 'id','uri='.DB::quote($mood));
        // Получаем список ресторанов по настроению
        $by_mood=self::getAll(
                'mood_id='.$mood_id.' AND is_hidden=0','rest_rating DESC, rest_order DESC',
                Array('join'=>'rest_mood','left'=>'id','right'=>'rest_id','select'=>'rest_id')
        );
        if (!empty($by_mood)) {
            foreach ($by_mood as &$mood) {
                $mood = $mood['rest_id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_mood);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Получить случайные рестораны
     * @param $tags Список тэгов
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantsByRand ($tags,$params=null) {
        $params['order']='RAND()';
        // Получаем список случайных ресторанов
        $by_rand=self::getAll(
                'is_hidden=0','RAND()',Array('select'=>'id')
        );
        if (!empty($by_rand)) {
            foreach ($by_rand as &$rand) {
                $rand = $rand['id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_rand);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Получить ресторан по букве
     * @param $tags Список тэгов
     * @param $char Буква
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantsByChar ($tags,$char,$params=null) {
        // Получаем список ресторанов по настроению
        $by_char=self::getAll(
                'is_hidden=0 AND `rest_title` LIKE  "'.DB::escape($char).'%"',
                'rest_rating DESC, rest_order DESC',Array('select'=>'id')
        );
        if (!empty($by_char)) {
            foreach ($by_char as &$char) {
                $char = $char['id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_char);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Поиск ресторанов по названию
     * @param $tags Список тэгов
     * @param $text Название
     * @param $params Параметры
     * @return array
     */
    public static function searchRestaurantByTitle ($tags,$text,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $text = strtolower($text);
        // -- Получаем список ресторанов по поиску (точное соответствие)
        $by_text=self::getAll(
                'is_hidden=0 AND `rest_title` LIKE  "%'.DB::escape($text).'%"',
                'rest_rating DESC, rest_order DESC',Array('select'=>'id')
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$item) {
                $item = $item['rest_id'];
            }
            // Получаем список ресторанов по тэгам
            $by_tag = self::getRestListByTags($tags,$by_text);
            // Получаем рестораны
            return self::getRestaurantsByIds($by_tag,$params);
        }
        // -- Пытаемся найти похожие записи
        // ----- Сначала преобразуем на русский язык
        $rus_text = str_replace(
                array(
                'ph','a','b','c','d','e','f','g','h',//34
                'i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','y','z'//51
                ), array (
                'ф','а','б','к','д','е','ф','ж','х','и','ж','к',//38
                    'л','м','н','о','п','к','р','с','т','у','в','в','й','з'
                ),$text
        );
        // ----- Получаем первую букву слова
        $char = mb_substr($rus_text,0,2);
        // ----- Ищем рестораны, начинающиеся с этой буквы
        $by_text=self::getAll(
                'is_hidden=0 AND `rest_title` LIKE  "'.DB::escape($char).'%"',
                'rest_rating DESC, rest_order DESC',Array('select'=>'rest_title')
        );
        $percent = 0;
        $new_text = '';
        if (!empty($by_text)) {
            foreach ($by_text as &$item) {
                similar_text($item['rest_title'], $rus_text,$perc);
                if ($perc>$percent) {
                    $percent=$perc;
                    $new_text = $item['rest_title'];
                }
            }
            if ($percent>70) {
                return 'Возможно вы имели ввиду '.
                        '<a href="#" onclick="$(\'#search_text\').val(\''.$new_text.
                        '\')" class="highlight">'.$new_text.'</a> ?';
            }
        }
        // -- Пытаемся найти по второму алфавиту
        // ----- Сначала преобразуем на русский язык
        $rus_text = str_replace(
                array(
                'ph','a','b','c','d','e','f','g','h',//34
                'i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','y','z'//51
                ), array (
                'ф','эй','б','с','д','и','ф','дж','х','ай','дж','к',//38
                    'л','м','н','о','п','кью','р','с','т','ю','в','у','я','з'
                ),$text
        );
        // ----- Получаем первую букву слова
        $char = mb_substr($rus_text,0,2);
        // ----- Ищем рестораны, начинающиеся с этой буквы
        $by_text=self::getAll(
                'is_hidden=0 AND `rest_title` LIKE  "'.DB::escape($char).'%"',
                'rest_rating DESC, rest_order DESC',Array('select'=>'rest_title')
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$item) {
                similar_text($item['rest_title'], $rus_text,$perc);
                if ($perc>$percent) {
                    $percent=$perc;
                    $new_text = $item['rest_title'];
                }
            }
            if ($percent>=50) {
                return 'Возможно вы имели ввиду '.
                        '<a href="#" onclick="$(\'#search_text\').val(\''.$new_text.
                        '\')" class="highlight">'.$new_text.'</a> ?';
            }
        }
        // -- Пытаемся найти по третьему алфавиту
        // ----- Сначала преобразуем на русский язык
        if (!preg_match('/^[a-z]*$/i', $text)) return null;
        $rus_text = str_replace(
                array(
                'q','w','e','r','t','y','u','i','o','p','[',']',
                    'a','s','d','f','g','h','j','k','l',';','\'',
                    'z','x','c','v','b','n','m',',','.'
                ), array (
                'й','ц','у','к','е','н','г','ш','щ','з','х','ъ',
                    'ф','ы','в','а','п','р','о','л','д','ж','э',
                    'я','ч','с','м','и','т','ь','б','ю'
                ),$text
        );
        // ----- Получаем первую букву слова
        $char = mb_substr($rus_text,0,2);
        // ----- Ищем рестораны, начинающиеся с этой буквы
        $by_text=self::getAll(
                'is_hidden=0 AND `rest_title` LIKE  "'.DB::escape($char).'%"',
                'rest_rating DESC, rest_order DESC',Array('select'=>'rest_title')
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$item) {
                similar_text($item['rest_title'], $rus_text,$perc);
                if ($perc>$percent) {
                    $percent=$perc;
                    $new_text = $item['rest_title'];
                }
            }
            if ($percent>40) {
                return 'Возможно вы имели ввиду '.
                        '<a href="#" onclick="$(\'#search_text\').val(\''.$new_text.
                        '\')" class="highlight">'.$new_text.'</a> ?';
            } else {
                return null;
            }
        }
    }
    /**
     * Поиск ресторанов по кухне
     * @param $tags Список тэгов
     * @param $tags Текст
     * @param $params Параметры
     * @return array
     */
    public static function searchRestaurantByCook ($tags,$text,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        // Получаем список ресторанов по поиску
        $by_text=self::fetchAll(
                'SELECT rest_id FROM `'.self::getPrefix().'rest_cook` AS rc '.
                'LEFT JOIN `'.self::getPrefix().'rest` AS rs ON rc.rest_id=rs.id '.
                'LEFT JOIN `list_cook` AS ck ON rc.cook_id=ck.id '.
                'WHERE is_hidden=0 AND `title` LIKE "%'.DB::escape($text).
                '%" GROUP BY rest_id ORDER BY rest_rating DESC, rest_order DESC'
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$text) {
                $text = $text['rest_id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_text);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Поиск ресторанов по типу заведения
     * @param $tags Список тэгов
     * @param $tags Текст
     * @param $params Параметры
     * @return array
     */
    public static function searchRestaurantByCategory ($tags,$text,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        // Получаем список ресторанов по поиску
        $by_text=self::fetchAll(
                'SELECT rest_id FROM `'.self::getPrefix().'rest_category` AS rc '.
                'LEFT JOIN `'.self::getPrefix().'rest` AS rs ON rc.rest_id=rs.id '.
                'LEFT JOIN `list_category` AS ck ON rc.category_id=ck.id '.
                'WHERE is_hidden=0 AND `title` LIKE "%'.DB::escape($text).
                '%" GROUP BY rest_id ORDER BY rest_rating DESC, rest_order DESC'
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$text) {
                $text = $text['rest_id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_text);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Поиск ресторанов по типу заведения
     * @param $tags Список тэгов
     * @param $tags Текст
     * @param $params Параметры
     * @return array
     */
    public static function searchRestaurantByMusic ($tags,$text,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        // Получаем список ресторанов по поиску
        $by_text=self::fetchAll(
                'SELECT rest_id FROM `'.self::getPrefix().'rest_music` AS rc '.
                'LEFT JOIN `'.self::getPrefix().'rest` AS rs ON rc.rest_id=rs.id '.
                'LEFT JOIN `list_music` AS ck ON rc.music_id=ck.id '.
                'WHERE is_hidden=0 AND `title` LIKE "%'.DB::escape($text).
                '%" GROUP BY rest_id ORDER BY rest_rating DESC, rest_order DESC'
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$text) {
                $text = $text['rest_id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_text);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Поиск ресторанов по меню
     * @param $tags Список тэгов
     * @param $tags Текст
     * @param $params Параметры
     * @return array
     */
    public static function searchRestaurantByMenu ($tags,$text,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        // Получаем список ресторанов по поиску
        $by_text=self::fetchAll(
                'SELECT rest_id FROM `'.self::getPrefix().'rest_menu` AS rc '.
                'LEFT JOIN `'.self::getPrefix().'rest` AS rs ON rc.rest_id=rs.id '.
                'LEFT JOIN `list_menu_type` AS tp ON rc.type_id=tp.id '.
                'WHERE is_hidden=0 AND tp.title LIKE "%'.DB::escape($text).
                '%" GROUP BY rest_id ORDER BY rest_rating DESC, rest_order DESC'
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$text) {
                $text = $text['rest_id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_text);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Поиск ресторанов по адресу
     * @param $tags Список тэгов
     * @param $tags Текст
     * @param $params Параметры
     * @return array
     */
    public static function searchRestaurantByAddress ($tags,$text,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        // Получаем список ресторанов по поиску
        $by_text=self::getAll(
                'is_hidden=0 AND `rest_address` LIKE  "%'.DB::escape($text).'%"',
                'rest_rating DESC',Array('select'=>'id')
        );
        if (!empty($by_text)) {
            foreach ($by_text as &$text) {
                $text = $text['rest_id'];
            }
        }
        // Получаем список ресторанов по тэгам
        $by_tag = self::getRestListByTags($tags,$by_text);
        // Получаем рестораны
        return self::getRestaurantsByIds($by_tag,$params);
    }
    /**
     * Получить следующий ресторан ресторан по настроению
     * @param $mood Настроение
     * @param $offset Смещение
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantNext ($mood,$offset,$params=null) {
        // поиск по алфавиту
        if (strlen(urldecode($mood))<3) {
            $next=self::get(
                    'is_hidden=0 AND `rest_title` LIKE  "'.DB::escape($mood).'%"',
                    'rest_rating DESC',Array('limit'=>$offset.',1')
            );
        }
        // поиск по рейтингу
        elseif ($mood=='rating') {
            $next=self::get(
                    'is_hidden=0','rest_rating DESC, rest_order DESC',Array('limit'=>$offset.',1')
            );
        }
        // поиск по настроению
        else {
            $mood_id=DB::getValue('list_mood', 'id','uri='.DB::quote($mood));
            $next=self::get('mood_id='.$mood_id.' AND is_hidden=0',null,
                    Array('limit'=>$offset.',1','join'=>'rest_mood','left'=>'id','right'=>'rest_id')
            );
        }
        return $next;
    }
    /**
     * Получить предыдущий ресторан ресторан по настроению
     * @param $mood Настроение
     * @param $offset Смещение
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantPrev ($mood,$offset) {
        if ($offset<2) return false;
        $offset=$offset-2;
        // поиск по алфавиту
        if (strlen(urldecode($mood))<3) {
            $prev=self::get(
                    'is_hidden=0 AND `rest_title` LIKE  "'.DB::escape($mood).'%"',
                    'rest_rating DESC',Array('limit'=>$offset.',1')
            );
        }
        // поиск по рейтингу
        elseif ($mood=='rating') {
            $prev=self::get(
                    'is_hidden=0','rest_rating DESC, rest_order DESC',Array('limit'=>$offset.',1')
            );
        }
        // поиск по настроению
        else {
            $mood_id=DB::getValue('list_mood', 'id','uri='.DB::quote($mood));
            $prev=self::get('mood_id='.$mood_id.' AND is_hidden=0',null,
                    Array('limit'=>$offset.',1','join'=>'rest_mood','left'=>'id','right'=>'rest_id')
            );
        }
        return $prev;
    }
    /**
     * Получить ресторан по uri
     * @param $uri URI ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getByUri ($uri,$params=null) {
        $restaurant=self::get('rest_uri='.DB::quote($uri));
        return $restaurant;
    }
    /**
     * Получить ресторан по uri
     * @param $uri URI ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getById ($id,$params=null) {
        $restaurant=self::get('id='.DB::quote($id));
        return $restaurant;
    }
    /**
     * Получить id ресторана по uri
     * @param $uri URI ресторана
     * @param $params Параметры
     * @return int
     */
    public static function getRestaurantId ($uri,$params=null) {
        $restaurant=self::value('id','rest_uri='.DB::quote($uri));
        return $restaurant;
    }
    /**
     * Получить фотографии ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantPhotos ($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $photos = self::getAll("rest_id = ".DB::quote($id),'`order`',array('table'=>'rest_photo'));
        return $photos;
    }
    /**
     * Получить категории ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantCategories ($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $categories = self::getAll("rest_id = ".DB::quote($id),null,array(
                'table'=>Model::getPrefix().'rest_category','select'=>'title',
                'join'=>'list_category','left'=>'category_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($categories as &$category) {
            $category = $category['title'];
        }
        return implode(', ',$categories);
    }
    /**
     * Получить тэги ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantTags ($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $tags = self::getAll("rest_id = ".DB::quote($id),null,array(
                'table'=>Model::getPrefix().'rest_tag',
                'join'=>'list_tag','left'=>'tag_id','right'=>'id','no_prefix'=>true
        ));
        return $tags;
    }
    /**
     * Получить кухни ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantCooks($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $cooks = self::getAll("rest_id = ".DB::quote($id),null,array(
                'table'=>Model::getPrefix().'rest_cook','select'=>'title',
                'join'=>'list_cook','left'=>'cook_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($cooks as &$cook) {
            $cook = $cook['title'];
        }
        return implode(', ',$cooks);
    }
    /**
     * Получить меню ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantDiets($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $diets = self::getAll("rest_id = ".DB::quote($id),null,array(
                'table'=>Model::getPrefix().'rest_diet','select'=>'title',
                'join'=>'list_diet','left'=>'diet_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($diets as &$diet) {
            $diet = $diet['title'];
        }
        return implode(', ',$diets);
    }
    /**
     * Получить музыку ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantMusics($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $musics = self::getAll("rest_id = ".DB::quote($id),null,array(
                'table'=>Model::getPrefix().'rest_music','select'=>'title',
                'join'=>'list_music','left'=>'music_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($musics as &$music) {
            $music = $music['title'];
        }
        return implode(', ',$musics);
    }
    /**
     * Получить типы оплат ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantPayments($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $payments = self::getAll("rest_id = ".DB::quote($id),null,array(
                'table'=>Model::getPrefix().'rest_payment','select'=>'title',
                'join'=>'list_payment','left'=>'payment_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($payments as &$payment) {
            $payment = $payment['title'];
        }
        return implode(', ',$payments);
    }
    /**
     * Получить меню ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantMenu($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $menu = self::getAll('is_bar_map=0 AND rest_id='.$id, null, Array(
                'table'=>Model::getPrefix().'rest_menu',
                'select'=>'*,'.Model::getPrefix().'rest_menu.title AS menu_title',
                'join'=>'list_menu_type','left'=>'type_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($menu as &$item) {
            $item['dish_id']=$item[Model::getPrefix().'rest_menu_id'];
            $rest_menu[$item['type_id']]['dish'][]=$item;
            $rest_menu[$item['type_id']]['title']=$item['title'];
        }
        return !empty($rest_menu) ? $rest_menu : null;
    }
    /**
     * Получить карту бара ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantMenuMap($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $menu = self::getAll('is_bar_map=1 AND rest_id='.$id, null, Array(
                'table'=>Model::getPrefix().'rest_menu',
                'select'=>'*,'.Model::getPrefix().'rest_menu.title AS menu_title',
                'join'=>'list_menu_type','left'=>'type_id','right'=>'id','no_prefix'=>true
        ));
        foreach ($menu as &$item) {
            $item['dish_id']=$item[Model::getPrefix().'rest_menu_id'];
            $rest_menu[$item['type_id']]['dish'][]=$item;
            $rest_menu[$item['type_id']]['title']=$item['title'];
        }
        return !empty($rest_menu) ? $rest_menu : null;
    }
    /**
     * Получить время работы ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantWorktime($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $w = date('w');
        if (intval($w)==0) $w=7;
        $worktime = self::get('day_start<='.$w.' AND day_end>='.$w.' AND rest_id='.$id, null, Array(
                'table'=>'rest_worktime',
        ));
        if (!empty($worktime)) {
            $time_start_arr=explode(':', $worktime['time_start']);
            $time_start=intval($time_start_arr[0])*60+intval($time_start_arr[1]);
            $time_end_arr=explode(':', $worktime['time_end']);
            $time_end=intval($time_end_arr[0])*60+intval($time_end_arr[1]);
            $time_current=intval(date('H'))*60+intval(date('i'));
            if(($time_current>$time_start and $time_current<$time_end) or
                    ($time_start>$time_end and !($time_current<$time_start and $time_current>$time_end)) or
                    ($time_start==$time_end)
            ) {
                $worktime['opened']=true;
            }
            else {
                $worktime['opened']=false;
            }
        }
        return !empty($worktime) ? $worktime : null;
    }
    /**
     * Получить отзывы ресторана
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantReviews ($id,$params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $reviews = self::getAll(
                'text!=\'\' AND rest_id='.$id,Model::getPrefix().'rest_comment.id DESC LIMIT 0,'.$count,
                array(
                'table'=>Model::getPrefix().'rest_comment', 'no_prefix'=>true,
                'join'=>Array('user',Model::getPrefix().'rest'),
                'left'=>Array('user_id','rest_id'),
                'right'=>Array('user_id','id'),
                'select'=>'rest_uri,rest_title,rest_id,text,user_login'
                )
        );
        return $reviews;
    }
    /**
     * Получить отзывы ресторанов
     * @param $params Параметры
     * @return array
     */
    public static function getRestaurantsReviews ($params=null) {
        empty ($params['count']) ? $count=20 : $count=$params['count'];
        empty ($params['offset']) ? $offset=0 : $offset=$params['offset'];
        $reviews = self::getAll(
                'text!=\'\'',Model::getPrefix().'rest_comment.id DESC LIMIT 0,'.$count,
                array(
                'table'=>Model::getPrefix().'rest_comment', 'no_prefix'=>true,
                'select'=>'rest_title,user_login,text,rest_id,rest_uri',
                'join'=>Array('user',Model::getPrefix().'rest'),
                'left'=>Array('user_id','rest_id'),
                'right'=>Array('user_id','id')
                )
        );
        return $reviews;
    }

    public static function haveMenu ($rest_id) {
        $return = DB::getCount(self::getPrefix().'rest_menu','is_bar_map=0 AND rest_id ='.$rest_id);
        if  (intval($return) > 0) return true;
        else return false;
    }
    public static function haveMenuMap ($rest_id) {
        $return = DB::getCount(self::getPrefix().'rest_menu','is_bar_map=1 AND rest_id ='.$rest_id);
        if  (intval($return) > 0) return true;
        else return false;
    }
}