<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница знакомства
 */
class dating_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Диалог - Оставить приглашение
    */
    public static function invitationAjaxAction ($id) {
        self::$page['content']['restaurant']['title'] = $_POST['rest_title'];
        self::showXSLT('pages/dating/invitation');
    }
    
    /*
     * Оставить приглашение
    */
    public static function inviteAjaxAction ($id) {
        echo MD_Dating::invite(
                $_POST['rest_id'],$_POST['dating_topicality'],$_POST['dating_time'],
                $_POST['dating_target'],$_POST['dating_text']
        );
    }

    /*
     * Диалог - Принять приглашение
    */
    public static function followingAjaxAction ($id) {
        self::$page['content']['restaurant']['title'] = $_POST['rest_title'];
        self::$page['content']['inviter']=MD_Dating::getUser($_POST['rest_id'],$_POST['user_id']);
        self::showXSLT('pages/dating/following');
    }

    /*
     * Принять приглашение
    */
    public static function followAjaxAction ($id) {
        echo MD_Dating::follow($_POST['rest_id'],$_POST['rest_title'],$_POST['user_id']);
    }
}