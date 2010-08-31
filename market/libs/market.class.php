<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для конфигурации маркета
 */
class Market {
    public static function initModule () {
        Config::setValue('route', 'offset', 1);
        Config::setValue('path', 'models', $_SERVER['DOCUMENT_ROOT'].'/market/models/');
        Config::setValue('path', 'layouts', $_SERVER['DOCUMENT_ROOT'].'/market/tpl/layouts/');
        Config::setValue('path', 'pages', $_SERVER['DOCUMENT_ROOT'].'/market/pages/');
        Config::setValue('path', 'tpl', $_SERVER['DOCUMENT_ROOT'].'/market/tpl/');
        Router::setRouteConfig('action', array(
            'index'=>'index','dish'=>'view'
        ));
    }
}