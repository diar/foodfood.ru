<?php

require_once "adminModule.class.php";

class reviews extends AdminModule {

    protected static $_title = "Отзывы о ресторане";
    protected static $_DB_table = 'rest_comment';

    public static function showList() {
        $list = Form::showJqGrid(
                        array(
                            'url' => '/admin/admin.php?page=reviews&action=showJSON',
                            'table' => 'gridlist', 'pager' => 'gridpager', 'width' => '800', 'height' => '600'
                        ),
                        array(
                            array('title' => 'id', 'width' => '40', 'align' => 'center'),
                            array('title' => 'Пользователь', 'width' => '100'),
                            array('title' => 'Текст', 'width' => '480'),
                            array('title' => 'Управление', 'width' => '70', 'align' => 'center')
                        )
        );
        self::showTemplate($list);
    }

    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(), 'id =' . $id);
        header('Location: admin.php?page=reviews', true, 303);
    }

    public static function showJSON() {
        $records = DB::fetchAll(
                        "SELECT id,user_login,text FROM " . DBP::getPrefix() . "rest_comment AS cm " .
                        "LEFT JOIN user ON user.user_id=cm.user_id " .
                        "WHERE rest_id=" . self::getRestId());

        if ($_SESSION['admin']['access'] == 'superadmin') {
            foreach ($records as &$record) {
                $delLink = self::getLink(PAGE, 'delete', $record['id']);
                $record['control'] = "<a href='$delLink'>Удалить</a>";
            }
        }

        echo Form::arrayToJqGrid($records, 1, 1, 1);
    }

}