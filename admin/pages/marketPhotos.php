<?php
require_once "adminModule.class.php";

class marketPhotos extends AdminModule {
    protected static $_title = "Фотографии блюда";
    protected static $_DB_table = 'market_photo';

    public static function add() {
       // Debug::disable();
        $id = ELEMENT_ID;
        $web_dir = '/upload/image/market_photo/'.$id.'/';
        $file=self::save($id);
        if ($file) {
            $id = DBP::lastInsertId();
            echo '<div id="response">'.
                    '{"filename" : "'.$web_dir.$file.'","id" : "'.$id.'"}</div>';
        }
    }

    public static function save($id) {
        $file_dir = Config::getValue('path','upload').'image/market_photo/'.$id.'/';
        $file=File::saveFile('img', null, $file_dir);
        $data = array(
                'dish_id'=>$id,
                'src'=>$file
        );
        Image::resizeImage(
                $file_dir.$file, 100, 100, true, $file_dir.'mini-'.$file, false
        );
        DBP::insert(self::getDbTable(), $data);
        return $file ? $file : null;
    }

    public static function delete() {
        $id = ELEMENT_ID;
        $web_dir = '/upload/image/market_photo/'.$id.'/';
        $file_dir = Config::getValue('path','upload').'image/market_photo/'.$id.'/';
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
        $id = ELEMENT_ID;
        $content['dish_id'] = $id;
        $content['web_dir'] = '/upload/image/market_photo/'.$id.'/';
        $content['photos'] = DBP::getRecords(self::getDbTable(), "dish_id = ".DB::quote($id));
        $list = View::getXSLT($content, 'blocks/admin_market_photo');
        self::showTemplate($list);
    }

}