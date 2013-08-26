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

//-------------------- Вывод статистики ------------------------------//
$counter_online = counter_string(DATADIR."online.dat");

$counter_host = 0;
$counter_hits = 0;

if (file_exists(DATADIR."datacounter/host.dat")){
$count = file_get_contents(DATADIR."datacounter/host.dat");
$count = explode("|",$count);
$counter_host = $count[1];
}

if (file_exists(DATADIR."datacounter/hits.dat")){
$hcount = file_get_contents(DATADIR."datacounter/hits.dat");
$hcount = explode("|",$hcount);
$counter_hits = $hcount[1];
}

$img = imageCreateFromGIF(BASEDIR.'images/img/counter.gif');
$color = imagecolorallocate($img, 169,169,169);
$color2 = imagecolorallocate($img, 102,102,102);

if ($counter_online >= 0 && $counter_online < 10) $pos = 66;
if ($counter_online >= 10 && $counter_online< 100) $pos = 54;
if ($counter_online >= 100 && $counter_online < 1000) $pos = 43; 

imageTTFtext($img, 6, 0, 3, 16, $color, BASEDIR."gallery/font/font4.ttf",$counter_host);
imageTTFtext($img, 6, 0, 3, 22, $color, BASEDIR."gallery/font/font4.ttf",$counter_hits);
imageTTFtext($img, 12, 0, $pos, 22, $color2,BASEDIR."gallery/font/font7.ttf",$counter_online); 

/* 
if ($counter_online >= 0 && $counter_online < 10) $pos = 66;
if ($counter_online >= 10 && $counter_online< 100) $pos = 58;
if ($counter_online >= 100 && $counter_online < 1000) $pos = 48;

ImageString($img, 1, 4, 8, $counter_host, $color);
ImageString($img, 1, 4, 15, $counter_hits, $color);
ImageString($img, 6, $pos, 8, $counter_online, $color2);
*/

Header("Content-type: image/gif");
ImageGIF($img);
ImageDestroy($img);
?>