<?php
require_once "adminModule.class.php";

class news extends AdminModule {

    protected static $_title = "Новости";

    protected static $_DB_table = 'news';

    public static function initModule () {
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {
        $form = Form::newForm('news','newsForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array(
                'name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'is_required' => true,
                'maxlength' => '100',
                'css_class' => 'caption'
        ));

        $form->addfield(array(
                'name' => 'text',
                'caption' => 'Описание',
                'pattern' => 'editor',
        ));

        $form->addfield(array('name' => 'submit',
                'caption' => 'Добавить',
                'css_class' => 'ui_button',
                'pattern' => 'submit'
        ));

        self::validate($form);
    }

    public static function edit() {
        $id = ELEMENT_ID;
        if (!empty($_POST)) {
            $record = $_POST;
        } else {
            $record = DBP::getRecord(self::getDbTable(),"id =".$id);
        }

        $form = Form::newForm('news','posterForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array(
                'name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'is_required' => true,
                'maxlength' => '100',
                'css_class' => 'caption',
                'value' => $record['title']
        ));

        $form->addfield(array(
                'name' => 'text',
                'caption' => 'Описание',
                'pattern' => 'editor',
                'value' => $record['text']
        ));

        $form->addfield(array(
                'name' => 'edit',
                'caption' => 'Сохранить',
                'css_class' => 'ui_button',
                'pattern' => 'submit'
        ));

        self::validate($form,$id,true);
    }

    public static function save() {
        $data = array();
        unset($_POST['submit']);
        $data = $_POST;
        DBP::insert(self::getDbTable(),$data);
    }

    public static function saveEdit() {
        $data = array();
        $id = ELEMENT_ID;
        unset($_POST['edit']);
        $data = $_POST;
        DBP::update(self::getDbTable(),$data,'id ='.$id);

    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(),'id ='.$id);
        header('Location: admin.php?page=news', true, 303);
    }

    public static function showList() {

        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=news&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'600','height'=>'240'
                ),
                array(
                array('title'=>'id'),
                array('title'=>'Название'),
                array('title'=>'Управление')
                )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        //Получаем количество афиш
        $records = DB::fetch(
                'SELECT COUNT(*) FROM '.DBP::getPrefix().self::getDbTable()
        );
        //Вычисляем кол-во страниц
        $count = $records['COUNT(*)'];
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        $records = DB::fetchAll(
                'SELECT id,title FROM '.DBP::getPrefix().self::getDbTable().
                ' LIMIT '.$start.' , '.$limit
        );

        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }

        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

}