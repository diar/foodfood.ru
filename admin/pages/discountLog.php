<?php
require_once "adminModule.class.php";

class discountLog extends AdminModule {
    protected static $_title = "Отчет";
    protected static $_DB_table = 'rest_discount';

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule () {
        $actions = self::getActions();
        $actions['showCsv'] = array(
                'title' => 'Список',
                'level' => 1,
                'onMenu' => false
        );
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function save() {
        if (isset($_POST['email'])) $data['email'] = $_POST['email'];
        if (isset($_POST['phone'])) $data['phone'] = $_POST['phone'];
        $data['send_log_email'] = !empty($_POST['is_email']) ?  1 : 0;
        $data['send_log_phone'] = !empty($_POST['is_phone']) ?  1 : 0;
        DB::update('admin_table', $data, 'id='.$_SESSION['admin']['id']);
    }
    public static function showList() {
        if(!empty($_POST)) self::save();
        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=discountLog&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'690','height'=>'500'
                ),
                array(
                array('title'=>'Имя','width'=>'150'),
                array('title'=>'E-mail','width'=>'150'),
                array('title'=>'Номер','width'=>'100'),
                array('title'=>'Дата отправки','width'=>'140','id'=>'sn.send_date'),
                array('title'=>'Код','width'=>'80'),
                array('title'=>'%','width'=>'50'),
                )
        );
        $content['admin']=DB::getRecord('admin_table', 'id='.$_SESSION['admin']['id']);
        $list = '<div style="width:690px;float:left">'.$list.'</div>'.
                View::getXSLT($content, 'blocks/admin_discount_log');
        self::showTemplate($list);
    }

    public static function showJSON() {
        $page = 1;
        $limit = 10;
        // Получаем кол-во записей
        $records = DBP::fetch(
                'SELECT COUNT(*) FROM '.
                DBP::getPrefix().'discount_send AS sn '.
                'LEFT JOIN '.DBP::getPrefix().'rest_discount AS ds ON sn.partner_id=ds.id '.
                'WHERE ds.rest_id='.self::getRestId().' ORDER BY send_date DESC'
        );
        $count = $records['COUNT(*)'];
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $records = DBP::fetchAll(
                'SELECT sn.name,sn.email,sn.phone,sn.send_date,sn.ident,ds.discount_percent, sn.id FROM '.
                DBP::getPrefix().'discount_send AS sn '.
                'LEFT JOIN '.DBP::getPrefix().'rest_discount AS ds ON sn.partner_id=ds.id '.
                'WHERE ds.rest_id='.self::getRestId().' ORDER BY send_date DESC LIMIT '.$start.' , '.$limit
        );

        foreach ($records as &$record) {
            $record['phone'] = preg_replace("/[0-9]{4}$/",'****',$record['phone']);
        }

        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

    public static function showCSV() {
        $records = DBP::fetchAll(
                'SELECT sn.name,sn.email,sn.phone,sn.send_date,sn.ident,ds.discount_percent, sn.id FROM '.
                DBP::getPrefix().'discount_send AS sn '.
                'LEFT JOIN '.DBP::getPrefix().'rest_discount AS ds ON sn.partner_id=ds.id '.
                'WHERE ds.rest_id='.self::getRestId().' ORDER BY send_date DESC'
        );
        foreach ($records as &$record) {
            $record['phone'] = preg_replace("/[0-9]{4}$/",'****',$record['phone']);
        }

        $path = 'discount_log'.time().'.csv';

        File::saveCSV($records,Config::getValue('path','tmp').$path,"Отчет по скидкам foodfood","foodfood.ru");

        header('Location: /tmp/'.$path, true, 303);
    }

    public static function showXLSX() {
        $records = DBP::fetchAll(
                'SELECT sn.name,sn.email,sn.phone,sn.send_date,sn.ident,ds.discount_percent, sn.id FROM '.
                DBP::getPrefix().'discount_send AS sn '.
                'LEFT JOIN '.DBP::getPrefix().'rest_discount AS ds ON sn.partner_id=ds.id '.
                'WHERE ds.rest_id='.self::getRestId().' ORDER BY send_date DESC'
        );
        foreach ($records as &$record) {
            $record['phone'] = preg_replace("/[0-9]{4}$/",'****',$record['phone']);
        }
        $caption = Array(Array('имя','e-mail','номер','дата отправки','код','номер'));
        $records = array_merge($caption, $records);
        $path = 'discount_log'.time().'.xlsx';

        File::saveXLSX($records,Config::getValue('path','tmp').$path,"Отчет по скидкам foodfood","foodfood.ru");

        header('Location: /tmp/'.$path, true, 303);
    }

    public static function showXLS() {
        $records = DBP::fetchAll(
                'SELECT sn.name,sn.email,sn.phone,sn.send_date,sn.ident,ds.discount_percent, sn.id FROM '.
                DBP::getPrefix().'discount_send AS sn '.
                'LEFT JOIN '.DBP::getPrefix().'rest_discount AS ds ON sn.partner_id=ds.id '.
                'WHERE ds.rest_id='.self::getRestId().' ORDER BY send_date DESC'
        );
        foreach ($records as &$record) {
            $record['phone'] = preg_replace("/[0-9]{4}$/",'****',$record['phone']);
        }

        $caption = Array(Array('имя','e-mail','номер','дата отправки','код','номер'));
        $records = array_merge($caption, $records);
        $path = 'discount_log'.time().'.xls';

        File::saveXLS($records,Config::getValue('path','tmp').$path,"Отчет по скидкам foodfood","foodfood.ru");

        header('Location: /tmp/'.$path, true, 303);
    }

}