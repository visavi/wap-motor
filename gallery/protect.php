<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#	
require_once "../includes/start.php";
require_once "../includes/functions.php";

if(isset($_SESSION['protect']) && $_SESSION['protect']!=""){

$pkod = str_split(intval($_SESSION['protect']));

$img = imagecreate(42,18);
$fon = imagecolorallocate($img,255,255,255);
imagefill($img,0,0,$fon);

$color1 = imagecolorallocate($img,mt_rand(0,204),mt_rand(0,204),mt_rand(0,204));
$color2 = imagecolorallocate($img,mt_rand(0,204),mt_rand(0,204),mt_rand(0,204));
$color3 = imagecolorallocate($img,mt_rand(0,204),mt_rand(0,204),mt_rand(0,204));
$color4 = imagecolorallocate($img,mt_rand(0,204),mt_rand(0,204),mt_rand(0,204));

ImageString($img, 5, mt_rand(2,3), mt_rand(0,3), $pkod[0], $color1);
ImageString($img, 5, mt_rand(11,12), mt_rand(0,3), $pkod[1], $color2);
ImageString($img, 5, mt_rand(20,21), mt_rand(0,3), $pkod[2], $color2);
ImageString($img, 5, mt_rand(29,30), mt_rand(0,3), $pkod[3], $color3);

if ($config['protectdef']==1){

for ($i=0; $i<5; $i++){
$temp_color = imagecolorallocate ($img,mt_rand(155,204),mt_rand(155,204),mt_rand(155,204));
imageline($img, mt_rand(0,42), mt_rand(0,18), mt_rand(0,42), mt_rand(0,18), $temp_color);
}


for ($i=0; $i<50; $i++){
$temp_color = imagecolorallocate ($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
imagesetpixel ($img, mt_rand(0, 42), mt_rand(0, 18), $temp_color);
}
}

Header("Content-type: image/gif");
ImageGIF($img);
ImageDestroy($img);
}
?>