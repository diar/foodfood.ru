<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 */

/** Класс для создания древа
 *
 */
class NestedSets {

     /**
     * Текущий html дерева
     * @var string
     */
    private $_html;

   
    public function __construct($array) {

        $this->_data = $array;
        $this->_html ='';
        self::getTree($this->_data);
    }

    public function __toString() {
        return $this->_html;
    }

    /**
     * Build and return tree HTML
     */

    public static function getTree ($data) {
        $count = count($data);
        for ($i = 0;$i <= $count;$i++) {
            foreach($data[$i] as $k => $v) {
                echo $k."=>".$v."<br />";
            }
        }
    }
}