<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Article extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('blog_topic');
        self::setJoinTable(
                Array('join'=>'blog_topic_content','left'=>'topic_id','right'=>'topic_id')
        );
        self::enableCache();
    }

    /** Получить статьи по блокам (для главной)
     * @return array
     */
    public static function getArticleBlocks ($params) {
        // Получаем список статей

        $topics = DB::getRecords(
                'blog_topic', 'blog_id=3', null,
                Array(
                    'join'=>'blog_topic_content','left'=>'topic_id','right'=>'topic_id',
                    'select'=>'topic_title,blog_topic.topic_id,topic_text_short,topic_count_comment,'.
                    'DAY(topic_date_add) AS topic_date_add_day,MONTH(topic_date_add) AS topic_date_add_month', 'order' => 'topic_date_add DESC'
                )
        );
        // Заворачиваем элементы статей в блоки
        $i = 0;
        if (!empty ($topics)) {
            foreach ($topics as $topic) {
                $article['title'] = $topic['topic_title'];
                $article['topic_id'] = $topic['topic_id'];
                $article['topic_date_day'] = $topic['topic_date_add_day'];
                $article['topic_date_month'] = String::toMonth($topic['topic_date_add_month']);
                preg_match('/^(.*?)[\.|\?|!]/is', $topic['topic_text_short'],$topic_text);
                $article['text'] = !empty($topic_text[1]) ? $topic_text[1].'...' : '...';
                $article['comment_count'] = String::toDeclension(
                        $topic['topic_count_comment'],'комментарий','комментария','комментариев'
                );
                $block[$i] = $article;
                $i++;
                if ($i==3 || count($topics)==$i) {
                    $i=0;
                    $article_blocks[]=$block;
                }
            }
            return $article_blocks;
        } else return false;
    }
}