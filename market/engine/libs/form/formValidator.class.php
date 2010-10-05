<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 */

/** Класс для валидации формы
 *
 */
Class FormValidator {

    /**
     * Array of validation checks
     * @var array
     */
    public $is_valid;
    /**
     * Errors of validating
     * @var string
     */
    protected $_errors;
    /**
     * Basic config
     * @var array
     */
    private $_config;
    /**
     * Inner form variables warehouse
     * @var array
     */
    private $_fields;
    /**
     * This params of the form
     * @var array
     */
    private $_vars;

    /**
     * Initializes SFormsBuilder object
     */
    public function __construct($config, $item_id) {

        $this->_config = $config;
        $this->_fields = $config->_fields;
        $this->item_id = $item_id;
        $this->is_valid = array();
        $this->_vars = array();
        $this->_errors = '';
        $this->_incVars = $this->_config->_incVars;
    }

    public function __get($key) {
        if (!isset($this->$key)) {
            throw new Exception('Свойства ' . $key . ' класса formValidator не существует.');
        }
        return $this->$key;
    }

    /**
     * Form validating
     */
    public function form_validate() {
        // Удаляем не используемые при сохранении поля
        foreach ($this->_fields as $field) {
            if (!empty($field['pattern']) && (
                    $field['pattern'] == 'html' || $field['pattern'] == 'submit' ||
                    $field['pattern'] == 'confirm' || $field['pattern'] == 'description'
                    )) {
                if (!empty($field['name']) && !empty($_POST[$field['name']])) {
                    unset($_POST[$field['name']]);
                }
            }
        }
        foreach ($this->_fields as $field) {

            if ((!$field['pattern']) || ($field['pattern'] == 'hidden')
                    || ($field['pattern'] == 'textarea') || ($field['pattern'] == 'editor' )) {
                $field['pattern'] = 'text';
            }

            if ($field['pattern'] == 'int_hidden') {
                $field['pattern'] = 'int';
            }

            if (!$field['name']) {
                $field['name'] = $field['pattern'];
            }

            if (!in_array($field['pattern'], $this->_config->_allowed_builders)) {
                throw new Exception('Фатальная ошибка, паттерн ' . $field['pattern'] . ' не зарегистрирован, как существующий.');
            }
            $field_method_validator = 'field_' . $field['pattern'] . '_validate';
            $this->$field_method_validator($field);
        }

        if (in_array(false, $this->is_valid)) {
            return false;
        } else {
            return true;
        }
    }

    private function field_text_validate($field) {
        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (!empty($field['is_required']) && (!trim($value))) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } elseif (!empty($field['is_unique']) && (DB::getCount($this->_config->_DBTable, "$name = '$value' AND id != $this->item_id"))) {
            $this->_errors .= 'Поле <b>' . $field['caption'] . '</b> со значение <b>' . $value . '</b> уже существует в базе данных.</br>';
            $this->is_valid[] = false;
        } else {
            $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
            $this->is_valid[] = true;
        }
    }

    private function field_phone_validate($field) {

        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (!empty($field['is_required']) && $field['is_required'] == true && (!trim($value))) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } elseif (!empty($field['is_unique']) && $field['is_unique'] == true && (DB::getCount($this->_config->_DBTable, "$name = '$value' AND id != $this->item_id"))) {
            $this->_errors .= 'Поле <b>' . $field['caption'] . '</b> со значение <b>' . $value . '</b> уже существует в базе данных.</br>';
            $this->is_valid[] = false;
        } else {
            $value = preg_replace("/[^0-9\,]/", '', $value);
            $value = preg_replace("/\,[ ]*[7-8]/", ', +7', $value);
            $value = preg_replace("/^[7-8]/", '+7', $value);
            $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
            $this->is_valid[] = true;
        }
    }

    private function field_checkbox_validate($field) {

        $name = $field['name'];
        $value = !empty($this->_incVars[$name]) ? $this->_incVars[$name] : null;

        $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
        $this->is_valid[] = true;
    }

    private function field_eng_text_validate($field) {
        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (($field['is_required']) && (!trim($value))) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {
                $pattern = '|^[a-z]*s|i';
                if (!preg_match($pattern, $value)) {
                    $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> должно содержать только латинские символы.</br>';
                    $this->is_valid[] = false;
                } elseif ($field['is_unique'] && (DB::getCount($this->_config->_DBTable, "$name = '$value' AND id != $this->item_id"))) {
                    $this->_errors .= 'Поле <b>' . $field['caption'] . '</b> со значение <b>' . $value . '</b> уже существует в базе данных.</br>';
                    $this->is_valid[] = false;
                } else {
                    $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
                    $this->is_valid[] = true;
                }
            }
        }
    }

    private function field_int_validate($field) {
        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (($field['is_required']) && (!trim($value))) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {
                $pattern = '|^[-\d]*$|i';
                if (!preg_match($pattern, $value)) {
                    $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> должно содержать только цифры.</br>';
                    $this->is_valid[] = false;
                } else {
                    if (($field['min']) && ($value < $field['min'])) {
                        $this->_errors .= 'В поле <b>' . $field['caption'] . '</b> введено число меньше разрешенного.</br>';
                        $this->is_valid[] = false;
                        $err1 = true;
                    }
                    if (($field['max']) && ($value > $field['max'])) {
                        $this->_errors .= 'В поле <b>' . $field['caption'] . '</b> введено число больше разрешенного.</br>';
                        $this->is_valid[] = false;
                        $err2 = true;
                    }
                    if ((!$err1) && (!$err2))
                        $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
                    $this->is_valid[] = true;
                }
            }
        }
    }

    private function field_email_validate($field) {
        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (($field['is_required']) && (!trim($value))) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {
                $pattern = '#^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,6}$#i';
                if (!preg_match($pattern, $value)) {
                    $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> имеет неправильный формат.</br>';
                    $this->is_valid[] = false;
                } elseif ($field['is_unique'] && (DB::getCount($this->_config->_DBTable, "$name = '$value' AND id != $this->item_id"))) {
                    $this->_errors .= 'Поле <b>' . $field['caption'] . '</b> со значение <b>' . $value . '</b> уже существует в базе данных.</br>';
                    $this->is_valid[] = false;
                } else {
                    $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
                    $this->is_valid[] = true;
                }
            }
        }
    }

    private function field_custom_validate($field) {
        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (($field['is_required']) && (!trim($value))) {

            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {
                if (!$field['preg']) {
                    throw new Exeption('Полю типа custom не передан обязательный параметр preg - регулярное выражение');
                }
                if (!preg_match($field['preg'], $value)) {

                    if ($field['error']) {
                        $err = $field['error'];
                    } else {
                        $err = 'Обязательное поле <b>' . $field['caption'] . '</b> имеет неправильный формат.</br>';
                    }

                    $this->_errors .= $err;
                    $this->is_valid[] = false;
                } else {
                    $this->_vars["$name"] = htmlentities($value, ENT_QUOTES);
                    $this->is_valid[] = true;
                }
            } else {
                $this->is_valid[] = true;
            }
        }
    }

    private function field_confirm_validate($field) {

        if (!$field['name1']) {
            $field['name1'] = 'confirm';
        }

        if (!$field['name2']) {
            $field['name2'] = 'confirm';
        }

        $name1 = $field['name1'];
        $name2 = $field['name2'];
        $value1 = $this->_incVars[$name1];
        $value2 = $this->_incVars[$name2];

        if (!trim($value1)) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption1'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if ($field['type'] == 'email') {
                $pattern = '#^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,6}$#i';
                if (!preg_match($pattern, $value1)) {
                    $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> имеет неправильный формат.</br>';
                    $this->is_valid[] = false;
                    $err1 = true;
                }
            }
        }

        if (!trim($value2)) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption2'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if ($field['type'] == 'email') {
                $pattern = '#^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,6}$#i';
                if (!preg_match($pattern, $value2)) {
                    $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> имеет неправильный формат.</br>';
                    $this->is_valid[] = false;
                    $err2 = true;
                }
            }
        }

        if ($value1 != $value2) {
            $this->_errors .= 'Поля <b>' . $field['caption1'] . '</b> и <b>' . $field['caption2'] . '</b> не равны.</br>';
            $this->is_valid[] = false;
        } elseif ((!$err1) && (!$err2)) {
            $this->_vars[$name1] = htmlentities($value1, ENT_QUOTES);
            $this->_vars[$name2] = htmlentities($value2, ENT_QUOTES);
            $this->is_valid[] = true;
        } else {
            $this->is_valid[] = false;
        }
    }

    private function field_file_validate($field) {

        $name = $field['name'];
        $value = $_FILES[$name]['name'];
        $dir = !empty($field['dir']) ? $field['dir'] : "";
        if (!empty($field['is_required']) && ($field['is_required']) && ($_FILES[$name]['error'] == 4)) {
            $this->_errors .= 'В обязательное поле <b>' . $field['caption'] . '</b> не был загружен файл.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {
                if (($value) && ($_FILES["$name"]['error'] >= 1)) {
                    $this->_errors .= 'Файл в поле <b>' . $field['caption'] . '</b> был загружен с ошибкой.</br>';
                    $this->is_valid[] = false;
                } else {
                    $extentions = array("#\.php#is",
                        "#\.phtml#is",
                        "#\.php3#is",
                        "#\.html#is",
                        "#\.htm#is",
                        "#\.hta#is",
                        "#\.pl#is",
                        "#\.xml#is",
                        "#\.inc#is",
                        "#\.shtml#is",
                        "#\.xht#is",
                        "#\.xhtml#is",
                        "#\.bin#is"
                    );

                    $value = $this->encodestring($value);
                    $path_parts = pathinfo($value);
                    $ext = $path_parts['extension'];
                    if (!in_array($ext, $field['formats'])) {

                        $this->_errors .= 'Вы загрузили файл с запрещенным расширением';
                        $this->is_valid[] = false;
                    }
                }
            }
        }
    }

    private function field_select_validate($field) {
        $name = $field['name'];
        $value = $this->_incVars[$name];
        if (!empty($field['is_required']) && (!trim($value))) {
            $this->_errors .= 'Обязательный пункт поля <b>' . $field['caption'] . '</b> не выбран.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {
                if (!array_key_exists($value, $field['options'])) {
                    $this->_errors .= 'Переданного значения <b>' . $field['name'] . '</b> в поле типа select не существует.</br>';
                    $this->is_valid[] = false;
                } else {
                    $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
                    $this->is_valid[] = true;
                }
            } else {
                $this->is_valid[] = true;
            }
        }
    }

    public function field_radio_validate($field) {

        $name = $field['name'];
        $value = $this->_incVars[$name];

        if (($field['is_required']) && (!trim($value))) {
            $this->_errors .= 'Обязательное поле <b>' . $field['caption'] . '</b> не заполнено.</br>';
            $this->is_valid[] = false;
        } else {
            if (trim($value)) {

                foreach ($field['options'] as $radio) {
                    $values[] = $radio['value'];
                }
                if (!in_array($value, $values)) {
                    $this->_errors .= 'Вы передали значение <b>' . $value . '</b>, которого не было в поле типа select.</br>';
                    $this->is_valid[] = false;
                } else {
                    $this->_vars[$name] = htmlentities($value, ENT_QUOTES);
                    $this->is_valid[] = true;
                }
            }
        }
    }

    public function field_date_validate($field) {

        $dayname = $field['day_name'];
        $dayvalue = $this->_incVars[$dayname];

        $mounthname = $field['mounth_name'];
        $mounthvalue = $this->_incVars[$mounthname];

        $yearname = $field['year_name'];
        $yearvalue = $this->_incVars[$yearname];

        if ((!$field['from_year']) || (!is_numeric($field['from_year']))) {
            $field['from_year'] = 1900;
        }

        if ((!$field['until_year']) || (!is_numeric($field['until_year']))) {
            $field['until_year'] = 2010;
        }

        if ($field['from_year'] > $field['until_year']) {

            $from = $field['from_year'];
            $until = $field['until_year'];

            $field['until_year'] = $from;
            $field['from_year'] = $until;
        }

        if ((!trim($dayvalue)) || (!trim($mounthvalue)) || (!trim($yearvalue))) {
            $this->_errors .= 'Обязательный пункт поля <b>' . $field['caption'] . '</b> не выбран.</br>';
            $this->is_valid[] = false;
        } else {
            if ((($dayvalue >= 1) && ($dayvalue <= 31)) && (($mounthvalue >= 1) && ($mounthvalue <= 12)) && (($yearvalue >= $field['from_year']) && ($yearvalue <= $field['until_year']))) {
                $this->is_valid[] = true;
                $this->_vars[$dayname] = htmlentities($dayvalue, ENT_QUOTES);
                $this->_vars[$mounthname] = htmlentities($mounthvalue, ENT_QUOTES);
                $this->_vars[$yearname] = htmlentities($yearvalue, ENT_QUOTES);
            } else {
                $this->_errors .= 'В поле <b>' . $field['caption'] . ' выбрано значение, которого не предлагалось.</b></br>';
                $this->is_valid[] = false;
            }
        }
    }

    private function field_delimiter_validate() {
        return '';
    }

    private function field_description_validate() {
        return '';
    }

    private function field_submit_validate() {
        return '';
    }

    private function field_html_validate() {
        return '';
    }

    private function field_button_validate() {
        return '';
    }

    private function encodestring($string) {
        $string = strtr($string, "абвгдеёзийклмнопрстуфхъыэ_", "abvgdeeziyklmnoprstufh'iei");
        $string = strtr($string, "АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_", "ABVGDEEZIYKLMNOPRSTUFH'IEI");
        $string = strtr($string, array('ж' => 'zh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh',
                    'щ' => 'shch', 'ь' => '', 'ю' => 'yu', 'я' => 'ya',
                    'Ж' => 'ZH', 'Ц' => 'TS', 'Ч' => 'CH', 'Ш' => 'SH',
                    'Щ' => 'SHCH', 'Ь' => '', 'Ю' => 'YU', 'Я' => 'YA',
                    'ї' => 'i', 'Ї' => 'Yi', 'є' => 'ie', 'Є' => 'Ye'
                        )
        );
        return $string;
    }

}
?>