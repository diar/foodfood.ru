<?php
require_once "adminModule.class.php";

class restPhotos extends AdminModule {
    protected static $_title = "Фотографии ресторана";
    protected static $_DB_table = 'rest_photo';

    public static function add() {
        Debug::disable();
        $web_dir = '/upload/image/'.'rest_photo/'.self::getRestId().'/';
        $file=self::save();
        if ($file) {
            $id = DBP::lastInsertId();
            echo '<div id="response">'.
                    '{"filename" : "'.$web_dir.$file.'","id" : "'.$id.'"}</div>';
        }
    }

    public static function save() {
        $file_dir = Config::getValue('path','upload').'image/rest_photo/'.self::getRestId().'/';
        $file=File::saveFile('img', null, $file_dir);
        $data = array('rest_id'=>self::getRestId(),
                'type'=>'rest',
                'src'=>$file
        );
        Image::resizeImage(
                $file_dir.$file, 100, 100, true, $file_dir.'mini-'.$file, false
        );
        DBP::insert(self::getDbTable(), $data);
        return $file ? $file : null;
    }

    public static function delete() {
        $web_dir = '/upload/image/'.'rest_photo/'.self::getRestId().'/';
        $file_dir = Config::getValue('path','upload').'image/rest_photo/'.self::getRestId().'/';
        foreach ($_POST['photo_id'] as $photo) {
            $photo_id = DB::quote(str_replace('photo', '',$photo));
            // Удаляем фотографию из базы
            DBP::delete(self::getDbTable(), "id = ".$photo_id);
        }
        foreach ($_POST['photo_src'] as $photo) {
            // Загружаем src в массив, если вдруг потом понадобится
            $photo_src = str_replace($web_dir,'',$photo);
            // Удаляем фотографию из файловой системы
            @unlink ($file_dir.$photo_src);
        }
        echo('OK');
    }


    public static function showList() {
        $content['web_dir'] = '/upload/image/rest_photo/'.self::getRestId().'/';
        $content['photos'] = DBP::getRecords(self::getDbTable(), "rest_id = ".self::getRestId());
        $list = View::getXSLT($content, 'blocks/admin_rest_photo');
        self::showTemplate($list);
    }

}