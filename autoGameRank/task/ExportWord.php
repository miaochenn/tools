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
        
        foreach ($inputExcelConfig as $inputConfig) {
            $tmp = [];
            $a = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $inputConfig[1]);
            $b = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $inputConfig[2]);
            if (empty($a) || empty($b)) {
                exit("存在不完整的词组");
            }

            $word = [];
            if ($a != $b && !empty($a) && !empty($b)) {
                $word['uid'] = $inputConfig[0] ?? '';
                $word['word_1'] = $a;
                $word['word_2'] = $b;
                $word['hash_id'] = self::getHash([$a, $b]);
                $word['status'] = 1;
                $word['created_at'] = date('Y-m-d H:i:s');
                $word['updated_at'] = date('Y-m-d H:i:s');
                
                file_put_contents(self::$exportFile,
                    $word['uid'] . "," .
                    $word['word_1'] . "," .
                    $word['word_2'] . "," .
                    $word['hash_id'] . "," .
                    $word['status'] . "," .
                    $word['created_at'] . "," .
                    $word['updated_at'] . PHP_EOL, FILE_APPEND
                );
            }
        }
            
        echo 'success >> /Users/zhangyan/Desktop/words_csv.txt' . PHP_EOL;
    }

    public static function getHash(array $words)
    {
        $list = [];
        foreach ($words as $word)
        {
            $list[md5($word)] = $word;
        }

        ksort($list);

        return md5(implode($list));
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
