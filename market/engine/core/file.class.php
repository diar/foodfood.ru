<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с файлами
 */
class File {

    /** Инициализация модуля
     * @return null
     */
    public static function initModule () {

    }

    /**
     * Сохраняет фаил в нужную папку и возвращает название сохранённое файла
     * @param string $fieldName имя поля в пост запросе содержащее фаил
     * @param string $fileName имя файла с котором сохранить, иначе сохраняет по маске.
     * @param string $pathToSave путь сохранения файла
     * @return string
     */
    public static function saveFile ($fieldName,$fileName=null,$pathToSave=null) {
        $pic = null;
        if (is_uploaded_file($_FILES[$fieldName]['tmp_name'])) {

                $pic = $_FILES[$fieldName]['name'];
                $extension = explode(".",$pic);
                $extension = end($extension);
                $datakod = date('U');
                $pic = !empty($fileName) ? $fileName.".".$extension : $datakod."_ffmarket.".$extension;
                if (empty($pathToSave)) {
                    $pathToDir = self::getFileType($extension);
                    $pathToSave = "upload/$pathToDir";
                }
            
            if(!is_dir($pathToSave))
                    mkdir($pathToSave,0777,true);
            $res = copy($_FILES[$fieldName]['tmp_name'], "$pathToSave/$pic");
        }
        return $pic;
    }

    /**
     * Сохраняет файлы из нескольких элементов Input в нужную папку
     * @param string $path путь к папке, в которую нужно сохранять
     * @param string $multi true если в одном элементе input несколько файлов
     * @param array $folders массив названий папок в соответствии с названием input
     * @return string
     */
    public static function saveMultiFile ($path,$multi=true,$folders=null) {
        foreach ($_FILES as $utype=>$file) {
            $file_count = sizeof($file["name"]);
            for ($i = 0; $i < $file_count; $i++) {
                if(!empty($file['error'][$i])) die();

                if (empty($folders)) $folder = '';
                elseif (!empty($folders[$utype])) $folder = '/'.$folders[$utype];
                elseif (!empty($folders['default'])) $folder = '/'.$folders[$utype];
                else $folder = '';

                $extension = explode(".",$file['name'][$i]) ;
                $ext= end($extension);

                if(!is_dir(Config::getValue('path','upload').$path.'/'.$folder))
                    mkdir(Config::getValue('path','upload').$path.'/'.$folder,0777,true);
                if (!in_array ($ext,array('php','php5')) ) {
                    $filename = "foodfood_".$extension[0].'.'.$ext;
                    move_uploaded_file(
                            $file['tmp_name'][$i],
                            Config::getValue('path','upload').$path.'/'.$folder.'/'.$filename
                    );
                }

            }
        }
    }

    /**
     * Определяет тип файла из 3х: Фаил, Изобращение, Флеш. И возвращает название папки для сохранения
     * @param string $extension расширение файла
     */
    private static function getFileType($extension) {
        if(preg_match('/(jpg)?(gif)?(png)?(jpeg)?/',$extension))
            return 'image';
        elseif(preg_match('/(swf)?/',$extension))
            return 'flash';
        else return 'file';
    }

    /**
     * Получить объект PHPEXcel
     */
    public static function newPHPExcel() {
        require_once (Config::getValue('path','libs').'phpexcell/PHPExcel.php');
        require_once (Config::getValue('path','libs').'phpexcell/PHPExcel/Writer/Excel2007.php');
        require_once (Config::getValue('path','libs').'phpexcell/PHPExcel/Writer/Excel5.php');
        require_once (Config::getValue('path','libs').'phpexcell/PHPExcel/Writer/CSV.php');
        return new PHPExcel();
    }
    /**
     * Сохранить в CSV
     */
    public static function saveCSV ($data,$path,$title='Файл',$create='unknown') {
        $objPHPExcel = self::newPHPExcel();
        $objPHPExcel->getProperties()->setCreator($create);
        $objPHPExcel->getProperties()->setLastModifiedBy($create);
        $objPHPExcel->getProperties()->setTitle($title);
        $objPHPExcel->getProperties()->setSubject($title);
        $objPHPExcel->getProperties()->setDescription($title);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle($title);

        $cym = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cn = count($data);
        for ($i=0;$i<$cn;$i++) {
            $record = $data[$i];
            $cl = count($record);
            $j=0;
            foreach ($record as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue($cym[$j].($i+1), $row);
                $j++;
            }
        }

        $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
        $objWriter->save($path);
    }
    /**
     * Сохранить в Excel 2007
     */
    public static function saveXLSX ($data,$path,$title='Файл',$create='unknown') {
        $objPHPExcel = self::newPHPExcel();
        $objPHPExcel->getProperties()->setCreator($create);
        $objPHPExcel->getProperties()->setLastModifiedBy($create);
        $objPHPExcel->getProperties()->setTitle($title);
        $objPHPExcel->getProperties()->setSubject($title);
        $objPHPExcel->getProperties()->setDescription($title);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle($title);

        $cym = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cn = count($data);
        for ($i=0;$i<$cn;$i++) {
            $record = $data[$i];
            $j=0;
            foreach ($record as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue($cym[$j].($i+1), $row);
                $j++;
            }
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($path);
    }
    /**
     * Сохранить в Excel
     */
    public static function saveXLS ($data,$path,$title='Файл',$create='unknown') {
        $objPHPExcel = self::newPHPExcel();
        $objPHPExcel->getProperties()->setCreator($create);
        $objPHPExcel->getProperties()->setLastModifiedBy($create);
        $objPHPExcel->getProperties()->setTitle($title);
        $objPHPExcel->getProperties()->setSubject($title);
        $objPHPExcel->getProperties()->setDescription($title);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle($title);

        $cym = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cn = count($data);
        for ($i=0;$i<$cn;$i++) {
            $record = $data[$i];
            $j=0;
            foreach ($record as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue($cym[$j].($i+1), $row);
                $j++;
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save($path);
    }
}