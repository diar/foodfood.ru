<?php
require_once "adminModule.class.php";

class restPoster extends AdminModule {

    protected static $_title = "Афиша";

    protected static $_DB_table = 'rest_poster';

    public static function initModule () {
        self::addAction('add', 'Добавить афишу',7,true);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {
        $form = Form::newForm('rest_poster','restForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'is_required' => true,
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
        $form->addfield(array('name' => 'date',
                'caption' => 'Дата начала (гггг-мм-дд)',
                'pattern' => 'text',
                'is_required' => true,
                'maxlength' => '255',
                'css_class' => 'caption datepicker')
        );

        $form->addfield(array('name' => 'date_end',
                'caption' => 'Дата окончания',
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption datepicker')
        );
        $form->addfield(array('name' => 'repeat_week',
                'caption' => 'Повторять каждую неделю',
                'pattern' => 'checkbox',
                'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'poster_type',
                'caption' => 'Тип',
                'pattern' => 'select',
                'options' => array(1=>'акция',2=>'афиша',3=>'новость'),
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'anounce',
                'caption' => 'Краткий текст',
                'is_required' => true,
                'pattern' => 'textarea',
                )
        );

        $form->addfield(array('name' => 'text',
                'caption' => 'Описание',
                'pattern' => 'editor',
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
            $record['repeat_week']=!empty($record['repeat_week']) ? 1 : 0;
        } else {
            $record = DBP::getRecord(self::getDbTable(),"id =".$id);
            switch($record['poster_type']) {
                case 'action'   : $record['poster_type'] = 1;
                    break;
                case 'poster'   : $record['poster_type'] = 2;
                    break;
                case 'news'     : $record['poster_type'] = 3;
                    break;
            }
        }

        $form = Form::newForm('rest_poster','posterForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array(
                'name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'is_required' => true,
                'maxlength' => '255',
                'css_class' => 'caption',
                'value' => $record['title']
        ));
        $form->addfield(array(
                'name' => 'img',
                'caption' => 'Изображение',
                'pattern' => 'file',
                'formats' => array('jpg','png','jpeg','gif'),
                'maxlength' => '255',
                'css_class' => 'caption'
        ));
        $form->addfield(array(
                'name' => 'date',
                'caption' => 'Дата начала (гггг-мм-дд)',
                'pattern' => 'text',
                'maxlength' => '255',
                'is_required' => true,
                'css_class' => 'caption datepicker',
                'value' => $record['date']
        ));

        $form->addfield(array(
                'name' => 'date_end',
                'caption' => 'Дата окончания',
                'pattern' => 'text',
                'maxlength' => '255',
                'css_class' => 'caption datepicker',
                'value' => $record['date_end']
        ));
        $form->addfield(array(
                'name' => 'repeat_week',
                'caption' => 'Повторять каждую неделю',
                'pattern' => 'checkbox',
                'css_class' => 'caption',
                'checked' => $record['repeat_week']
        ));
        $form->addfield(array(
                'name' => 'poster_type',
                'caption' => 'Тип',
                'pattern' => 'select',
                'selected'=>$record['poster_type'],
                'options' => array(1=>'акция',2=>'афиша',3=>'новость'),
                'css_class' => 'caption'
        ));

        $form->addfield(array(
                'name' => 'anounce',
                'caption' => 'Краткий текст',
                'pattern' => 'textarea',
                'is_required' => true,
                'value' => $record['anounce']
        ));

        $form->addfield(array(
                'name' => 'text',
                'caption' => 'Описание',
                'pattern' => 'editor',
                'value' => $record['text']
        ));

        $form->addfield(array('name' => 'edit',
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
        switch($data['poster_type']) {
            case 1   : $data['poster_type'] = 'action';
                break;
            case 2   : $data['poster_type'] = 'poster';
                break;
            case 3     : $data['poster_type'] = 'news';
                break;
        }
        $data['repeat_week']=!empty($data['repeat_week']) ? 1 : 0;

        $date_start=explode('-',$data['date']);
        $date_start=mktime(0, 0, 0, $date_start[1], $date_start[2], $date_start[0]);
        $data['repeat_week_start']=date('w',$date_start);

        if ($data['date_end']!='' && $data['date_end']!='0000-00-00') {
            $date_end=explode('-',$data['date_end']);
            $date_end=mktime(0, 0, 0, $date_end[1], $date_end[2], $date_end[0]);
            $data['repeat_week_end']=date('w',$date_end);
        }

        if (!empty($_FILES['img']['name'])) {
            $file = File::saveFile('img', null,  Config::getValue('path','upload').'image/poster/');
            if (!empty($file)) {
                $file_path=Config::getValue('path','upload').'image/poster/';
                Image::resizeImage($file_path.$file, 76);
                $data['img'] = $file;
            } else {
                echo "Ошибка в загрузке фото.";
                return false;
            }
        } else {
            $data['img']= null;
        }
        $data['rest_id'] = self::getRestId();
        DBP::insert('rest_poster',$data);
    }

    public static function saveEdit() {
        $data = array();
        $id = ELEMENT_ID;
        unset($_POST['edit']);
        $data = $_POST;
        switch($data['poster_type']) {
            case 1   : $data['poster_type'] = 'action';
                break;
            case 2   : $data['poster_type'] = 'poster';
                break;
            case 3     : $data['poster_type'] = 'news';
                break;
        }
        $data['repeat_week']=!empty($data['repeat_week']) ? 1 : 0;

        $date_start=explode('-',$data['date']);
        $date_start=mktime(0, 0, 0, $date_start[1], $date_start[2], $date_start[0]);
        $data['repeat_week_start']=date('w',$date_start);

        if ($data['date_end']!='' && $data['date_end']!='0000-00-00') {
            $date_end=explode('-',$data['date_end']);
            $date_end=mktime(0, 0, 0, $date_end[1], $date_end[2], $date_end[0]);
            $data['repeat_week_end']=date('w',$date_end);
        }

        if (!empty($_FILES['img']['name'])) {
            $file = File::saveFile('img', null,  Config::getValue('path','upload').'image/poster/');
            if (!empty($file)) {
                $file_path=Config::getValue('path','upload').'image/poster/';
                Image::resizeImage($file_path.$file, 76);
                $data['img'] = $file;
            } else {
                echo "Ошибка в загрузке фото.";
                return false;
            }
        }
        $data['rest_id'] = self::getRestId();
        DBP::update('rest_poster',$data,'id ='.$id);

    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(),'id ='.$id);
        header('Location: admin.php?page=restPoster', true, 303);
    }

    public static function showList() {

        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=restPoster&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'600','height'=>'400'
                ),
                array(
                array('title'=>'id'),
                array('title'=>'Название'),
                array('title'=>'Дата'),
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
                "SELECT COUNT(*) FROM ".DBP::getPrefix()."rest_poster WHERE rest_id=".self::getRestId()
        );
        //Вычисляем кол-во страниц
        $count = $records['COUNT(*)'];
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        $records = DB::fetchAll(
                "SELECT id,title,date FROM ".DBP::getPrefix()."rest_poster WHERE rest_id=".self::getRestId().
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