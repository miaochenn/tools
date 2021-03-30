<?php

//print_r($argv);

function diffGifts()
{
    $giftsJson = file_get_contents('./gift_config.txt');
    $giftsArr = array_values(json_decode($giftsJson, true));

    $diffGifts = [];
    foreach ($giftsArr as $giftDayConfig) {
        $giftHashId = getNamesHash($giftDayConfig);
        $diffGifts[$giftHashId] = $giftDayConfig;
    }
    file_put_contents('./gift_config_diff.txt', json_encode($diffGifts));
}


function getNamesHash(array $giftDayConfig)
{
    $name = '';
    foreach ($giftDayConfig as $position) {
        $name .= implode(array_column($position, 'name'));
    }
    
    return md5(str_replace(' ', '', $name));
}

diffGifts();