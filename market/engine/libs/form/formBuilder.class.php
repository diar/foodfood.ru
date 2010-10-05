<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 */

/** Класс для создания формы
 *
 */
class FormBuilder {

    /**
     * Форма html
     * @var string
     */
    private $_form;
    /**
     * JavaScript
     */
    private $_script;
    /**
     * Готовый html
     * @var string
     */
    private $_html;
    /**
     * Конфигурация
     * @param array
     */
    private $_config;
    /**
     * Ошибки валидации
     * @param string
     */
    private $_errors;
    /**
     * Inner form variables warehouse
     * @var array
     */
    private $_fields;
    /**
     * Массив POST и GET
     * @var array
     */
    protected $_incVars;

    /**
     * Инициализация класса
     * @param array $config Basic config
     * @param array $errors Errors of validating form
     */
    public function __construct($config, $errors) {

        $this->_form = '';
        $this->_config = $config;
        $this->_errors = $errors;
        $this->_fields = $this->_config->_fields;
        $this->_incVars = $this->_config->_incVars;
        $this->buildForm();
    }

    public function __toString() {

        return $this->_html;
    }

    /**
     * Build and return form HTML
     */
    public function buildForm() {

        foreach ($this->_fields as $field_key=>$field) {

            if ((!$field['pattern']) || ($field['pattern'] == 'email') || ($field['pattern'] == 'int') || ($field['pattern'] == 'custom') || ($field['pattern'] == 'eng_text')) {
                $field['pattern'] = 'text';
            } elseif ($field['pattern'] == 'int_hidden') {
                $field['pattern'] = 'hidden';
            }

            if (!in_array($field['pattern'], $this->_config->_allowed_builders)) {
                throw new Exception('Фатальная ошибка, паттерн ' . $field['pattern'] . ' не зарегистрирован, как существующий.');
            }

            if (empty($field['name'])) {
                $field['name'] = $field['pattern'];
            }
            !empty($field['css_id']) ? $field['css_id'] = 'id="' . $field['css_id'] . '"' : $field['css_id'] = '';

            !empty($field['css_class']) ? $field['css_class'] = 'class="' . $field['css_class'] . '"' : $field['css_class'] = '';

            if (!empty($field['is_required']) && !empty($field['caption'])) {
                $field['caption'] .= '*';
            }
            if (!empty($field['is_unique']) && !empty($field['caption'])) {
                $field['caption'] = "<span class='unique'>$field[caption]</span>";
            }

            if (!empty($field['pattern']) and $field['pattern'] == 'file') {
                $this->_config->setFormEnctype('file');
            }

            $field_method_builder = 'field_' . $field['pattern'] . '_build';
            if (empty($field['superadmin']) || !$field['superadmin'] ||
                    ($field['superadmin'] && !empty($_SESSION['admin']['access']) &&
                    $_SESSION['admin']['access'] == 'superadmin')) {
                $this->$field_method_builder($field);
            } else {
                unset ($this->_fields[$field_key]);
            }
        }
        $this->_html = "";
        if ($this->_errors) {
            $errors = '<b>Ошибки:</b><br>' . $this->_errors;
            $this->_html .= "<div id='formError'>$errors</div>";
        }

        $this->_html .= '<form name="' . $this->_config->formName . '" method="' . $this->_config->_formMethod . '" enctype="' . $this->_config->_formEnctype . '" id="' . $this->_config->_formID . '"><table>';
        $this->_html .= $this->_form;
        $this->_html .= '</table></form>';
        if ($this->_script) {
            $this->_html .= '<script>' . $this->_script . '</script>';
        }
    }

    public function field_text_build($field) {

        $name = $field['name'];
        if (!empty($this->_incVars[$name]))
            $value = $this->_incVars[$name];
        elseif (!empty($field['value']))
            $value = $field['value'];
        else
            $value = '';

        $fieldid = $name . 'field';

        if (!empty($field['maxlength'])) {
            $maxlength = ' maxlength="' . $field['maxlength'] . '" ';
        }

        if (!empty($field['size'])) {
            $size = ' size="' . $field['size'] . '" ';
        }

        if (!empty($field['type']) and $field['type'] == 'password') {
            $type = 'password';
        } else {
            $type = 'text';
        }
        if (!empty($field['help'])) {
            $this->_script .= 'if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\';}';
            $onfocus = 'onfocus="document.getElementById(\'' . $fieldid . '\').value = \'\';"';
            $onblur = 'onblur="if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\';}"';
        } else {
            $onfocus = '';
            $onblur = '';
        }
        $size = !empty($size) ? $size : "";

        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><input type="' . $type . '" name="' . $field['name'] . '" value="' . htmlspecialchars($value) . '" id="' . $fieldid . '" ' . $onfocus . ' ' . $onblur . ' ' . $maxlength . $size . '></td></tr>';
    }

