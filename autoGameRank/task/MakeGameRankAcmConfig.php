<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MakeGameRankAcmConfig {

    public static $excelFile = '/Users/zhangyan/Desktop/game_rank.xlsx';
    public static $outputFile = '../acm/game_rank.json';
    public static $gameDouble = '../config/games_double.json';
    public static $gameSingle = '../config/games_single.json';
    public $result = [];

    public function __construct()
    {
        $inputExcelConfig = self::readExcel();

        foreach ($inputExcelConfig as $dayInputConfig) {
            if (empty($dayInputConfig)) {
                echo '表格存在空行，需检查数据完整性';
                break;
            }

            $excelDateToTimestamp = Date::excelToTimestamp($dayInputConfig[0]);
            $date = date("Y-m-d", $excelDateToTimestamp);
            $gameType = $dayInputConfig[1] == '对战' ? 'fight' : 'single';
            $gameId = self::getGameIdByGameName($gameType, $dayInputConfig[2]);
            $this->formatGameRankConfig($date, $gameId, $gameType);
        }

        self::output($this->result, self::$outputFile);
    }

    public function formatGameRankConfig($date, $gameId, $gameType)
    {
        $this->result[$date] = [
            "date" => $date,
            "game_id" => $gameId,
            "game_type" => $gameType
        ];
    }

    public static function output(array $output, $file)
    {
        echo '>> game_rank' . PHP_EOL;
        system("echo '' > $file");
        file_put_contents($file ,json_encode($output, JSON_PRETTY_PRINT). PHP_EOL, LOCK_EX);
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

        // 从表格第2行开始读取
        foreach ($sheet->getRowIterator(2) as $row) {
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

    public static function getConfigFile($filename)
    {
        if (!is_file($filename)) {
            throw new Exception('File "' . $filename . '" does not exist.');
        }

        return json_decode(file_get_contents($filename), true);
    }

    public static function getGameIdByGameName($gameType, $gameName)
    {
        $configFile = $gameType == 'fight' ? self::$gameDouble : self::$gameSingle;
        $gameConfig = self::getConfigFile($configFile);
        foreach ($gameConfig as $gameId => $game) {
            if (trim($game['name']) == $gameName) {
                return $gameId;
            }
        }

        throw new Exception("游戏《". $gameName ."》不存在");
    }
}

new MakeGameRankAcmConfig();
