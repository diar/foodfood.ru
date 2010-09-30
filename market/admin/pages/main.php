<?php
require_once "adminModule.class.php";

class Main extends AdminModule {

    public static function add() {
        self::setTitle("Добавить страницу");
        self::showTemplate();
    }

    public static function save() {
        return true;
    }

    public static function edit() {
        return true;
    }

    public static function apply() {
        return true;
    }

    public static function saveEdit() {
        return true;
    }

    public static function showList() {
        $html = '';
        self::showTemplate($html);
    }


}