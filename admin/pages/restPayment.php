<?php
require_once "adminModule.class.php";

class restPayment extends AdminModule {
    // Титл для вывода в строке браузера и на странице
    protected static $_title = "Типы оплат";
    // Рекомендуется указывать с какой базой ведёшь работу..
    protected static $_DB_table = 'rest_payment';


    public static function initModule () {
        self::addAction('addItem', 'Добавить тип оплаты',7,true);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }


    public static function addItem() {
        $form = Form::newForm('restCategory', 'categoryForm', 'list_payment');

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
        if (!empty($_POST['item'])) {
            $id = str_replace('tag','',$_POST['item']);
            DBP::insert(self::getDbTable(), array('rest_id'=>self::getRestId(),'payment_id'=>$id));
        }
    }

    public static function save() {
        $data = $_POST;
        DB::insert('list_payment',$data);
    }

    public static function delete() {
        if (!empty($_POST['item'])) {
            $id = str_replace('tag','',$_POST['item']);
            DBP::delete(self::getDbTable(), 'rest_id='.self::getRestId().' AND payment_id='.DB::quote($id));
        }
    }

    public static function showList() {
        $tags = DB::fetchAll(
                'SELECT tg.title, tg.id FROM '.DBP::getPrefix().self::getDbTable().' AS rs '.
                'LEFT JOIN list_payment AS tg ON rs.payment_id=tg.id '.
                'WHERE rs.rest_id='.self::getRestId()
        );
        $gallery = DB::fetchAll("SELECT id,title FROM list_payment");
        if ($tags) {
            $cn = count($gallery);
            for ($i=0;$i<$cn;$i++) {
                if (in_array($gallery[$i], $tags)) unset($gallery[$i]);
            }
        }
        $tags = Array (
                'page' => 'restPayment',
                'tagsTitle' => 'Типы оплат ресторана',
                'galleryTitle' => 'Галерея типов оплат',
                'tags'=>$tags,
                'gallery'=>$gallery,
        );
        $list = View::getXSLT($tags, 'blocks/admin_rest_tag');
        self::showTemplate($list);
    }

}