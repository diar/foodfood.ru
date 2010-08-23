<?php
require_once "adminModule.class.php";

class marketSettings extends AdminModule {

    protected static $_title = "Настройка доставки";
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
        } else {
            $record = DBP::getRecord(self::getDbTable(),"rest_id =".$id);
            if (empty($record)) {
                DBP::insert(self::getDbTable(), array("rest_id"=>$id));
                $record = DBP::getRecord(self::getDbTable(),"rest_id =".$id);
            }
        }
        $form = Form::newForm('market_partner','restForm',DBP::getPrefix().self::getDbTable());

        $form->addfield(array('name' => 'partner_email',
                'caption' => 'E-mail',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['partner_email'],
                'css_class' => 'caption')
        );

        $form->addfield(array('name' => 'partner_phones',
                'caption' => 'Номера телефонов',
                'pattern' => 'text',
                'maxlength' => '255',
                'value' => $record['partner_phones'],
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
        $data = $_POST;
        DBP::update(self::getDbTable(),$data,'rest_id ='.self::getRestId());
    }

}