<?php

require_once "adminModule.class.php";

class System extends AdminModule {

    /**
     * Таблица БД
     * @var string
     */
    protected static $_DB_table;
    /**
     * Заголовок страницы
     * @var string
     */
    protected static $_title = "Системные функции";
    /**
     * Уровни доступа к методам
     * @var array
     */
    protected static $_actions = array(
        'setRestaurant' => array(
            'title' => 'Сменить администрируемый ресторан',
            'level' => 7,
            'onMenu' => false
        )
    );

    public static function initModule() {
        self::start();
    }

    public static function setRestaurant() {
        if (ELEMENT_ID && $_SESSION['admin']['access'] == 'superadmin') {
            $id = ELEMENT_ID;
            $_SESSION['admin']['restaurant_id'] = $id;
            $_SESSION['admin']['restaurant'] = DBP::getRecord('rest', 'id=' . DB::quote($id));
            header('Location: admin.php?page=main', true, 303);
            die();
        }
    }

}