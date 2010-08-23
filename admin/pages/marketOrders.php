<?php
require_once "adminModule.class.php";

class marketOrders extends AdminModule {

    protected static $_title = "Заказы Он-лайн";
    protected static $_DB_table = 'market_orders';

    public static function initModule () {
        self::addAction('showText', 'Показать состав', 1);
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function add() {
        return false;
    }

    public static function edit() {
       return false;
    }

    public static function save() {
       return false;
    }

    public static function saveEdit() {
        return false;
    }

    public static function showText() {
        $id = ELEMENT_ID;
        $text = DBP::getValue('market_orders', 'text',"id = '$id'");
        $listLink = self::getLink(PAGE, 'showList', $record['id']);
        $text = "
            <div style='margin:0 auto; width: 50%'>
                $text
            </div>
            <div style='text-align:center'><a href='$listLink'>Вернутся к списку</a></div>
            ";
        self::showTemplate($text);
    }

    public static function showList() {

        $list = Form::showJqGrid(
                array(
                'url'=>'/admin/admin.php?page=marketOrders&action=showJSON',
                'table'=>'gridlist','pager'=>'gridpager','width'=>'800','height'=>'240'
                ),
                array(
                    array('title'=>'id','width'=>50, 'align'=>'center'),
                    array('title'=>'Адрес'),
                    array('title'=>'Стоимость'),
                    array('title'=>'Время получения заказа'),
                    array('title'=>'Состав'),
                )
        );
        self::showTemplate($list);
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(),'id ='.$id);
        header('Location: admin.php?page=marketOrders', true, 303);
    }

    public static function showJSON() {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $records = DB::fetchAll(
                'SELECT id,address,phone,start_time FROM '.DBP::getPrefix().self::getDbTable().
                ' WHERE rest_id='.self::getRestId()
        );
        //Вычисляем кол-во страниц
        $count = count($records);
        $total_pages = ($count >0) ? ceil($count/$limit) : 0;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        
        foreach ($records as &$record) {
            $textLink = self::getLink(PAGE, 'showText', $record['id']);
            $record['control']="<a href='$textLink'>Состав</a>";
        }

        echo Form::arrayToJqGrid($records, $total_pages, $page, $count);
    }

}