    public function field_phone_build($field) {

        $name = $field['name'];
        if (!empty($this->_incVars[$name]))
            $value = $this->_incVars[$name];
        elseif (!empty($field['value']))
            $value = $field['value'];
        else
            $value = '';

        $fieldid = $name . 'field';

        if (!empty($field['maxlength'])) {
            $maxlength = ' maxlength="' . $field['maxlength'] . '" ';
        }

        if (!empty($field['size'])) {
            $size = ' size="' . $field['size'] . '" ';
        } else
            $size = "";

        if (!empty($field['type']) and $field['type'] == 'password') {
            $type = 'password';
        } else {
            $type = 'text';
        }
        if (!empty($field['help'])) {
            $this->_script .= 'if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\';}';
            $onfocus = 'onfocus="document.getElementById(\'' . $fieldid . '\').value = \'\';"';
            $onblur = 'onblur="if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\';}"';
        } else {
            $onfocus = '';
            $onblur = '';
        }

        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><input type="' . $type . '" name="' . $field['name'] . '" value="' . $value . '" id="' . $fieldid . '" ' . $onfocus . ' ' . $onblur . ' ' . $maxlength . $size . '></td></tr>';
    }

    public function field_hidden_build($field) {
        $value = $field['value'];
        $this->_form.= '<tr style="display:none"><td></td><td><input type="hidden" ' . $field['css_class'] . ' name="' . $field['name'] . '" value="' . $value . '"></td></tr>';
    }

    public function field_html_build($field) {
        $value = $field['value'];
        $this->_form.= '<tr><td>' . $field['caption'] . '</td><td style="padding:10px 0;">' . $value . '</td></tr>';
    }

    public function field_description_build($field) {
        $value = $field['value'];
        $this->_form.= '<tr><td></td><td style="padding:4px 0 8px 0;font-size:10px;color:#555;">'.$value.'</td></tr>';
    }

    public function field_confirm_build($field) {

        $name1 = $field['name1'];
        $fieldid1 = $name1 . 'field';

        $name2 = $field['name2'];
        $fieldid2 = $name2 . 'field';

        if (empty($field['name1'])) {
            $field['name1'] = 'confirm';
        }

        if (empty($field['name2'])) {
            $field['name2'] = 'confirm';
        }

        if (empty($field['caption2'])) {
            $field['caption2'] = $field['caption1'];
        }

        $field['caption1'] .= '*';
        $field['caption2'] .= '*';

        !empty($field['maxlength']) ? $maxlength = ' maxlength="' . $field['maxlength'] . '" ' : $maxlength = '';

        !empty($field['size']) ? $size = ' size="' . $field['size'] . '" ' : $size = '';

        if (!empty($field['type']) and $field['type'] == 'password') {
            $type = 'password';
        } else {
            $type = 'text';
        }

        if (!empty($field['help1'])) {
            $this->_script .= 'if (document.getElementById(\'' . $fieldid1 .
                    '\').value == \'\') {document.getElementById(\'' .
                    $fieldid1 . '\').value = \'' . $field['help1'] . '\';}';
            $onfocus1 = 'onfocus="document.getElementById(\'' . $fieldid1 . '\').value = \'\';"';
            $onblur1 = 'onblur="if (document.getElementById(\'' . $fieldid1 . '\').value == \'\') {document.getElementById(\'' .
                    $fieldid1 . '\').value = \'' . $field['help1'] . '\'}"';
        } else {
            $onfocus1 = '';
            $onblur1 = '';
        }

        if (!empty($field['help2'])) {
            $this->_script .= 'if (document.getElementById(\'' . $fieldid2 .
                    '\').value == \'\') {document.getElementById(\'' .
                    $fieldid2 . '\').value = \'' . $field['help2'] . '\';}';
            $onfocus2 = 'onfocus="document.getElementById(\'' . $fieldid2 . '\').value = \'\';"';
            $onblur2 = 'onblur="if (document.getElementById(\'' . $fieldid2 . '\').value == \'\') {document.getElementById(\'' .
                    $fieldid2 . '\').value = \'' . $field['help2'] . '\'}"';
        } else {
            $onfocus2 = '';
            $onblur2 = '';
        }

        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption1'] .
                '</td><td><input type="' . $type . '" name="' . $field['name1'] . '" id="' . $fieldid1 . '" ' .
                $onfocus1 . ' ' . $onblur1 . ' ' . $maxlength . $size . '></td></tr>';
        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption2'] .
                '</td><td><input type="' . $type . '" name="' . $field['name2'] . '" id="' . $fieldid2 . '" ' .
                $onfocus2 . ' ' . $onblur2 . ' ' . $maxlength . $size . '></td></tr>';
    }

