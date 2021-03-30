<?php

$giftsJson = file_get_contents('./source_gift.txt');
$gifts = json_decode($giftsJson, true);
$giftsOrderList = $argv;
unset($giftsOrderList[0]);

$result = [];

foreach ($giftsOrderList as $orderName) {
    foreach ($gifts as $gift) {
        if ($gift['name'] == $orderName) {
            $result[$gift['id']] = $gift;
        }
    }
}

foreach ($gifts as $gift) {
    if ($gift['is_hidden'] ?? false) {
        $result[$gift['id']] = $gift;
    }
}

file_put_contents('./gift_order_res.txt' ,json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode($giftsOrderList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);