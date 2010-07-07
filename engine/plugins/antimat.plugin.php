<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Плагин для реализации разделения по городам
 */
class AntimatPlugin {

    static $antimat=Array(
            'хуй','xуй','хyй','xyй','сука','cука','сукa','бля','хуя',
    );

    public static function check ($str) {
        return str_replace(self::$antimat, '***', $str);
    }
}