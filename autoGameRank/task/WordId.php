<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportWord {
    
    public static $excelFile = '/Users/zhangyan/Desktop/words.xlsx';
    public static $exportFile = '/Users/zhangyan/Desktop/words_csv.txt';
    
    public function __construct()
    {
        $inputExcelConfig = self::readExcel();
        
	    $ids = '';
        foreach ($inputExcelConfig as $inputConfig) {
            if(!empty($inputConfig[0])) {
                $ids .= $inputConfig[0] . ',';
	        }
        }
            
        echo $ids . PHP_EOL;
    }

    /**
     * 读取表格配置核心方法
     *
     * @return array $excelArray
     */
    public static function readExcel()
    {
        $excelArray = [];
    
        try {
            $reader = IOFactory::createReaderForFile(self::$excelFile);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(self::$excelFile);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    
        $sheet = $spreadsheet->getActiveSheet();
    
        // 从表格第二行开始读取
        foreach ($sheet->getRowIterator(1) as $row) {
            $rowTmp = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowTmp[] = $cell->getFormattedValue();
            }
            $excelArray[$row->getRowIndex()] = $rowTmp;
        }
    
        return $excelArray;
    }

    public function UnicodeEncode($str){
        //split word
        preg_match_all('/./u',$str,$matches);
        $unicodeStr = "";
        foreach($matches[0] as $m){
            //拼接
            $unicodeStr .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
        }
        return $unicodeStr;
    }
}
new ImportWord();
