<?php
require_once "adminModule.class.php";

class discounts extends AdminModule {
    protected static $_title = "Скидки";
    protected static $_DB_table = 'rest_discount';

    public static function add() {

    }

    public static function edit() {
        $record = DBP::getRecord('rest_discount',"id =".ELEMENT_ID);
        $form = Form::newForm('rest_discount','restForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'discount_description',
                'caption' => 'Описание скидки',
                'value'=>$record['discount_description'],
                'pattern' => 'textarea')
        );
        $form->addfield(array('name' => 'edit',
                'caption' => 'Сохранить',
                'css_class' => 'ui_button',
                'pattern' => 'submit')
        );
        self::validate($form,ELEMENT_ID,true);
    }

    public static function saveEdit() {
        unset($_POST['edit']);
        $data = $_POST;
        DBP::update(self::getDbTable(),$data,'id ='.ELEMENT_ID);
    }

    public static function save() {
        if (isset($_POST['percent'])) {
            $data['discount_percent'] = $_POST['percent'];
        } else return 'Заполните все поля';
        if (isset($_POST['count'])) {
            $data['discount_count'] = $_POST['count'];
        } else return 'Заполните все поля';
        if (!is_numeric($data['discount_percent']) || $data['discount_percent']>100)
            return 'Введите проценты в правильном виде';
        if (!is_numeric($data['discount_count']))
            return 'Введите количество в правильном виде';
        $data['rest_id']=DB::quote(self::getRestId());
        $data['discount_percent'] = DB::quote($data['discount_percent']);
        $data['discount_count'] = DB::quote($data['discount_count']);
        $data['discount_date']='NOW()';
        DBP::insert('rest_discount', $data,false);
        $id = DBP::lastInsertId();
        ///////////////////////////////////
        for ($i=0;$i<$_POST['count'];$i++) {
            $cifer = rand (111,999);
            $numb = floor($cifer/100) + ($cifer%10)+floor(($cifer%100)/10);
            if ($numb<10) $numb='0'.$numb;
            $number =$numb.$cifer;
            $list['discount_secret']=$number;
            $list['discount_id']=$id;
            $list['discount_counter']=$i+1;
            DBP::insert('discount_list', $list);
        }
        ///////////////////////////////////
        DB::insert('log_discount', Array(
                'restaurant_id'=>self::getRestId(),
                'login'=>DB::quote($_SESSION['admin']['login']),
                'count'=>$data['discount_count'],
                'percent'=>$data['discount_percent'],
                'date'=>'NOW()'
                ),false);
        return 'Скидки добавлены';
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(),'id ='.$id);
        DBP::delete('discount_list','discount_id ='.$id);
        header('Location: admin.php?page=discounts', true, 303);
    }

    public static function showList() {
        if(!empty($_POST)) $message=self::save();
        else $message = '';
        echo $message;
        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=discounts&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'500','height'=>'500'
                ),
                array(
                array('title'=>'id','width'=>'40','align'=>'center'),
                array('title'=>'Процент','align'=>'center'),
                array('title'=>'Количество','align'=>'center'),
                array('title'=>'Управление','align'=>'center')
                )
        );
        $content['message']=$message;
        $list = '<div style="width:540px;float:left">'.$list.'</div>'.
                View::getXSLT($content, 'blocks/admin_discounts');
        self::showTemplate($list);
    }

    public static function showJSON() {
        Debug::disable();
        $records = DB::fetchAll("SELECT id,discount_percent,discount_count FROM ".DBP::getPrefix()."rest_discount WHERE rest_id=".self::getRestId());
        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }
        echo Form::arrayToJqGrid($records, 1, 1, 1);
    }

    public static function saveForRest() {
        Debug::disable();
        $records = DB::fetchAll(
                "SELECT discount_counter, discount_percent, discount_secret, discount_activated ".
                "FROM ".DBP::getPrefix()."rest_discount AS ds ".
                "LEFT JOIN ".DBP::getPrefix()."discount_list AS ls ON ls.discount_id=ds.id ".
                "WHERE rest_id=".self::getRestId()
        );
        if (!empty($records)) {
            foreach ($records as &$record) {
                $record['discount_percent'] = $record['discount_percent'].' %';
                $record['discount_secret_rest'] = substr($record['discount_secret'], 0, 2);
                $record['discount_secret_user'] = substr($record['discount_secret'], 2, 3);
                unset($record['discount_secret']);
            }

            $caption = Array(Array('номер','процент','активирован','код 1','код 2'));
        } else {
            $records=Array(array());
        }
        $records = array_merge($caption, $records);

        $path = 'discount_list'.time().'.xls';

        File::saveXLS($records,Config::getValue('path','tmp').$path,"Список скидок foodfood","foodfood.ru");

        header('Location: /tmp/'.$path, true, 303);
    }

    public static function saveForOff() {
        Debug::disable();
        $records = DB::fetchAll(
                "SELECT discount_counter, discount_percent, discount_secret, discount_activated ".
                "FROM ".DBP::getPrefix()."rest_discount AS ds ".
                "LEFT JOIN ".DBP::getPrefix()."discount_list AS ls ON ls.discount_id=ds.id ".
                "WHERE rest_id=".self::getRestId()
        );
        if (!empty($records)) {
            foreach ($records as &$record) {
                $record['discount_percent'] = $record['discount_percent'].' %';
                $record['discount_secret_rest'] = substr($record['discount_secret'], 0, 2);
                $record['discount_secret_user'] = '___';
                unset($record['discount_secret']);
            }

            $caption = Array(Array('номер','процент','активирован','код 2','код 2'));
        } else {
            $records=Array(array());
        }
        $records = array_merge($caption, $records);
        $path = 'discount_list'.time().'.xls';

        File::saveXLS($records,Config::getValue('path','tmp').$path,"Список скидок foodfood","foodfood.ru");

        header('Location: /tmp/'.$path, true, 303);
    }

}