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
                'blog_topic', 'blog_id=3', 'topic_date_add DESC',
                Array(
                    'join'=>'blog_topic_content','left'=>'topic_id','right'=>'topic_id',
                    'select'=>'topic_title,blog_topic.topic_id,topic_text_short,topic_count_comment,'.
                    'DAY(topic_date_add) AS topic_date_add_day,MONTH(topic_date_add) AS topic_date_add_month'
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
                $topic_text = preg_replace('/<[^>]*>/i','',$topic['topic_text_short']);
                preg_match('/^(.*?)[\.|\?|!]/is', $topic_text,$topic_text);
                $article['text'] = !empty($topic_text[1]) ? $topic_text[1].'...' : '...';
                $article['comment_count'] = String::toDeclension(
                        $topic['topic_count_comment'],'комментарий','комментария','комментариев'
                );
                $block[$i%3] = $article;
                $i++;
                if ($i%3==0 || count($topics)==$i) {
                    $article_blocks[]=$block;
                    $block=array();
                }
            }
            return $article_blocks;
        } else return false;
    }

    /** Получить блоги по блокам (для главной)
     * @return array
     */
    public static function getBlogBlocks ($params) {
        // Получаем список статей
        $blogs = DB::getRecords(
                'blog_blog', 'blog_type="open"', 'blog_rating DESC'
        );
        // Заворачиваем элементы статей в блоки
        $i = 0;
        if (!empty ($blogs)) {
            foreach ($blogs as $blog) {
                $blog['title'] = $blog['blog_title'];
                $blog['blog_id'] = $blog['blog_id'];
                $blog_text = preg_replace('/<[^>]*>/i','',$blog['blog_description']);
                preg_match('/^(.*?)[\.|\?|!]/is', $blog_text,$blog_text_r);
                if (!empty($blog_text_r[1])) {
                    $blog['text'] = $blog_text_r[1].'...';
                } else {
                    $blog['text'] = strlen($blog_text)<200 ? $blog_text : '...';
                }
                $block[$i%3] = $blog;
                $i++;
                if ($i%3==0 || count($blogs)==$i) {
                    $blog_blocks[]=$block;
                    $block=array();
                }
            }
            return $blog_blocks;
        } else return false;
    }
}