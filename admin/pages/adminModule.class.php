<?php

class AdminModule {

    /**
     * Таблица БД
     * @var string
     */
    protected static $_DB_table;
    /**
     * Заголовок страницы
     * @var string
     */
    protected static $_title = "Главная";
    /**
     * Id ресторана, с которым идет работа
     * @var string
     */
    protected static $_restId;
    /**
     * Уровни доступа к методам
     * @var array
     */
    protected static $_actions = array(
        'showList' => array(
            'title' => 'Список',
            'level' => 1,
            'onMenu' => false
        ),
        'showJSON' => array(
            'title' => 'Список json',
            'level' => 1,
            'onMenu' => false
        ),
        'add' => array(
            'title' => 'Добавить',
            'level' => 5,
            'onMenu' => false
        ),
        'edit' => array(
            'title' => 'Редактировать',
            'level' => 3,
            'onMenu' => false
        ),
        'delete' => array(
            'title' => 'Удалить',
            'level' => 7,
            'onMenu' => false
        )
    );

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule() {
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    /**
     * Добавление контента
     * @return null
     */
    public static function add() {

        $form = Form::newForm('Форма234234', 'asdasdad');

        $form->addfield(array('name' => 'title',
            'caption' => 'Заголовок',
            'pattern' => 'text',
            'maxlength' => '32',
            'size' => '20',
            'help' => 'любые символы',
            'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'text',
            'caption' => 'Текст',
            'pattern' => 'textarea',
            'css_id' => 'text',
            'css_class' => 'textarea',
            'disabled' => false,
            'readonly' => false,
            'is_required' => false)
        );

        $form->addfield(array('name' => 'submit',
            'caption' => 'Сохранить',
            'pattern' => 'submit')
        );

        if ($form->validateForm($_POST['submit'])) {
            self::save();
        }

        //Показ формы
        $html = $form->buildForm();
        self::showTemplate($html);
    }

    /**
     * Редактирование контента
     * @return null
     */
    public static function edit() {

        $form = Form::newForm();

        $form->addfield(array('name' => 'title',
            'caption' => 'Заголовок',
            'pattern' => 'text',
            'value' => 'Это сохранённый текст',
            'maxlength' => '32',
            'size' => '20',
            'is_required' => true,
            'css_class' => 'caption')
        );
        $form->addfield(array('name' => 'editor1',
            'caption' => 'Текст',
            'pattern' => 'editor',
            'value' => 'Это сохранённый текст',
            'css_id' => 'editor1',
            'css_class' => 'ckeditor',
            'disabled' => false,
            'readonly' => false,
            'is_required' => true)
        );

        $form->addfield(array('name' => 'submit',
            'caption' => 'Сохранить',
            'pattern' => 'submit')
        );

        $form->addfield(array('name' => 'apply',
            'caption' => 'Применить',
            'css_id' => 'apply',
            'pattern' => 'submit',
                )
        );

        self::validate($form);
    }

    /**
     * Сохранение контента без перезагрузки
     * @return null
     */
    public static function apply() {
        $data = $_POST;
        DB::insert('test', $data);
    }

    /**
     * Сохранение контента
     * @return null
     */
    public static function save() {
        $data = $_POST;
        DB::insert(DB_PAGE_TABLE, $data);
    }

    /**
     * Сохраняет отредактированный элемент
     */
    public static function saveEdit() {
        self::save();
    }

    /*
     * Удаление контента
     */

    public static function delete() {
        $id = intval($_GET['id']);
        DB::delete(self::getDbTable(), "id='$id'");
        header("location: " . $_SERVER['HTTP_REFERER']);
    }

    /**
     * Отбражение списка
     */
    public static function showList() {
        self::showTemplate();
    }

    /**
     * Валидация формы и ответ в зависимости от запроса
     * @param object $form Объект созданной формы, которую необходимо проверить на валидность.
     * @return HTML
     */
    public static function validate($form, $item_id = 0, $update = false, $text_html='') {
        $page = PAGE;
        //Если нажали кнопку применить
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            if ($form->validateForm($_POST, $item_id)) {
                $page::apply();
            }
            //Выводим ошибки.
            echo $form->_errors;
            //Вызывает saveEdit если update
        } elseif ($update) {
            if (!empty($_POST['edit']) && $form->validateForm($_POST['edit'], $item_id)) {
                $page::saveEdit();
            }
            $html = $form->buildForm();
            self::showTemplate($text_html . $html);
            //Иначе работаем через обычный интерфейс сохранения
        } else {

            if (!empty($_POST['submit']) && $form->validateForm($_POST['submit'])) {
                $page::save();
            }

            //Отображение формы
            $html = $form->buildForm();
            self::showTemplate($text_html . $html);
        }
    }

    /**
     * Запускает нужный экшен, проверя доступ
     */
    protected static function start() {

        if (self::checkAccessToAction(PAGE, ACTION)) {
            call_user_func(array(PAGE, ACTION));
        }
        else
            die(trigger_error('ACCESS DENIED'));
    }

