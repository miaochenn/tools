<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LivelyMarketRewardList
{

    public static $inputFile = '/Users/zhangyan/Desktop/lively_market_reward_list.xlsx';
    public static $outputFile = '../acm/lively_market_reward_list.json';
    public static $rewardTypeMapping = '../config/lively_market_reward_type.json';
    public $rewardList = [];

    public function __construct()
    {
        $inputExcelConfig = self::readExcel();

        foreach ($inputExcelConfig as $dayInputConfig) {
            $level = (int)$dayInputConfig[0];

            if (empty($level)) {
                throw new Exception('缺少必要数据 ==> level');
            }

            $dailyRewardType = self::getTypeByName($dayInputConfig[1]);
            $dailyRewardName = $dayInputConfig[2];
            $dailyRewardAmount = empty($dayInputConfig[3]) ? 0 : (int)$dayInputConfig[3];
            $dailyRewardDays = empty($dayInputConfig[4]) ? 0 : (int)$dayInputConfig[4];

            $upgradeRewardType = self::getTypeByName($dayInputConfig[5]);
            $upgradeRewardName = $dayInputConfig[6];
            $upgradeRewardAmount = empty($dayInputConfig[7]) ? 0 : (int)$dayInputConfig[7];
            $upgradeRewardDays = empty($dayInputConfig[8]) ? 0 : (int)$dayInputConfig[8];

            $upgrade2RewardType = self::getTypeByName($dayInputConfig[9]);
            $upgrade2RewardName = $dayInputConfig[10];
            $upgrade2RewardAmount = empty($dayInputConfig[11]) ? 0 : (int)$dayInputConfig[11];
            $upgrade2RewardDays = empty($dayInputConfig[12]) ? 0 : (int)$dayInputConfig[12];

            $this->formatRewardConfig(
                $level,
                $dailyRewardType,
                $dailyRewardName,
                $dailyRewardAmount,
                $dailyRewardDays,
                $upgradeRewardType,
                $upgradeRewardName,
                $upgradeRewardAmount,
                $upgradeRewardDays,
                $upgrade2RewardType,
                $upgrade2RewardName,
                $upgrade2RewardAmount,
                $upgrade2RewardDays
            );
        }

        self::output($this->rewardList, self::$outputFile);
    }

    public function formatRewardConfig($level, $dailyRewardType, $dailyRewardName, $dailyRewardAmount, $dailyRewardDays, $upgradeRewardType, $upgradeRewardName, $upgradeRewardAmount, $upgradeRewardDays, $upgrade2RewardType, $upgrade2RewardName, $upgrade2RewardAmount, $upgrade2RewardDays)
    {
        $reward = [
            "experience" => 1000,
            "level" => $level,
            "daily" => [],
            "upgrade" => [],
            "upgrade2" => []
        ];

        if (!empty($dailyRewardType) && !empty($dailyRewardName) && !empty($dailyRewardAmount || $dailyRewardDays)) {
            $reward['daily'] = [
                'reward_id' => $level . '_1',
                'type' => $dailyRewardType['type'],
                'id' => $dailyRewardType['id'] ?? '',
                'name' => $dailyRewardName,
                'amount' => $dailyRewardAmount,
                'days' => $dailyRewardDays,
                'icon' => $dailyRewardType['icon'] ?? 'https://static.app.new.tongzhuoplay.com/'
            ];
        }
        if (!empty($upgradeRewardType) && !empty($upgradeRewardName) && !empty($upgradeRewardAmount || $upgradeRewardDays)) {
            $reward['upgrade'] = [
                'reward_id' => $level . '_2',
                'type' => $upgradeRewardType['type'],
                'id' => $upgradeRewardType['id'] ?? '',
                'name' => $upgradeRewardName,
                'amount' => $upgradeRewardAmount,
                'days' => $upgradeRewardDays,
                'icon' => $upgradeRewardType['icon'] ?? 'https://static.app.new.tongzhuoplay.com/'
            ];
        }
        if (!empty($upgrade2RewardType) && !empty($upgrade2RewardName) && !empty($upgrade2RewardAmount || $upgrade2RewardDays)) {
            $reward['upgrade2'] = [
                'reward_id' => $level . '_3',
                'type' => $upgrade2RewardType['type'],
                'id' => $upgrade2RewardType['id'] ?? '',
                'name' => $upgrade2RewardName,
                'amount' => $upgrade2RewardAmount,
                'days' => $upgrade2RewardDays,
                'icon' => $upgrade2RewardType['icon'] ?? 'https://static.app.new.tongzhuoplay.com/'
            ];
        }

        $this->rewardList[] = $reward;
    }

    public static function getTypeByName($typeName)
    {
        $typeInfo = [];
        foreach (self::getConfigFile(self::$rewardTypeMapping) as $typeConfig) {
            if ($typeConfig['name'] == $typeName) {
                $typeInfo = $typeConfig;
                break;
            }
        }

        return $typeInfo;
    }

    public static function output(array $output, $file)
    {
        echo '>> ../acm/lively_market_reward_list' . PHP_EOL;
        system("echo '' > $file");
        file_put_contents($file, json_encode($output, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES) . PHP_EOL, LOCK_EX);
        echo 'OK!' . PHP_EOL;

        //JSON_UNESCAPED_UNICODE 不转译中文
        //JSON_PRETTY_PRINT 格式化结构
        //JSON_UNESCAPED_SLASHES 不转译 /
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
            $reader = IOFactory::createReaderForFile(self::$inputFile);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(self::$inputFile);
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $sheet = $spreadsheet->getActiveSheet();

        // 从表格第4行开始读取
        foreach ($sheet->getRowIterator(4) as $row) {
            $rowTmp = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowTmp[] = trim($cell->getFormattedValue());
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
}

new LivelyMarketRewardList();
