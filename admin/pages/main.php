<?php
require_once "adminModule.class.php";

class Main extends AdminModule {

    public static function add() {
        self::setTitle("Добавить страницу");
        self::showTemplate();
    }

    public static function showList() {
        $content['web_dir'] = '/upload/image/'.'rest_photo/'.self::getRestId().'/';
        $content['discounts'] = DBP::fetchAll(
                'SELECT * FROM '.DBP::getPrefix().'discount_send AS sn '.
                'LEFT JOIN '.DBP::getPrefix().'rest_discount AS ds ON sn.partner_id=ds.id '.
                'WHERE ds.rest_id='.self::getRestId().
                ' ORDER BY send_date DESC LIMIT 0,9'
        );
        foreach ($content['discounts'] as &$discount) {
            $discount['phone'] = preg_replace("/[0-9]{4}$/",'****',$discount['phone']);
        }
        $content['photo'] = DBP::getRecord('rest_photo', "rest_id = ".self::getRestId());
        $content['restaurant'] = DBP::getRecord('rest', 'id ='.self::getRestId());
        $content['discount'] = DBP::getValue('rest_discount', 'discount_count','rest_id ='.self::getRestId());
        $content['reviews'] = DBP::getRecords(
                'rest_comment','rest_id ='.self::getRestId(),array('limit'=>'0,3')
        );
        $list = View::getXSLT($content, 'blocks/admin_dashboard');
        self::showTemplate($list);
    }


}