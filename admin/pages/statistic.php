<?php

require_once "adminModule.class.php";

class statistic extends AdminModule {

    // Титл для вывода в строке браузера и на странице
    protected static $_title = "Статистика посещаемости сайта";

    public static function showList() {
        $content = array();
        $list = View::getXSLT($content, 'blocks/admin_statistic');
        self::showTemplate($list);
    }

}