<?php

/*
 * @example
 * php makeAcmGiftConfig.php 庆祝香槟 11 梦幻城堡 20 魔法种子 4 包包 10 梦幻城堡 2 魔法种子 2 香水 5 梦幻城堡 80 魔法种子 200
 */

function getParams($argv) {
    return preg_split("/([0-9]+)/", str_replace('x', '', $argv[1]), 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
}

function newDaysConfig($argv)
{
    list($name_1, $amount_1, $name_2, $amount_2, $name_3, $amount_3, $name_4, $amount_4, $name_5, $amount_5, $name_6, $amount_6, $name_7, $amount_7, $name_8, $amount_8, $name_9, $amount_9) = getParams($argv);
    $giftConfig = [
        'position_1' => [
            [
                'name' => $name_1,
                'amount' => (int)$amount_1
            ],
            [
                'name' => $name_2,
                'amount' => (int)$amount_2
            ],
            [
                'name' => $name_3,
                'amount' => (int)$amount_3
            ]
        ],
        'position_2' => [
            [
                'name' => $name_4,
                'amount' => (int)$amount_4
            ],
            [
                'name' => $name_5,
                'amount' => (int)$amount_5
            ],
            [
                'name' => $name_6,
                'amount' => (int)$amount_6
            ]
        ],
        'position_3' => [
            [
                'name' => $name_7,
                'amount' => (int)$amount_7
            ],
            [
                'name' => $name_8,
                'amount' => (int)$amount_8
            ],
            [
                'name' => $name_9,
                'amount' => (int)$amount_9
            ]
        ]
    ];

    return $giftConfig;
}

function newDaysConfigParams($argv)
{
    list($name_1, $amount_1, $name_2, $amount_2, $name_3, $amount_3, $name_4, $amount_4, $name_5, $amount_5, $name_6, $amount_6, $name_7, $amount_7, $name_8, $amount_8, $name_9, $amount_9) = getParams($argv);
    $giftConfig = [
        [
            'name' => $name_1,
            'amount' => (int)$amount_1
        ],
        [
            'name' => $name_2,
            'amount' => (int)$amount_2
        ],
        [
            'name' => $name_3,
            'amount' => (int)$amount_3
        ],
        [
            'name' => $name_4,
            'amount' => (int)$amount_4
        ],
        [
            'name' => $name_5,
            'amount' => (int)$amount_5
        ],
        [
            'name' => $name_6,
            'amount' => (int)$amount_6
        ],
        [
            'name' => $name_7,
            'amount' => (int)$amount_7
        ],
        [
            'name' => $name_8,
            'amount' => (int)$amount_8
        ],
        [
            'name' => $name_9,
            'amount' => (int)$amount_9
        ]
    ];

    return $giftConfig;
}

function newAcmConfig($argv)
{
    $daysConfig = newDaysConfig($argv);
    $newDaysConfigParams = newDaysConfigParams($argv);

    $name = implode(array_column($newDaysConfigParams, 'name'));

    $giftDiffConfig = json_decode(file_get_contents('./gift_config_diff.txt'), true);
    $findSameConfig = $giftDiffConfig[md5($name)] ?? ''; // 找到的礼物的顺序肯定是一样的

    if (empty($findSameConfig)) {
        exit('找不到某天相同配置的礼物' . PHP_EOL);
    }

    foreach ($findSameConfig as $position => $configs) {
        foreach ($configs as $key => $gift) {
            $configs[$key]['amount'] = $daysConfig[$position][$key]['amount'];
        }
        $findSameConfig[$position] = $configs;
    }

    echo '礼物配置：'.PHP_EOL;
    echo json_encode($newDaysConfigParams, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    echo PHP_EOL;
    echo '>> gift_acm_config.txt'.PHP_EOL;

    file_put_contents('./gift_acm_config.txt' ,json_encode($findSameConfig). PHP_EOL, FILE_APPEND);
}

newAcmConfig($argv);
