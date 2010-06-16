<?php
require_once "adminModule.class.php";

class restCook extends AdminModule {
    // Титл для вывода в строке браузера и на странице
    protected static $_title = "Типы оплат";
    // Рекомендуется указывать с какой базой ведёшь работу..
    protected static $_DB_table = 'rest_cook';

    public static function add() {
        if (!empty($_POST['item'])) {
            $id = str_replace('tag','',$_POST['item']);
            DBP::insert(self::getDbTable(), array('rest_id'=>self::getRestId(),'cook_id'=>$id));
        }
    }

    public static function delete() {
        if (!empty($_POST['item'])) {
            $id = str_replace('tag','',$_POST['item']);
            DBP::delete(self::getDbTable(), 'rest_id='.self::getRestId().' AND cook_id='.DB::quote($id));
        }
    }

    public static function showList() {
        $tags = DB::fetchAll(
                'SELECT tg.title, tg.id FROM '.DBP::getPrefix().self::getDbTable().' AS rs '.
                'LEFT JOIN list_cook AS tg ON rs.cook_id=tg.id '.
                'WHERE rs.rest_id='.self::getRestId()
        );
        $gallery = DB::fetchAll("SELECT id,title FROM list_cook");
        if ($tags) {
            $cn = count($gallery);
            for ($i=0;$i<$cn;$i++) {
                if (in_array($gallery[$i], $tags)) unset($gallery[$i]);
            }
        }
        $tags = Array (
                'page' => 'restCook',
                'tagsTitle' => 'Типы кухонь ресторана',
                'galleryTitle' => 'Галерея типов кухонь',
                'tags'=>$tags,
                'gallery'=>$gallery,
        );
        $list = View::getXSLT($tags, 'blocks/admin_rest_tag');
        self::showTemplate($list);
    }

}