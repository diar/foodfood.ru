<?php

require_once "adminModule.class.php";

class settingsSite extends AdminModule {

    // Титл для вывода в строке браузера и на странице
    protected static $_title = "Настройки сайта";

    public static function save() {
        Config::write(Array('site', 'sms', 'menu'), $_SERVER['DOCUMENT_ROOT'] . '/config/site.ini.php');
    }

    public static function showList() {
        $form = Form::newForm('settings', 'restForm');
        $form->addfield(array(
            'name' => 'name',
            'caption' => 'Название сайта',
            'pattern' => 'text',
            'maxlength' => '255',
            'css_class' => 'caption',
            'value' => Config::getValue('site', 'name')
        ));
        $form->addfield(array(
            'name' => 'title',
            'caption' => 'Заголовок сайта',
            'pattern' => 'text',
            'maxlength' => '255',
            'css_class' => 'caption',
            'value' => Config::getValue('site', 'title')
        ));
        $form->addfield(array(
            'name' => 'keywords',
            'caption' => 'Ключевые слова',
            'pattern' => 'text',
            'maxlength' => '255',
            'css_class' => 'caption',
            'value' => Config::getValue('site', 'keywords')
        ));
        $form->addfield(array(
            'name' => 'description',
            'caption' => 'Описание сайта',
            'pattern' => 'textarea',
            'maxlength' => '255',
            'css_class' => 'caption',
            'value' => Config::getValue('site', 'description')
        ));
        $form->addfield(
                array(
                    'name' => 'email',
                    'caption' => 'E-mail сайта',
                    'pattern' => 'text',
                    'maxlength' => '255',
                    'css_class' => 'caption',
                    'value' => Config::getValue('site', 'email')
        ));
        $form->addfield(array(
            'name' => 'edit',
            'caption' => 'Сохранить',
            'css_class' => 'ui_button',
            'pattern' => 'submit'
        ));
        $html = $form->buildForm();
        if (!empty($_POST)) {
            $data = $_POST;
            if ($form->validateForm($data)) {
                unset($data['edit']);
                foreach ($data as $param => $value) {
                    Config::setValue('site', $param, $value);
                }
                self::save();
            }
        }
        self::showTemplate($html);
    }

}