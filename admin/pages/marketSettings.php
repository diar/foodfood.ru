<?php
require_once "adminModule.class.php";

class Restaurants extends AdminModule {

    protected static $_title = "Ресторан";
    protected static $_DB_table = 'market_partner';

    public static function initModule () {
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    // Изменение информации о ресторане
    public static function edit() {
        $id = $_SESSION['admin']['restaurant_id'];
        if (!empty($_POST)) {
            $record = $_POST;
            $record['in_market']=!empty($record['in_market']) ? 1 : 0;
            // Работа с координатами google Maps
            $google_location = str_replace(')', '', $record['google_location']);
            $google_location = str_replace('(', '', $google_location);
            $google_location = explode (',',$google_location);
            if (!empty($google_location[1])) {
                $record['rest_google_x'] = $google_location[0];
                $record['rest_google_y'] = $google_location[1];
            } else {
                $record['rest_google_x'] = 0;
                $record['rest_google_y'] = 0;
            }
        } else {
            $record = DBP::getRecord(self::getDbTable(),"id =".$id);
        }
        $form = Form::newForm('restaurants','restForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'rest_address',
                'caption' => 'Адрес',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['rest_address'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'rest_ostanovka',
                'caption' => 'Остановка',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['rest_ostanovka'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'rest_metro',
                'caption' => 'Ближайшая станция метро',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['rest_metro'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'rest_site',
                'caption' => 'Сайт',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['rest_site'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'rest_phone',
                'caption' => 'Телефон',
                'pattern' => 'phone',
                'maxlength' => '255',
                'value' => $record['rest_phone'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'edit',
                'caption' => 'Сохранить',
                'css_class' => 'ui_button',
                'pattern' => 'submit')
        );

        self::validate($form,$id,true);
    }

    public static function saveEdit() {
        $data = array();
        unset($_POST['edit']);
        unset($_POST['confirm']);
        $data = $_POST;
        DBP::update('rest',$data,'id ='.self::getRestId());
    }

}