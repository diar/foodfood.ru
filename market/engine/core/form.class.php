<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с формами
 */
class Form {

    /** Инициализация модуля
     * @return null
     */
    public static function initModule () {
        require_once (Config::getValue('path','libs').'form/formConstruct.class.php');
        require_once (Config::getValue('path','libs').'form/formBuilder.class.php');
        require_once (Config::getValue('path','libs').'form/formValidator.class.php');
    }

    /** Создание новой формы
     * @param string $caption Заголовок формы
     * @return FormConstruct
     */
    public static function newForm ($caption = "Новая форма", $css_id = "formID",$db_table = null) {
        return new FormConstruct ($caption,$css_id,$db_table);
    }


    public static function array_combine ($array) {
        if (empty($array)) return array();
        $return = array();
        $keys = array();
        $values = array();
        $arrayKey = array_keys($array[0]);


        foreach ($array as $var) {

            array_push($keys,$var[$arrayKey[0]]);
            array_push($values,$var[$arrayKey[1]]);
        }

        $return = array_combine($keys,$values);
        return $return;
    }



    /**
     * Перевод массива в json, для таблицы jqGrid
     * @param array $array массив элементов
     * @param integer $pageCount количество страниц
     * @param integer $pageCurrent текущая страница
     * @param integer $itemCount количество элементов всего
     * @return string
     */
    public static function arrayToJqGrid ($array,$pageCount,$pageCurrent,$itemCount) {
        $response['page'] = $pageCurrent;
        $response['total'] = $pageCount;
        $response['records'] = $itemCount;
        $i = 0;
        foreach ($array as $rows) {
            $response['rows'][$i]['id']=$rows['id'];
            foreach ($rows as $row) {
                $response['rows'][$i]['cell'][]=$row;
            }
            $i++;
        }
        return json_encode($response);
    }

    /**
     * Показать таблицу jqGrid
     * @param array $params массив параметров ['table','pager','width','height','url']
     * @param array $items массив элементов [{'title=>'',''name'=>'','id'=>'','width'=>''}]
     * @return string
     */
    public static function showJqGrid ($params,$items) {
        foreach ($items as $item) {
            $rows=array();
            foreach ($item as $param=>$value) {
                if ($param=='title') $titles[]='"'.$value.'"';
                else $rows[]=$param.':"'.$value.'"';
            }
            $cols[]='{'.implode(',',$rows).'}';
        }
        $title=implode(',',$titles);
        $colModel=implode(',',$cols);
        $result=
                '<script type="text/javascript">
            $(document).ready(function() {
                jQuery("#'.$params['table'].'").jqGrid({
	            url:"'.$params['url'].'",
	            datatype: "json",
	            mtype: "POST",
	            colNames:['.$title.'],
	            colModel :[
                        '.$colModel.'
	            ],
	            pager: jQuery("#'.$params['pager'].'"),
	            rowNum:600,
	            rowList:[10,50,100,300,600],
	            sortname: "id",
	            sortorder: "desc",
	            viewrecords: true,
	            height : '.$params['height'].',
	            width : '.$params['width'].'
	        });
            });
            </script>
            <table id="'.$params['table'].'"></table>
            <div id="'.$params['pager'].'"> </div>';
        return $result;
    }
}