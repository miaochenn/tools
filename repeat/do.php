<?php


$gifts = './source.txt';
$liveGifts = './source2.txt';

$giftsArr = json_decode(file_get_contents($gifts), true);
$liveGiftsArr = json_decode(file_get_contents($liveGifts), true);

foreach ($giftsArr as $gift) {
    if ($gift['is_hidden'] ?? false) {
        continue;
    }
    $giftNames[] = $gift['name'];
}

foreach ($liveGiftsArr as $gift) {
    if ($gift['is_hidden'] ?? false) {
        continue;
    }
    $liveGiftNames[] = $gift['name'];
}

$giftsDiffLiveGifts = array_diff($giftNames, $liveGiftNames);
$LiveGiftsDiffGifts = array_diff($liveGiftNames, $giftNames);

echo "IM中有的，直播间没有的：" . PHP_EOL;
foreach ($giftsDiffLiveGifts as $diffName) {
    echo $diffName . PHP_EOL;
}

echo "直播间有的,IM没有的：" . PHP_EOL;
foreach ($LiveGiftsDiffGifts as $diffName) {
    echo $diffName . PHP_EOL;
}