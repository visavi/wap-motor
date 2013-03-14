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

if (isset($_GET['rat']) && $_GET['rat']!=""){$rat = (int)$_GET['rat'];} else {$rat = 0;}
if (isset($_GET['in']) && $_GET['in']!=""){$in = (int)$_GET['in'];} else {$in = 0;}

if ($rat<0 || $rat>150){$rat=0;}
if ($in<0 || $in>100){$in=0;}

header("Content-type: image/gif");
$im = ImageCreate (152, 12);

$color = imagecolorallocate ($im, 255, 255, 255);
$color1 = imagecolorallocate($im, 0, 0, 0); 
$color2 = imagecolorallocate ($im, 153, 153, 153); 
$color3 = imagecolorallocate($im, 102, 102, 102); 

imagefilledrectangle ($im, 1, 1, $rat, 10, $color2);
imagerectangle ($im, 0, 0, 151, 11, $color3);
ImageString($im, 1, 128, 2, "$in%", $color1);
ImageGIF($im); 

?>