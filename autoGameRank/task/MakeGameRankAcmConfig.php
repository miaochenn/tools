<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MakeGameRankAcmConfig {
    
    public static $giftMappingConfig = '../config/lively_market_reward_mapping.json';
    public static $excelFile = '/Users/zhangyan/Desktop/lively_market_reward_list.xlsx';
    public static $outputFile = '../acm/lively_market_reward_list.json';

    /**
     * @return void
     */
    public function __construct()
    {
        $gameRank = [];
        $gameRankDayGiftConfig = [];
        $inputExcelConfig = self::readExcel();
        
        foreach ($inputExcelConfig as $dayInputConfig) {
            if (empty($dayInputConfig)) {
                echo '表格存在空行，需检查数据完整性';
                break;
            }
            
            $excelDateToTimestamp = Date::excelToTimestamp($dayInputConfig[0]);
            $date = date("Y-m-d", $excelDateToTimestamp);
        }

        self::output($result);
    }

    /**
     * 输出
     */
    public static function output(array $output, $file)
    {
        echo '>> lively_market_reward_list' . PHP_EOL;
        system("echo '' > $file");
        file_put_contents($file ,json_encode($gameRank, JSON_PRETTY_PRINT). PHP_EOL, LOCK_EX);
        echo 'OK!' . PHP_EOL;
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
    
        // 从表格第四行开始读取
        foreach ($sheet->getRowIterator(4) as $row) {
            $rowTmp = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowTmp[] = $cell->getFormattedValue();
            }
            if (!empty(implode($rowTmp))) {
                $excelArray[$row->getRowIndex()] = $rowTmp;
            }
        }
    
        return $excelArray;
    }

    /**
     * 获取通用配置文件
     *
     * @param [type] $filename
     * @return array $config
     */
    public static function getConfigFile($filename)
    {
        if (!is_file($filename)) {
            throw new Exception('File "' . $filename . '" does not exist.');
        }
        
        return json_decode(file_get_contents($filename), true);
    }
}

new MakeGameRankAcmConfig();
