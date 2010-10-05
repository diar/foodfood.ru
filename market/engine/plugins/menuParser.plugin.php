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