    public function field_textarea_build($field) {

        $name = !empty($field['name']) ? $field['name'] : "";
        if (!empty($this->_incVars[$name]))
            $value = $this->_incVars[$name];
        elseif (!empty($field['value']))
            $value = $field['value'];
        else
            $value = '';

        $fieldid = $name . 'field';

        !empty($field['cols']) ? $cols = ' cols="' . $field['cols'] . '" ' : $cols = '';
        !empty($field['rows']) ? $rows = ' rows="' . $field['rows'] . ' "' : $rows = '';
        !empty($field['disabled']) ? $disabled = ' disabled ' : $disabled = '';
        !empty($field['readonly']) ? $readonly = ' readonly ' : $readonly = '';

        if (!empty($field['help'])) {
            $this->_script .= 'if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\';}';
            $onfocus = 'onfocus="document.getElementById(\'' . $fieldid . '\').value = \'\';"';
            $onblur = 'onblur="if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\'}"';
        } else {
            $onfocus = '';
            $onblur = '';
        }

        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><textarea name="' . $field['name'] . '" id="' . $fieldid . '" ' . $onfocus . ' ' . $onblur . ' ' . $cols . $rows . $disabled . $readonly . ' rel="textarea">' . $value . '</textarea></td></tr>';
    }

    public function field_editor_build($field) {
        $name = $field['name'];
        if (!empty($this->_incVars[$name]))
            $value = $this->_incVars[$name];
        elseif (!empty($field['value']))
            $value = $field['value'];
        else
            $value = '';

        $fieldid = $name . 'field';

        !empty($field['cols']) ? $cols = ' cols="' . $field['cols'] . '" ' : $cols = '';
        !empty($field['rows']) ? $rows = ' rows="' . $field['rows'] . ' "' : $rows = '';
        !empty($field['disabled']) ? $disabled = ' disabled ' : $disabled = '';
        !empty($field['readonly']) ? $readonly = ' readonly ' : $readonly = '';

        if (!empty($field['help'])) {
            $this->_script .= 'if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\';}';
            $onfocus = 'onfocus="document.getElementById(\'' . $fieldid . '\').value = \'\';"';
            $onblur = 'onblur="if (document.getElementById(\'' . $fieldid . '\').value == \'\') {document.getElementById(\'' . $fieldid . '\').value = \'' . $field['help'] . '\'}"';
        } else {
            $onfocus = '';
            $onblur = '';
        }

        $this->_form .= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><textarea name="' . $field['name'] . '" id="' . $fieldid . '" class="editor">' . $value . '</textarea></td></tr>';
        $this->_script .='var ckeditor = CKEDITOR.replace("' . $fieldid . '");AjexFileManager.init({returnTo: "ckeditor",editor: ckeditor,skin: "light"});';
    }

    public function field_checkbox_build($field) {
        $checked = !empty($field['checked']) && $field['checked'] ? ' checked="true" ' : '';
        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><input type="checkbox" ' . $checked . ' name="' . $field['name'] . '" value="false"></td></tr>';
    }

