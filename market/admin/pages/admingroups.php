<?php
require_once "adminModule.class.php";

class AdminGroups extends AdminModule {
    
    public static function add() {

        $form = Form::newForm('adminGroups','adminsForm','admin_group_table');

        $form->addfield(array('name' => 'title',
                'caption' => 'Название',
                'pattern' => 'text',
                'maxlength' => '32',
                'size' => '20',
                'help' => 'латинские символы',
                'is_unique' => true,
                'css_class' => 'caption')
        );


        $form->addfield(array('name' => 'restaurant_id',
                'caption' => 'Ресторан',
                'pattern' => 'select',
                'css_class' => 'caption',
                'multiple' => false,
                'size' => '1',
                'options' =>  array_merge(array( 0 => "Все рестораны"),
                Form::array_combine(DB::fetchAll('SELECT id,city FROM `city_list`')))
                )
        );


        $form->addfield(array('name' => 'submit',
                'caption' => 'Сохранить',
                'pattern' => 'submit')
        );

        self::validate($form);

    }

    public static function save() {

        $data = array();
        unset($_POST['submit']);
        unset($_POST['confirm']);
        $data = $_POST;

        DB::insert('admin_group_table',$data);

    }




}