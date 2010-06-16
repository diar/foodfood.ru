<?php
require_once "adminModule.class.php";

class marketTags extends AdminModule {
    // Титл для вывода в строке браузера и на странице
    protected static $_title = "Тэги блюда";
    // Рекомендуется указывать с какой базой ведёшь работу..
    protected static $_DB_table = 'market_tag';

    public static function initModule () {

        self::addAction('addItem', 'Добавить тэг',7,true);

        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }


    public static function addItem() {
        $form = Form::newForm('marketTag', 'categoryForm', ' list_market_menu_tag');

        $form->addfield(array('name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'maxlength' => '32',
                'size' => '20',
                'help' => 'любые символы',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'submit',
                'caption' => 'Добавить',
                'pattern' => 'submit')
        );

        self::validate($form);
    }

    public static function add() {
        $dish_id = ELEMENT_ID;
        if (!empty($_POST['item'])) {
            $id = str_replace('tag','',$_POST['item']);
            DBP::insert(self::getDbTable(), array('dish_id'=>$dish_id,'tag_id'=>$id));
        }
    }

    public static function save() {
        $data = array();
        unset($_POST['submit']);
        $data = $_POST;
        DB::insert('list_market_menu_tag',$data);
    }

    public static function delete() {
        $dish_id = ELEMENT_ID;
        if (!empty($_POST['item'])) {
            $id = str_replace('tag','',$_POST['item']);
            DBP::delete(self::getDbTable(), 'dish_id='.$dish_id.' AND tag_id='.DB::quote($id));
        }
    }

    public static function showList() {
        $id = ELEMENT_ID;
        $tags = DB::fetchAll(
                'SELECT tg.title, tg.id FROM '.DBP::getPrefix().self::getDbTable().' AS mt '.
                'LEFT JOIN list_market_menu_tag AS tg ON mt.tag_id=tg.id '.
                'WHERE mt.dish_id='.$id
        );
        $gallery = DB::getRecords('list_market_menu_tag');
        if ($tags) {
            $cn = count($gallery);
            for ($i=0;$i<$cn;$i++) {
                if (in_array($gallery[$i], $tags)) {
                    unset($gallery[$i]);
                }
            }
        }
        $tags = Array (
                'page' => 'marketTags',
                'tagsTitle' => 'Тэги блюда',
                'galleryTitle' => 'Галерея тэгов',
                'dish_id'=>$id,
                'tags'=>$tags,
                'gallery'=>$gallery,
        );
        $list = View::getXSLT($tags, 'blocks/admin_market_tag');
        self::showTemplate($list);
    }

}