    public function field_select_build($field) {

        !empty($field['multiple']) ? $multiple = ' multiple ' : $multiple = '';
        !empty($field['selected']) ? $selected = $field['selected'] : $selected = 0;
        !empty($field['size']) ? $size = ' size="' . $field['size'] . '" ' : $size = '';
        $options = null;
        if (!empty($field['options'])) {
            foreach ($field['options'] as $value => $title) {
                if ($selected == $value)
                    $options .= '<option value="' . $value . '" selected="true">' . $title . '</option>';
                else
                    $options .= '<option value="' . $value . '">' . $title . '</option>';
            }
        } else {
            $field['options'] = '';
        }

        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><select name="' . $field['name'] . '" value="false"' . $size . $multiple . '>' . $options . '</select></td></tr>';
    }

    public function field_radio_build($field) {

        $this->_form .= '<tr><td></td><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td></tr>';
        foreach ($field['options'] as $radio) {
            $checked = false;
            if (!empty($radio['checked'])) {
                $checked = ' checked';
            }
            $this->_form .= '<tr><td style="text-align:right;"></td><td style="padding-left:20px;" class="' . $field['css_title_class'] . '"><input type="radio" name="' . $field['name'] . '" value="' . $radio['value'] . '"' . $checked . '> ' . $radio['title'] . '</td></tr>';
        }
    }

    public function field_delimiter_build($field) {
        $this->_form .= '<tr><td></td><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td></tr>';
    }

    public function field_file_build($field) {

        !empty($field['size']) ? $size = ' size="' . $field['size'] . '" ' : $size = '';

        $this->_form .='<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td><input name="' . $field['name'] . '"' . $size . ' type="file"></td></tr>';
    }

    public function field_date_build($field) {

        if (empty($field['from_year']) || (!is_numeric($field['from_year']))) {
            $field['from_year'] = 1900;
        }

        if (empty($field['until_year']) || (!is_numeric($field['until_year']))) {
            $field['until_year'] = 2010;
        }

        if ($field['from_year'] > $field['until_year']) {

            $from = $field['from_year'];
            $until = $field['until_year'];

            $field['until_year'] = $from;
            $field['from_year'] = $until;
        }

        if (empty($field['year_name'])) {
            $field['year_name'] = 'year';
        }

        if (empty($field['day_name'])) {
            $field['day_name'] = 'day';
        }

        if (empty($field['mounth_name'])) {
            $field['mounth_name'] = 'year';
        }

        $i = $field['from_year'];
        while ($i <= $field['until_year']) {
            $options_year .= '<option>' . $i . '</option>';
            $i++;
        }

        $i = 0;
        while ($i < 12) {
            $i++;
            $options_mounth .= '<option>' . $i . '</option>';
        }

        $i = 0;
        while ($i < 31) {
            $i++;
            $options_day .= '<option>' . $i . '</option>';
        }

        $select_day = '<select name="' . $field['day_name'] . '" value="false">' . $options_day . '</select>';
        $select_mounth = '<select name="' . $field['mounth_name'] . '" value="false">' . $options_mounth . '</select>';
        $select_year = '<select name="' . $field['year_name'] . '" value="false">' . $options_year . '</select>';

        $this->_form.= '<tr><td ' . $field['css_id'] . ' ' . $field['css_class'] . '>' . $field['caption'] . '</td><td>' . $select_day . $select_mounth . $select_year . '</td></tr>';
    }

    public function field_submit_build($field) {

        if (empty($field['caption'])) {
            $field['caption'] = 'Отправить';
        }
        !empty($field['css_id']) ? $css_id = $field['css_id'] : $css_id = '';

        if (!empty($field['src'])) {
            $type = 'image';
        } else {
            $type = 'submit';
            $field['src'] = '';
        }
        $this->_form .='<tr><td></td><td><input type="' . $type . '" name="' . $field['name'] . '" value="' . $field['caption'] . '" src="' . $field['src'] . '" ' . $css_id . ' ' . $field['css_class'] . '/><br /></td></tr>';
    }

    public function field_button_build($field) {
        $css_id = null;
        if (empty($field['caption'])) {
            $field['caption'] = 'Отправить';
        }

        if (!empty($field['css_id'])) {
            $css_id = $field['css_id'];
        }

        $this->_form .='<tr><td></td><td><input type="button" name="' . $field['name'] . '" value="' . $field['caption'] . '"  ' . $css_id . ' /><br /></td></tr>';
    }

}