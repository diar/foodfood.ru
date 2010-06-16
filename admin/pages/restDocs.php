<?php
require_once "adminModule.class.php";

class restDocs extends AdminModule {
    protected static $_title = "Документы ресторана";
    protected static $_DB_table = 'rest_docs';

    public static function add() {
        Debug::disable();
        $web_dir = '/upload/file/'.'restaurant/'.self::getRestId().'/';
        $file=self::save();
        if ($file) {
            $id = DBP::lastInsertId();
            echo '<div id="response">'.
                    '{"title" : "'.$file['title'].'","id" : "'.$id.'"}'.
                    '</div>';
        }
    }

    public static function save() {
        $file_dir = Config::getValue('path','upload').'file/restaurant/'.self::getRestId().'/';
        $file=File::saveFile('img', null, $file_dir);
        $title = $_FILES['img']['name'];

        $data = array(
                'rest_id'=>self::getRestId(),
                'path'=>$file_dir.$file,
                'title'=>$title
        );
        DBP::insert(self::getDbTable(), $data);
        return $file ? Array('title'=>$title,'filename'=>$file) : null;
    }

    public static function delete() {
        Debug::disable();
        $web_dir = '/upload/file/'.'restaurant/'.self::getRestId().'/';
        $file_dir = Config::getValue('path','upload').'file/restaurant/'.self::getRestId().'/';
        foreach ($_POST['doc_id'] as $doc) {
            $doc_id = DB::quote(str_replace('doc', '',$doc));
            // Удаляем фотографию из базы
            $src=DBP::getRecord(self::getDbTable(), "id = ".$doc_id);
            @unlink ($src['path']);
            DBP::delete(self::getDbTable(), "id = ".$doc_id);
        }
        echo('OK');
    }


    public static function showList() {
        $content['web_dir'] = '/upload/file/restaurant/'.self::getRestId().'/';
        $content['docs'] = DBP::getRecords(self::getDbTable(), "rest_id = ".self::getRestId());
        $list = View::getXSLT($content, 'blocks/admin_rest_docs');
        self::showTemplate($list);
    }

}