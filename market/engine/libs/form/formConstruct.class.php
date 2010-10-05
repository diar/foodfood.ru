<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 */

/** Класс для создания элементов формы
 *
 */
Class FormConstruct {

    /**
     * This form valid vars
     * @var array
     */
    public $data;
    
    /**
     * Название формы
     * @var string
     */
    protected $formName;

    /**
     * Метод формы
     * @var string
     */
    protected $_formMethod;

    /**
     * Form enctype
     * @var string
     */
    protected $_formEnctype;

    /**
     * Ошибки валидации
     * @var string
     */
    protected $_errors;

    /**
     * Inner form variables warehouse
     * @var array
     */
    protected $_fields;

    /**
     * This class directory
     * @var string
     */
    protected $_class_dir;

    /**
     * This form title
     * @var string
     */
    protected $_formCaption;

    /**
     * Allowed patterns
     * @var array
     */
    protected $_allowed_builders;

    /**
     * This POST or GET array
     * @var array
     */
    protected $_incVars;

    /**
     * Initializes Forms object
     * @return Form
     */
    public function __construct($caption,$css_id,$db_table) {

        $this->formName = 'Form';
        $this->data = array();
        $this->_formMethod = 'post';
        $this->_formEnctype = 'application/x-www-form-urlencoded';
        $this->_errors = '';

        $this->_fields = array();
        $this->_class_dir = dirname(__FILE__);
        $this->_formCaption = $caption;
        $this->_formID = $css_id;
        $this->_DBTable = $db_table;
        $this->_count = 0;
        $this->_allowed_builders = array(
                'text','eng_text','int',
                'hidden','int_hidden','email',
                'custom','confirm','textarea',
                'select','radio','delimiter',
                'file','date','checkbox','submit',
                'button','editor','phone','html', 'description'
        );
    }

    public function __get($key) {
        if (!isset($this->$key)) {
            throw new Exception('Фатальная ошибка. Скрипт обратился к несуществующей переменной Form::'.$key);
        }
        return $this->$key;
    }

    /**
     * Set form name
     * @param $name string Name attribute of the form
     */
    public function setFormName($name) {

        $this->formName = $name;
    }

    /**
     * Set form encrypte type
     * @param $enctype string type of encrypte
     */
    public function setFormEnctype($enctype) {
        if ($enctype == 'file') {
            $this->_formEnctype = 'multipart/form-data';
        }
        else {
            $this->_formEnctype = 'application/x-www-form-urlencoded';
        }
    }

    /**
     * Set form send method
     * @param $method string Type of method
     */
    public function setFormMethod($method) {

        if ($method == 'get') {
            $this->_formMethod = 'get';
        }
    }

    /**
     * Add new field to Form
     * @param $params array Additional params for building field
     */
    public function addField($params = null) {
        $this->_fields[] = $params;
    }

    /**
     * Validate fields of the form
     * @param $submit string Attribute name of submit button
     * @return if the form is valid
     */
    public function validateForm($submit,$item_id = 0 ) {

        if ($submit) {
            if ($this->_formMethod == 'get') {
                $this->_incVars = $_GET;
            }
            else {
                $this->_incVars = $_POST;
            }
            $validator = new FormValidator($this,$item_id);
            if ($validator->form_validate()) {
                $this->data = $validator->_vars;
                return true;
            }
            else {
                $this->_errors = $validator->_errors;
                return false;
            }
        }
    }

    /**
     * Build form
     */
    public function buildForm() {

        if ($this->_formMethod == 'get') {
            $this->_incVars = $_GET;
        }
        else {
            $this->_incVars = $_POST;
        }

        return new FormBuilder($this, $this->_errors);
         
    }
}
?>