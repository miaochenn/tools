<?php
header("content-type:text/html;charset=GBK");

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportWord {
    
    public static $excelFile = '/Users/zhangyan/Desktop/words.xlsx';
    
    public function __construct()
    {
        $words = [];
        $inputExcelConfig = self::readExcel();
        
        foreach ($inputExcelConfig as $inputConfig) {
            $tmp = [];
            $a = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $inputConfig[0]);
            $b = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $inputConfig[1]);

            if ($a != $b && !empty($a) && !empty($b)) {
                //$tmp[] = $this->UnicodeEncode($a);
                //$tmp[] = $this->UnicodeEncode($b);
                $tmp[] = $a;
                $tmp[] = $b;
            
                $words[] = $tmp;
            }
        }
            
        echo "开始写入..." . PHP_EOL;
        echo '>> party_undercover_words' . PHP_EOL;
        
        $res = file_put_contents('../acm/party_undercover_words' ,json_encode($words, JSON_PRETTY_PRINT). PHP_EOL, LOCK_EX);
        
        if ($res !== false) {
            echo "写入成功" . PHP_EOL;
            return;
        }
            
        echo "Error !" . PHP_EOL;
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