    /**
     * Проверка наличия прав доступа к действию
     */
    private static function checkAccessToAction($page, $action=null) {
        //если суперадмин то открываем доступ
        if ($_SESSION['admin']['access'] == 'superadmin')
            return true;
        //Проверка на доступ данной страницы
        if (array_key_exists($page, $_SESSION['admin']['access']))
            $pageAllow = true; else
            return false;
        //Проверка на доступ к действию
        if (!empty($action)) {
            $actions = $page::getActions();

            if (!empty($_SESSION['admin']['access'][$page])) {
                if ($_SESSION['admin']['access'][$page] >= $actions[$action]['level'])
                    $actionAllow = true;
            }
            else
                return false;

            if ($pageAllow AND $actionAllow)
                return true; else
                return false;
        }
        return true;
    }

    /**
     * Проверка элемента на доступность
     * @param string $table Таблица БД, в которой находится элемент
     * @param int $id ID элемента в БД
     * @param string $checkAction проверка на доступность запрошенного действие с этим элементом, если проверка не нужна False
     * @return bool
     */
    private static function checkAccessToElement($table, $id) {
        //Если супер-админ, то можно всё!
        if ($_SESSION['admin']['access'] == 'superadmin')
            return true;

        $element = DBP::getRecord($table, 'id=' . $id);

        //Проверка на занятость элемента.
        if ($element['edit_blocked'])
            return false;

        //Проверка на последнего редактора элемента
        if ($element['edit_last_editor'] != $_SESSION['admin']['id'])
            return false;

        //Если дошли до этого кода, значит все проверки пройдены и отдаём пользователю доступ к этому элементу.
        return true;
    }

    /**
     * Добавляет информацию по действиям, либо изменияет если такая запись уже есть
     * @param string $methodName название метода
     * @param string $title название метода для отображение в меню
     * @param int $accessLevel уровень доступа к действию
     * @param bool $onMenu показывать ссылку на действие в меню страницы или нет
     */
    public static function addAction($methodName, $title, $accessLevel, $onMenu=false) {
        $action = array(
            'title' => $title,
            'level' => $accessLevel,
            'onMenu' => $onMenu
        );
        self::$_actions[$methodName] = $action;
    }

    public static function removeAction($methodName) {
        unset(static::$_actions[$methodName]);
    }

    public static function getLink($page, $action=null, $id=null) {
        $link = $_SERVER['SCRIPT_NAME'] . "?page=$page";
        if (!empty($action))
            $link .= "&action=$action";
        if (!empty($id))
            $link .= "&id=$id";

        return $link;
    }

    public static function getAdminMenu() {
        $records = DB::getRecords('admin_menu', 'parent_id = 0', 'id');
        $menus = Array();
        foreach ($records as &$record) {
            if (self::checkAccessToAction($record['page']) &&
                    DB::getCount('admin_menu', 'parent_id=' . $record['id']) > 0) {
                $menu = $record;
                $childs = DB::getRecords('admin_menu', 'parent_id=' . $record['id']);
                $z = 0;
                foreach ($childs as $child) {
                    if (self::checkAccessToAction($child['page'])) {
                        $menu['childs'][$z] = $child;
                        $z++;
                    }
                }
                $menus[] = $menu;
            }
        }
        return $menus;
    }

    public static function showTemplate($html=null) {
        $actionsInfo = self::getActions();
        $rest_list = DBP::getRecords('rest', 'is_hidden=0', 'rest_title');
        foreach ($rest_list as &$rest) {
            preg_match('/^(.*?)\,/', $rest['rest_address'], $rest_address);
            if (!empty($rest_address[1]))
                $rest['rest_address'] = $rest_address[1];
        }
        $pageMenu = array();
        $actions = array_keys($actionsInfo);
        $menu = self::getAdminMenu();
        foreach ($actions as $item) {
            if ($actionsInfo[$item]['onMenu']) {
                $arr = array($item => $actionsInfo[$item]['title']);
                $pageMenu = array_merge($pageMenu, $arr);
            }
        }

        View::assign('pageTitle', self::getTitle());
        View::assign('menu', $menu);
        View::assign('admin', $_SESSION['admin']);
        View::assign('pageMenu', $pageMenu);
        View::assign('rest_list', $rest_list);
        View::assign('html', $html);
        View::display('admin.tpl');
    }

    public static function getActions() {
        return isset(static::$_actions) ? static::$_actions : self::$_actions;
    }

    public static function getDbTable() {
        return isset(static::$_DB_table) ? static::$_DB_table : self::$_DB_table;
    }

    public static function getTitle() {
        return isset(static::$_title) ? static::$_title : self::$_title;
    }

    public static function setActions($param) {
        static::$_actions = $param;
    }

    public static function setDbTable($param) {
        static::$_DB_table = $param;
    }

    public static function setTitle($param) {
        static::$_title = $param;
    }

    public static function getRestId() {
        return isset(static::$_restId) ? static::$_restId : self::$_restId;
    }

    public static function setRestId($param) {
        static::$_restId = $param;
    }

}