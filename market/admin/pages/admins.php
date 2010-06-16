<?php
require_once "adminModule.class.php";

class Admins extends AdminModule {

    public static function add() {

        $form = Form::newForm('Admins','adminsForm');

        $form->addfield(array('name' => 'login',
                'caption' => 'Логин',
                'pattern' => 'text',
                'maxlength' => '32',
                'size' => '20',
                'help' => 'латинские символы',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'password',
                'name2' => 'confirm',
                'caption1' => 'Пароль',
                'caption2' => 'Еще раз',
                'pattern' => 'confirm',
                'maxlength' => '30',
                'type' => 'password',
                'css_class' => 'caption',
                'is_required' => true)
        );

        $form->addfield(array('name' => 'email',
                'caption' => 'E-Mail',
                'pattern' => 'email',
                'maxlength' => '32',
                'size' => '20',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'telephone',
                'caption' => 'Телефон',
                'pattern' => 'text',
                'maxlength' => '32',
                'size' => '20',
                'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'city_id',
                'caption' => 'Город',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'size' => '1',
                'options' => array_merge(array( 0 => "Все города"),
                Form::array_combine(DB::fetchAll('SELECT id,city FROM `city_list`')))
                )
        );

        $form->addfield(array('name' => 'group_id',
                'caption' => 'Группа',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'size' => '1',
                'options' => Form::array_combine(DB::fetchAll('SELECT id,title FROM `admin_group_table`'))
                )
        );

        $form->addfield(array('name' => 'submit',
                'caption' => 'Сохранить',
                'pattern' => 'submit')
        );

        self::validate($form);
    }

    public static function save() {
        $data = array();
        unset($_POST['submit']);
        unset($_POST['confirm']);
        $data = $_POST;
        $data['password'] = AdminAuth::crypt($data['password']);
        DB::insert('admin_table',$data);
    }

    public static function showList() {
        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=admins&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'800','height'=>'240'
                ),
                array(
                array('title'=>'id','width'=>'50','align'=>'center'),
                array('title'=>'Логин','width'=>'400'),
                array('title'=>'E-mail','width'=>'400'),
                array('title'=>'Действия','align'=>'center')
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
        $count = $records['count'];
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        $records = DB::fetchAll(
                "SELECT id,login,email,is_hidden FROM admin_table ".
                'LIMIT '.$start.' , '.$limit
        );
        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
            $record['status']="<input type='checkbox' ".$checked."
                onchange='toggleItem(".$record['id'].")' class='hide_item' />";
        }
        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }




}