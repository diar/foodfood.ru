<?php
require_once "adminModule.class.php";

class persons extends AdminModule {
    protected static $_title = "Отчет";
    protected static $_DB_table = 'persons';

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule () {
        self::addAction('add', 'Добавить лицо',7,true);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {
        $form = Form::newForm('persons','restForm',DBP::getPrefix().self::getDbTable());

        $person_text = '<q>Три ваших любимых заведения?</q><a></a>'.
                        '<q>Ваше любимое блюдо?</q><a></a>'.
                        '<q>Ваше предпочтение  в выпивке?</q><a></a>'.
                        '<q>Любимое лакомство из Вашего Детства?</q><a></a>'.
                        '<q>Вы готовите дома? Возможно экспериментируете. '.
                        'Ваше фирменное блюдо?</q><a></a>'.
                        '<q>Каким вы видите идеальный ресторан будущего?</q><a></a>';

        $form->addfield(array('name' => 'person_name',
                'caption' => 'Имя',
                'is_unique' => true,
                'is_required' => true,
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'uri',
                'caption' => 'uri',
                'is_unique' => true,
                'is_required' => true,
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'person_post',
                'caption' => 'Должность',
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'person_photo',
                'caption' => 'Основная фотография',
                'pattern' => 'file',
                'formats' => array('jpg','png','jpeg','gif'),
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'person_text',
                'caption' => 'Приятного аппетита',
                'pattern' => 'textarea')
        );
        $form->addfield(array('name' => 'person_questions',
                'caption' => 'Интервью',
                'value'=>$person_text,
                'pattern' => 'textarea')
        );

        $form->addfield(array('name' => 'submit',

                'caption' => 'Добавить',
                'css_class' => 'ui_button',
                'pattern' => 'submit')
        );

        self::validate($form);
    }

    public static function edit() {
        $record = DBP::getRecord('persons',"id =".ELEMENT_ID);
        $form = Form::newForm('restaurants','restForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'person_name',
                'caption' => 'Имя',
                'is_unique' => true,
                'is_required' => true,
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record ['person_name'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'uri',
                'caption' => 'uri',
                'is_unique' => true,
                'is_required' => true,
                'pattern' => 'text',
                'value' => $record ['uri'],
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'person_post',
                'caption' => 'Должность',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record ['person_post'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'person_photo',
                'caption' => 'Основная фотография',
                'pattern' => 'file',
                'formats' => array('jpg','png','jpeg','gif'),
                'maxlength' => '255',
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'person_text',
                'caption' => 'Приятного аппетита',
                'value' => $record ['person_text'],
                'pattern' => 'textarea')
        );
        $form->addfield(array('name' => 'person_questions',
                'caption' => 'Интервью',
                'value' => $record ['person_questions'],
                'pattern' => 'textarea')
        );

        $form->addfield(array('name' => 'edit',
                'caption' => 'Сохранить',
                'css_class' => 'ui_button',
                'pattern' => 'submit')
        );

        $img = '<img src="/upload/image/persons/medium-'.$record['uri'].'.jpg" style="float:right;margin-right:20px;" />';
        self::validate($form,ELEMENT_ID,true,$img);
    }

    public static function save() {
        $data = $_POST;

        if (!empty($_FILES['person_photo']['name'])) {
            $file = File::saveFile('person_photo', $_POST['uri'], Config::getValue('path','upload').'image/persons/');
            $file_path=Config::getValue('path','upload').'image/persons/';
            Image::resizeImage(
                    $file_path.$file, 53, 80, true, $file_path.'mini-'.$file, false
            );
            Image::resizeImage(
                    $file_path.$file, 114, 171, true, $file_path.'medium-'.$file, false
            );
            if (empty($file)) {
                echo "Ошибка в загрузке фото.";
                return false;
            }
        }

        DBP::insert(self::getDbTable(),$data);
    }

    public static function saveEdit() {
        $data = array();
        unset($_POST['edit']);
        $data = $_POST;
        if (!empty($_FILES['person_photo']['name'])) {
            $file = File::saveFile('person_photo', $_POST['uri'], Config::getValue('path','upload').'image/persons/');
            $file_path=Config::getValue('path','upload').'image/persons/';
            Image::resizeImage(
                    $file_path.$file, 53, 80, true, $file_path.'mini-'.$file, false
            );
            Image::resizeImage(
                    $file_path.$file, 114, 171, true, $file_path.'medium-'.$file, false
            );
            if (empty($file)) {
                echo "Ошибка в загрузке фото.";
                return false;
            }
        }
        DBP::update(self::getDbTable(),$data,'id ='.ELEMENT_ID);
    }

    public static function apply() {
        return false;
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(),'id ='.$id);
        header('Location: admin.php?page=persons', true, 303);
    }

    public static function showList() {
        if(!empty($_POST)) self::save();
        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=persons&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'690','height'=>'500'
                ),
                array(
                array('title'=>'#','width'=>'200'),
                array('title'=>'Имя','width'=>'200'),
                array('title'=>'Должность','width'=>'200'),
                array('title'=>'Управление','width'=>'200','align'=>'center'),
                )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        error_reporting(0);
        Debug::disable();
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        // Получаем кол-во записей
        $records = DBP::fetch(
                'SELECT COUNT(*) AS count FROM '.DBP::getPrefix().'persons AS sn '
        );

        $count = $records['count'];
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $records = DBP::fetchAll(
                'SELECT id,person_name,person_post FROM '.DBP::getPrefix().'persons LIMIT '.$start.' , '.$limit
        );
        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }

        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

}