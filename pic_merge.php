<?php
$bigImgPath = '/Users/zhangyan/Downloads/2308.wh1200.png';
$pic1Path = '/Users/zhangyan/Downloads/meilic.png';
$pic2Path = '/Users/zhangyan/Downloads/zhaofu.png';
$pic3Path = '/Users/zhangyan/Downloads/rqox.png';
$pic4Path = '/Users/zhangyan/Downloads/send_gift_coins_2000_3.png';
$pic5Path = '/Users/zhangyan/Downloads/shancaitongzi_2.png';
$pic6Path = '/Users/zhangyan/Downloads/shuang.png';
$pic7Path = '/Users/zhangyan/Downloads/ttxs.png';


$bigImg = imagecreatefromstring(file_get_contents($bigImgPath));
$pic1Img = imagecreatefromstring(file_get_contents($pic1Path));
$pic2Img = imagecreatefromstring(file_get_contents($pic2Path));
$pic3Img = imagecreatefromstring(file_get_contents($pic3Path));
$pic4Img = imagecreatefromstring(file_get_contents($pic4Path));
$pic5Img = imagecreatefromstring(file_get_contents($pic5Path));
$pic6Img = imagecreatefromstring(file_get_contents($pic6Path));
$pic7Img = imagecreatefromstring(file_get_contents($pic7Path));

list($bigWidth, $bigHight, $bigType) = getimagesize($bigImgPath);
list($pic1Width, $pic1Hight, $pic1Type) = getimagesize($pic1Path);
list($pic2Width, $pic2Hight, $pic2Type) = getimagesize($pic2Path);
list($pic3Width, $pic3Hight, $pic3Type) = getimagesize($pic3Path);
list($pic4Width, $pic4Hight, $pic4Type) = getimagesize($pic4Path);
list($pic5Width, $pic5Hight, $pic5Type) = getimagesize($pic5Path);
list($pic6Width, $pic6Hight, $pic6Type) = getimagesize($pic6Path);
list($pic7Width, $pic7Hight, $pic7Type) = getimagesize($pic7Path);

//imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct ) : bool
imagecopymerge($bigImg, $pic1Img, 0, 0, 0, 0, $pic1Width, $pic1Hight, 100);
imagecopymerge($bigImg, $pic2Img, 263, 0, 0, 0, $pic2Width, $pic2Hight, 100);
imagecopymerge($bigImg, $pic3Img, 526, 0, 0, 0, $pic3Width, $pic3Hight, 100);
imagecopymerge($bigImg, $pic4Img, 0, 70, 0, 0, $pic4Width, $pic4Hight, 100);
imagecopymerge($bigImg, $pic5Img, 263, 70, 0, 0, $pic5Width, $pic5Hight, 100);
imagecopymerge($bigImg, $pic6Img, 526, 70, 0, 0, $pic6Width, $pic6Hight, 100);
imagecopymerge($bigImg, $pic7Img, 0, 140, 0, 0, $pic7Width, $pic7Hight, 100);


header('Content-Type:image/png');
imagepng($bigImg, './merge.png');

imagedestroy($bigImg);
imagedestroy($pic1Img);
imagedestroy($pic2Img);
imagedestroy($pic3Img);
imagedestroy($pic4Img);
imagedestroy($pic5Img);
imagedestroy($pic6Img);
imagedestroy($pic7Img);
