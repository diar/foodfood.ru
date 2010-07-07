<?php

require_once "adminModule.class.php";

class Admins extends AdminModule {

    protected static $_title = "Администраторы";
    protected static $_DB_table = 'admin_table';

    public static function initModule() {
        self::addAction('add', 'Добавить администратора', 7, true);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {

        $form = Form::newForm('Admins', 'adminsForm',self::getDbTable());

        $form->addfield(array(
            'name' => 'login',
            'caption' => 'Логин',
            'pattern' => 'text',
            'maxlength' => '32',
            'size' => '20',
            'help' => 'латинские символы',
            'css_class' => 'caption',
            'is_required' => true
        ));

        $form->addfield(array(
            'name' => 'password',
            'caption' => 'Пароль',
            'pattern' => 'text',
            'maxlength' => '30',
            'css_class' => 'caption',
            'is_required' => true
        ));

        $form->addfield(array(
            'name' => 'email',
            'caption' => 'E-Mail',
            'pattern' => 'email',
            'maxlength' => '32',
            'size' => '20',
            'css_class' => 'caption'
        ));

        $form->addfield(array('name' => 'phone',
            'caption' => 'Телефон',
            'pattern' => 'text',
            'maxlength' => '32',
            'size' => '20',
            'css_class' => 'caption'
        ));
        $form->addfield(array(
            'name' => 'city_id',
            'caption' => 'Город',
            'pattern' => 'select',
            'css_class' => 'caption',
            'multiple' => false,
            'size' => '1',
            'options' => array_merge(array(0 => "Все города"),
                    Form::array_combine(DB::fetchAll('SELECT id,city FROM `city_list`')))
        ));

        $form->addfield(array(
            'name' => 'group_id',
            'caption' => 'Группа',
            'pattern' => 'select',
            'css_class' => 'caption',
            'multiple' => false,
            'size' => '1',
            'options' => Form::array_combine(DB::fetchAll('SELECT id,title FROM `admin_group_table`'))
        ));

        $form->addfield(array(
            'name' => 'submit',
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
            $record = DB::getRecord(self::getDbTable(), "id =" . $id);
        }
        $form = Form::newForm('Admins', 'adminsForm',self::getDbTable());

        $form->addfield(array(
            'name' => 'email',
            'caption' => 'E-Mail',
            'pattern' => 'email',
            'maxlength' => '32',
            'size' => '20',
            'value' => $record['email'],
            'css_class' => 'caption'
        ));

        $form->addfield(array('name' => 'phone',
            'caption' => 'Телефон',
            'pattern' => 'text',
            'maxlength' => '32',
            'size' => '20',
            'value' => $record['phone'],
            'css_class' => 'caption'
        ));
        $form->addfield(array(
            'name' => 'city_id',
            'caption' => 'Город',
            'pattern' => 'select',
            'css_class' => 'caption',
            'selected' => $record['city_id'],
            'multiple' => false,
            'size' => '1',
            'options' => array_merge(array(0 => "Все города"),
                    Form::array_combine(DB::fetchAll('SELECT id,city FROM `city_list`')))
        ));

        $form->addfield(array(
            'name' => 'group_id',
            'caption' => 'Группа',
            'pattern' => 'select',
            'css_class' => 'caption',
            'multiple' => false,
            'selected' => $record['group_id'],
            'size' => '1',
            'options' => Form::array_combine(DB::fetchAll('SELECT id,title FROM `admin_group_table`'))
        ));

        $form->addfield(array('name' => 'edit',
            'caption' => 'Сохранить',
            'pattern' => 'submit')
        );

        self::validate($form, $id, true);
    }

    public static function save() {
        $data = $_POST;
        $data['password'] = AdminAuth::crypt($data['password']);
        DB::insert(self::getDbTable(), $data);
    }

    public static function saveEdit() {
        $id = ELEMENT_ID;
        $data = $_POST;
        DB::update(self::getDbTable(), $data, 'id =' . $id);
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DB::delete(self::getDbTable(), 'id =' . $id);
        header('Location: admin.php?page=admins', true, 303);
    }

    public static function showList() {
        $list = Form::showJqGrid(
                        array(
                            'url' => '/admin/admin.php?page=admins&action=showJSON',
                            'table' => 'gridlist', 'pager' => 'gridpager', 'width' => '800', 'height' => '240'
                        ),
                        array(
                            array('title' => 'id', 'width' => '50', 'align' => 'center'),
                            array('title' => 'Логин', 'width' => '300'),
                            array('title' => 'E-mail', 'width' => '300'),
                            array('title' => 'Действия', 'align' => 'center')
                        )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        //Получаем количество ресторанов
        $records = DB::fetch("SELECT COUNT(*) FROM admin_table");
        //Вычисляем кол-во страниц
        $count = $records['COUNT(*)'];
        $total_pages = ($count > 0) ? ceil($count / $limit) : 0;
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit;
        $records = DB::fetchAll(
                        "SELECT id,login,email FROM admin_table " .
                        'LIMIT ' . $start . ' , ' . $limit
        );
        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE, 'delete', $record['id']);
            $record['control'] = "<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }
        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

}