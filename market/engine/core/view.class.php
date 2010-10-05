<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для управления отображением
 */
class View {

    /**
     * Массив переменных вида
     * @var Array
     */
    private static $_vars = Array();
    /**
     * Массив переменных xslt
     * @var Array
     */
    protected static $page = Array();
    /**
     * Класс для работы с xml
     * @var XMLWriter
     */
    protected static $writer;

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule() {
        Event::addListener('Error', 'PAGENOTFOUND', 'View', 'showError');
        self::$writer = new XMLWriter();
        if (Config::getValue('site', 'disabled')) {
            if (empty($_SESSION['admin']['access']) || $_SESSION['admin']['access'] != 'superadmin') {
                self::showPage('error', 'disabled');
                die();
            }
        }
    }

    /**
     * Инициализация отображения
     * @return null
     */
    public static function initView() {
        //Переменные роутера
        self::$page['route'] = Array(
            'page' => Router::getRouteParam('page'),
            'action' => Router::getRouteParam('action')
        );
        self::$page['site'] = Config::getSection('site');
        // Получение настроек меню
        //получение дерева
        mysql_connect('localhost', 'root', '150878');
        mysql_select_db('foodfood');
        $tree = MD_Market::getTree();
        mysql_close();

        // Формируем описание корзины
        $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : null;
        if (sizeof($trash) > 0) {
            $gen_price = 0;
            foreach ($trash AS $item) {
                $gen_price+=$item['price'] * $item['count'];
            }
        } else $gen_count = 0;

        // Показываем страницу
        self::$page['trash']['price'] = $gen_price;
        self::$page['header']['tree'] = $tree;
        self::$page['user'] = User::getParams();
        self::$page['user']['message_count'] = MD_User::getMessageCount();
        self::$page['date_today']['year'] = String::getDate();
        self::$page['date_today']['month'] = String::toMonth(date('m'));
        self::$page['date_today']['month_number'] = date('m');
        self::$page['date_today']['day'] = date('d');
        self::$page['date_today']['week'] = String::toWeek(date('w'));
        self::$page['date_tomorrow']['month'] = String::toMonth(date('m', time() + 60 * 60 * 24));
        self::$page['date_tomorrow']['day'] = date('d', time() + 60 * 60 * 24);
        self::$page['date_tomorrow']['week'] = String::toWeek(date('w', time() + 60 * 60 * 24));
    }

    /**
     * Отображение страницы
     * @return bool
     */
    public static function showPage($page=null, $action=null, $id=null) {
        if (empty($page))
            $page = Router::getRouteParam('page');
        if (empty($action))
            $action = Router::getRouteParam('action');
        if (empty($id))
            $id = Router::getRouteParam('id');
        if (preg_match("/^[[:lower:]]+$/", $page)) {
            if (file_exists(Config::getValue('path', 'pages') . $page . '.php')) {
                include_once (Config::getValue('path', 'pages') . $page . '.php');
                self::initView();
                $pageClass = $page . '_Page';
                if (file_exists(Config::getValue('path', 'pages') . 'app.php')) {
                    include_once (Config::getValue('path', 'pages') . 'app.php');
                    if (method_exists('App', 'init'))
                        call_user_func(array('App', 'init'), $pageClass);
                }
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                    if (method_exists($pageClass, $action . 'AjaxAction'))
                        call_user_func(array($pageClass, $action . 'AjaxAction'), $id);
                    return true;
                } elseif (method_exists($pageClass, $action . 'Action')) {
                    if (method_exists($pageClass, 'initController')) {
                        call_user_func(array($pageClass, 'initController'), $action);
                    }
                    call_user_func(array($pageClass, $action . 'Action'), $id);
                    return true;
                } elseif (method_exists($pageClass, Router::getRouteConfig('action', $page) . 'Action') or
                        method_exists($pageClass, Router::getRouteConfig('action', $page) . 'AjaxAction')) {
                    $id = $action;
                    $action = Router::getRouteConfig('action', $page);
                    self::showPage($page, $action, $id);
                    return true;
                }
            } elseif (file_exists(Config::getValue('path', 'pages') . Config::getValue('route', 'default_page') . '.php')) {
                $default = Config::getValue('route', 'default_page');
                include_once (Config::getValue('path', 'pages') . $default . '.php');
                $id = $action;
                $action = $page;
                $page = $default;
                if (method_exists($page . '_Page', $action . 'AjaxAction') or
                        method_exists($page . '_Page', $action . 'Action')) {
                    self::showPage($page, $action, $id);
                    return true;
                }
            }
        }
        Error::setError('PAGENOTFOUND', $page);
        return false;
    }

    /**
     * Отображение ошибки
     * @return null
     */
    public static function showError() {
        header("HTTP/1.0 404 Not Found");
        self::showPage('error', 'index');
        die();
    }

    /**
     * Перевод массива в XML
     * @param array $array массив
     * @return string
     */
    public static function arrayToXml($data) {
        self::$writer->openMemory();
        self::$writer->startDocument('1.0', 'UTF-8');
        self::$writer->startElement('root');
        if (is_array($data)) {
            self::getXML($data);
        }
        self::$writer->endElement();
        return self::$writer->outputMemory();
    }

    private static function getXML($data) {
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $key = 'item';
            }
            if (is_array($val)) {
                self::$writer->startElement($key);
                self::getXML($val);
                self::$writer->endElement();
            } else {
                self::$writer->writeElement($key, $val);
            }
        }
    }

    /**
     * Получение конечного html
     * @param string $xml строка XML
     * @param string $tpl название файла XSLT
     * @return string
     */
    public static function getXSLT($array, $tpl) {
        $doc = new DOMDocument();
        $xml = self::arrayToXml($array);
        $doc->loadXML($xml);
        $xsl = new DomDocument();
        $xsl->load(Config::getValue('path', 'tpl') . $tpl . '.xsl');

        $proc = new XsltProcessor();
        $xsl = $proc->importStylesheet($xsl);
        return $proc->transformToXML($doc);
    }

    /**
     * Вывод конечного html
     * @param string $tpl название файла XSLT
     * @return null
     */
    public static function showXSLT($tpl) {
        echo self::getXSLT(self::$page, $tpl);
    }

    /**
     * Получить переменную
     * @param string $name название переменной
     * @return var
     */
    public static function get($name) {
        if (!empty(self::$_vars[$name]))
            return self::$_vars[$name];
        else
            return NULL;
    }

    /**
     * Задать переменную
     * @param string $name название переменной
     * @param string $value значение переменной
     * @return null
     */
    public static function assign($name, $value) {
        self::$_vars[$name] = $value;
    }

    /**
     * Отобразить страницу
     * @param string $template название макета
     * @return null
     */
    public static function display($template = 'layout.tpl') {
        include_once(Config::getValue('path', 'layouts') . $template . '.php');
    }

}