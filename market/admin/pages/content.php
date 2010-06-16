<?php
require_once "adminModule.class.php";

class content extends AdminModule {

    protected static $_title = "Страницы";
    protected static $_DB_table = 'content';

    public static function initModule () {
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::addAction('add', 'Добавить страницу',7,true);
        self::start();
    }

    public static function add() {
        $form = Form::newForm('content','restForm',self::getDbTable());

        $form->addfield(array('name' => 'content_title',
                'caption' => 'Название',
                'pattern' => 'text',
                'is_required' => true,
                'maxlength' => '255',
                'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'content_uri',
                'caption' => 'Uri страницы',
                'pattern' => 'text',
                'is_required' => true,
                'maxlength' => '255',
                'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'content_text',
                'caption' => 'Текст',
                'pattern' => 'editor')
        );

        $form->addfield(array('name' => 'submit',
                'caption' => 'Добавить',
                'css_class' => 'ui_button',
                'pattern' => 'submit')
        );

        self::validate($form);
    }

    public static function edit() {
        $id = ELEMENT_ID;
        if (!empty($_POST)) {
            $record = $_POST;
        } else {
            $record = DB::getRecord('content',"id =".$id);
        }

        $form = Form::newForm('content','posterForm',self::getDbTable());

        $form->addfield(array('name' => 'content_title',
                'caption' => 'Название',
                'pattern' => 'text',
                'value' => $record['content_title'],
                'is_required' => true,
                'maxlength' => '255',
                'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'content_uri',
                'caption' => 'Uri страницы',
                'pattern' => 'text',
                'value' => $record['content_uri'],
                'is_required' => true,
                'maxlength' => '255',
                'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'content_text',
                'caption' => 'Текст',
                'value' => $record['content_text'],
                'pattern' => 'editor')
        );

        $form->addfield(array('name' => 'edit',

                'caption' => 'Сохранить',
                'css_class' => 'ui_button',
                'pattern' => 'submit')
        );

        self::validate($form,$id,true);
    }

    public static function save() {
        $data = array();
        unset($_POST['submit']);
        $data = $_POST;
        DB::insert('content',$data);
    }

    public static function saveEdit() {
        $data = array();
        $id = ELEMENT_ID;
        unset($_POST['edit']);
        unset($_POST['id']);
        $data = $_POST;
        DB::update('content',$data,'id ='.$id);

    }

    public static function apply() {
        return true;
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DB::delete(self::getDbTable(),'id ='.$id);
        header('Location: admin.php?page=content', true, 303);
    }

    public static function showList() {
        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=content&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'600','height'=>'240'
                ),
                array(
                array('title'=>'id'),
                array('title'=>'uri'),
                array('title'=>'заголовок'),
                array('title'=>'Управление')
                )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        $records = DB::getRecords("content", null, null, Array('select'=>'id,content_uri,content_title'));

        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }

        echo Form::arrayToJqGrid($records, 1, 1, 1);
    }
}