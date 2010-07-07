<?php

require_once "adminModule.class.php";

class restWorktime extends AdminModule {

    protected static $_title = "Время работы";
    protected static $_DB_table = 'rest_worktime';

    /**
     * Инициализация модуля
     * @return null
     */
    public static function initModule() {
        $actions = self::getActions();
        $actions['showCsv'] = array(
            'title' => 'Список',
            'level' => 1,
            'onMenu' => false
        );
        self::setRestId($_SESSION['admin']['restaurant_id']);
        self::start();
    }

    public static function save() {
        DBP::delete(self::getDbTable(), 'rest_id=' . self::getRestId());
        $rows = unserialize($_POST['rows']);
        foreach ($rows as $post) {
            if (strlen($post['start_hour']) < 2)
                $post['start_hour'] = '0' . $post['start_hour'];
            if (strlen($post['end_hour']) < 2)
                $post['end_hour'] = '0' . $post['end_hour'];
            if (strlen($post['start_minute']) < 2)
                $post['start_minute'] = '0' . $post['start_minute'];
            if (strlen($post['end_minute']) < 2)
                $post['end_minute'] = '0' . $post['end_minute'];
            $data['day_start'] = $post['start_week'];
            $data['day_end'] = $post['end_week'];
            $data['time_start'] = $post['start_hour'] . ':' . $post['start_minute'];
            $data['time_end'] = $post['end_hour'] . ':' . $post['end_minute'];
            $data['rest_id'] = self::getRestId();
            DBP::insert(self::getDbTable(), $data);
        }
    }

    public static function showList() {
        $content = DBP::getRecords(self::getDbTable(), 'rest_id=' . self::getRestId(), 'id ASC');
        foreach ($content as &$data) {
            $time_start = explode(':', $data['time_start']);
            $time_end = explode(':', $data['time_end']);
            $data['hour_start'] = $time_start[0];
            $data['minute_start'] = $time_start[1];
            $data['hour_end'] = $time_end[0];
            $data['minute_end'] = $time_end[1];
        }
        $contents['rows'] = $content;
        $list = View::getXSLT($contents, 'blocks/admin_worktime');
        self::showTemplate($list);
    }

}