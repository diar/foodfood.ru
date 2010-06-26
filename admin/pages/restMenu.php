<?php
require_once "adminModule.class.php";

class restMenu extends AdminModule {

    protected static $_title = "Ресторан";

    protected static $_DB_table = 'rest_menu';

    public static function initModule () {
        self::addAction('add', 'Добавить блюдо',7,true);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {
        $form = Form::newForm('rest_menu','menuForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'portion',
                'caption' => 'Порция',
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'price',
                'caption' => 'Цена(руб.)',
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'img',
                'caption' => 'Изображение',
                'pattern' => 'file',
                'formats' => array('jpg','png','jpeg','gif'),
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'type_id',
                'caption' => 'Тип меню',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'size' => '1',
                'options' => array_merge(array( 0 => "Укажите тип меню"),
                Form::array_combine(DB::fetchAll('SELECT id,title FROM `list_menu_type`')))
                )
        );

        $form->addfield(array('name' => 'description',
                'caption' => 'Описание',
                'pattern' => 'textarea',
                )
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
            $record = DBP::getRecord(self::getDbTable(),"id =".$id);
        }

        $form = Form::newForm('rest_menu','menuForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['title'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'portion',
                'caption' => 'Порция',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['portion'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'price',
                'caption' => 'Цена(руб.)',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['price'],
                'css_class' => 'caption')
        );


        $form->addfield(array('name' => 'img',
                'caption' => 'Изображение',
                'pattern' => 'file',
                'formats' => array('jpg','png','jpeg','gif'),
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'type_id',
                'caption' => 'Тип меню',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'size' => '1',
                'options' => array_merge(array( 0 => "Укажите тип меню"),
                Form::array_combine(DB::fetchAll('SELECT id,title FROM `list_menu_type`')))
                )
        );



        $form->addfield(array('name' => 'description',
                'caption' => 'Описание',
                'pattern' => 'textarea',
                )
        );

        $form->addfield(array('name' => 'id',
                'pattern' => 'hidden',
                'value' => $id
                )
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
        if (!empty($_FILES['img']['name'])) {
            $file = File::saveFile('img', null,  Config::getValue('path','upload').'image/menu/');
            if (!empty($file)) {
                $data['img'] = $file;
            } else {
                echo "Ошибка в загрузке фото.";
                return false;
            }
        } else {
            $data['img']= null;
        }
        $data['rest_id'] = self::getRestId();
        DBP::insert(self::getDbTable(),$data);
    }

    public static function saveEdit() {
        $data = array();
        $id = $_POST['id'];
        unset($_POST['edit']);
        unset($_POST['id']);
        $data = $_POST;
        if (!empty($_FILES['img']['name'])) {
            $file = File::saveFile('img', null,  Config::getValue('path','upload').'image/menu/');
            if (!empty($file)) {
                $data['img'] = $file;
            } else {
                echo "Ошибка в загрузке фото.";
                return false;
            }
        }
        $data['rest_id'] = self::getRestId();
        DBP::update(self::getDbTable(),$data,'id ='.$id);
    }

    public static function showList() {

        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=restMenu&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'800','height'=>'400'
                ),
                array(
                array('title'=>'id'),
                array('title'=>'Название'),
                array('title'=>'Порция'),
                array('title'=>'Цена'),
                array('title'=>'Управление')
                )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        //Получаем количество ресторанов
        $records = DB::fetch(
                "SELECT COUNT(*) FROM ".DBP::getPrefix().self::getDbTable().' WHERE rest_id='.self::getRestId()
        );
        //Вычисляем кол-во страниц
        $count = $records['COUNT(*)'];
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        $records = DB::fetchAll(
                'SELECT id,title,portion,price FROM '.DBP::getPrefix().self::getDbTable().
                ' WHERE rest_id='.self::getRestId()
        );
        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }

        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

}