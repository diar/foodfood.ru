<?php

require_once "adminModule.class.php";

class banners extends AdminModule {

    protected static $_title = "Баннеры";
    protected static $_DB_table = 'banners';

    public static function initModule() {
        self::addAction('add', 'Добавить баннер', 7, true);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {
        $form = Form::newForm('banners', 'bannersForm', DBP::getPrefix() . self::getDbTable());

        $form->addfield(array('name' => 'title',
            'caption' => 'Название',
            'pattern' => 'text',
            'maxlength' => '50',
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'href',
            'caption' => 'Ссылка при клике',
            'pattern' => 'text',
            'maxlength' => '255',
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'count',
            'caption' => 'Количество показов',
            'pattern' => 'text',
            'maxlength' => '20',
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'target_id',
            'caption' => 'Id элемента',
            'pattern' => 'text',
            'maxlength' => '20',
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'src',
            'caption' => 'Баннер',
            'pattern' => 'file',
            'formats' => array('jpg', 'png', 'jpeg', 'gif','swf'),
            'maxlength' => '255',
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'position',
                'caption' => 'Расположение',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'size' => '1',
                'options' => array(
                    'main_h'=>'На главной горизонтальная',
                    'rest_h'=>'У ресторана горизонтальная',
                    'main_v'=>'На главной вертикальная',
                    'rest_v'=>'У ресторана вертикальная'
                    )
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
            $record = DBP::getRecord(self::getDbTable(), "id =" . $id);
        }

        $form = Form::newForm('banners', 'bannersForm', DBP::getPrefix() . self::getDbTable());

        $form->addfield(array('name' => 'title',
            'caption' => 'Название',
            'pattern' => 'text',
            'maxlength' => '50',
            'value' => $record['title'],
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'href',
            'caption' => 'Ссылка при клике',
            'pattern' => 'text',
            'maxlength' => '255',
            'value' => $record['href'],
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'count',
            'caption' => 'Количество показов',
            'pattern' => 'text',
            'maxlength' => '20',
            'value' => $record['count'],
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'target_id',
            'caption' => 'Id элемента',
            'pattern' => 'text',
            'maxlength' => '20',
            'value' => $record['target_id'],
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'src',
            'caption' => 'Баннер',
            'pattern' => 'file',
            'formats' => array('jpg', 'png', 'jpeg', 'gif','swf'),
            'value' => $record['src'],
            'maxlength' => '255',
            'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'position',
                'caption' => 'Расположение',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'selected' => $record['position'],
                'size' => '1',
                'options' => array(
                    'main_h'=>'На главной горизонтальная',
                    'rest_h'=>'У ресторана горизонтальная',
                    'main_v'=>'На главной вертикальная',
                    'rest_v'=>'У ресторана вертикальная'
                    )
                )
        );

        $form->addfield(array('name' => 'edit',
            'caption' => 'Сохранить',
            'css_class' => 'ui_button',
            'pattern' => 'submit'
        ));

        self::validate($form, $id, true);
    }

    public static function save() {
        $data = $_POST;
        if (end(explode('.',$_FILES['src']['name']))=='swf') {
            $data['type'] = 'flash';
            $file_path = 'flash/banners/';
        } else {
            $data['type'] = 'image';
            $file_path = 'image/banners/';
        }
        if (!empty($_FILES['src']['name'])) {
            $file = File::saveFile('src', null, Config::getValue('path', 'upload') . 'image/banners/');
            if (!empty($file)) {
                $data['src'] = $file;
            } else {
                echo "Ошибка при загрузке баннера.";
                return false;
            }
        } else {
            $data['img'] = null;
        }
        DBP::insert(self::getDbTable(), $data);
    }

    public static function saveEdit() {
        $id = ELEMENT_ID;
        $data = $_POST;

        if (end(explode('.',$_FILES['src']['name']))=='swf') {
            $data['type'] = 'flash';
            $file_path = 'flash/banners/';
        } else {
            $data['type'] = 'image';
            $file_path = 'image/banners/';
        }

        if (!empty($_FILES['src']['name'])) {
            $file = File::saveFile('src', null, Config::getValue('path', 'upload') . 'image/banners/');
            if (!empty($file)) {
                $data['img'] = $file;
            } else {
                echo "Ошибка при загрузке баннера.";
                return false;
            }
        }
        DBP::update(self::getDbTable(), $data, 'id =' . $id);
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(), 'id =' . $id);
        header('Location: admin.php?page=restPoster', true, 303);
    }

    public static function showList() {
        $list = Form::showJqGrid(
                        array(
                            'url' => '/admin/admin.php?page=banners&action=showJSON',
                            'table' => 'gridlist', 'pager' => 'gridpager', 'width' => '600', 'height' => '400'
                        ),
                        array(
                            array('title' => 'id'),
                            array('title' => 'Название')
                        )
        );
        self::showTemplate($list);
    }

    public static function showJSON() {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        //Получаем количество афиш
        $records = DB::fetch(
                        "SELECT COUNT(*) FROM " . DBP::getPrefix() . self::getDbTable()
        );
        //Вычисляем кол-во страниц
        $count = $records['COUNT(*)'];
        $total_pages = ($count > 0) ? ceil($count / $limit) : 0;
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit;
        $records = DB::fetchAll(
                        "SELECT id, title FROM " . DBP::getPrefix() .self::getDbTable().
                        ' LIMIT ' . $start . ' , ' . $limit
        );

        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE, 'delete', $record['id']);
            $record['control'] = "<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }

        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

}