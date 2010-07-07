<?php
require_once "adminModule.class.php";

class Mood extends AdminModule {
    // Титл для вывода в строке браузера и на странице
    protected static $_title = "Настроения";
    // Рекомендуется указывать с какой базой ведёшь работу..
    protected static $_DB_table = 'list_mood';

    public static function add() {

        $form = Form::newForm('mood','moodForm','list_mood');

        $form->addfield(array('name' => 'title',
                'caption' => 'Название',
                'is_unique' => true,
                'pattern' => 'text',
                'maxlength' => '100',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'src',
                'caption' => 'Картинка',
                'pattern' => 'file',
                'maxlength' => '100',
                'formats' => array('jpg','gif','png','jpeg'),
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'submit',
                'caption' => 'Сохранить',
                'pattern' => 'submit')
        );

        self::validate($form);
    }

    public static function save() {
        $data = $_POST;
        $data['src'] = File::saveFile('src','php.jpg','../upload/file');
        DB::insert(self::getDbTable(),$data);

    }

    public static function showList() {
        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=mood&action=showJSON',
                'table'=>'moodlist','pager'=>'moodpager','width'=>'600','height'=>'240'
                ),
                array(
                array('title'=>'id','name'=>'id', 'index'=>'id'),
                array('title'=>'Название','name'=>'id', 'index'=>'id'),
                array('title'=>'Картинка','name'=>'id', 'index'=>'id')
                )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        $records = DB::getRecords(self::getDbTable());
        echo Form::arrayToJqGrid($records, 1, 1, 1);
    }

}