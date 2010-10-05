<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Главная страница, по умолчанию действие Index
 */
class product_Page extends View {
    /*
     * Инициализация контроллера
     */

    public static function initController($action) {
       
        

    }

    /*
     * Страница продукта
     */
    public static function viewAction($id) {
        Debug::dump($_SESSION);
        
        self::$page['header']['content'] = MD_Menu::getProduct();
        self::showXSLT('pages/view/index');
    }

    /*
     * Вывод формы оформление заказа
     */

    public static function listAction($id) {
       
        $type = Router::GetRouteIndex(3);
        $parent_id = null;
        $param = null;
        switch ($type) {
            case 'category':
                $parent_id = Router::GetRouteIndex(4);
                break;
            case 'sale':
                $param = 'sale';
                break;
            case 'new':
                $param = 'new';
                break;
            default :
                $param = 'null';
        }

        // Показываем страницу

        self::$page['header']['content']['products'] = MD_Menu::getProducts($parent_id,$param);
        self::showXSLT('pages/index/index');
    }


    /*
     * Добавление в корзину
     */
    public static function trashAddAjaxAction() {
        $item_id = $_POST['item_id'];
        $title = $_POST['title'];
        $size = $_POST['size'];
        $count = $_POST['count'];
        $price = $_POST['price'];
        $is_present = !empty($_POST['is_present']) ? 1 : 0;
        $trash = $_SESSION['trash'];
        if (!empty ($trash)) {
            foreach ($_SESSION['trash'] as &$item) {
            if ($item_id == $item['item_id'] && $size == $item['size']) {
                $item['count'] = $count;
                $item['is_present'] = $is_present;
                echo 'OK';
                return true;
            }
            }

        } else {
            $_SESSION['trash'] = array();
        }
        
        $_SESSION['trash'][count($_SESSION['trash'])] = array(
            'item_id'=>$item_id,
            'title'=>$title,
            'size'=>$size,
            'count'=>$count,
            'price'=>$price,
            'is_present' => $is_present
        );

            //Debug::dump($_SESSION);
    }

}
