<?php

$sourceFile = './source_gift.txt';
$exportFile = './file/party_lucky_gift.txt';

$jsonFile = file_get_contents($sourceFile);

file_put_contents($exportFile, 'ID'. "," . "name" . PHP_EOL, FILE_APPEND);

foreach (json_decode($jsonFile, true) as $gift) {
    if ($gift['is_hidden'] ?? false) {
        continue;
    }
    if (!isset($gift['rank_score'])) {
        $gift['rank_score'] = $gift['coin_amount'];
    }    
    file_put_contents($exportFile, $gift['id'] . "," . $gift['name'] . PHP_EOL, FILE_APPEND);
}