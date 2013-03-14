<?php
$perc=(int)$_GET['perc'];
$perc2 = $perc;
if($perc2=='100'){$perc2 = $perc-2;}


header("Content-type: image/gif");
$im = imageCreateFromGIF("img/grafic.gif"); 
$color = imagecolorallocate($im, 234, 237, 237);
$color2 = imagecolorallocate($im, 227, 222, 222); 
$color3 = imagecolorallocate($im, 204, 200, 200);
$color4 = imagecolorallocate($im, 185, 181, 181);
imagefilledrectangle ($im, 1, 1, 98, 2, $color);
imagefilledrectangle ($im, 1, 3, 98, 4, $color2);
imagefilledrectangle ($im, 1, 5, 98, 6, $color3);
imagefilledrectangle ($im, 1, 7, 98, 8, $color4);
$color = imagecolorallocate($im, 192, 255, 62);
$color2 = imagecolorallocate($im, 179, 238, 58); 
$color3 = imagecolorallocate($im, 154, 205, 50);
$color4 = imagecolorallocate($im, 105, 139, 34);
if($perc>'0'){ 
imagefilledrectangle ($im, 1, 1, $perc2, 2, $color);
imagefilledrectangle ($im, 1, 3, $perc2, 4, $color2);
imagefilledrectangle ($im, 1, 5, $perc2, 6, $color3);
imagefilledrectangle ($im, 1, 7, $perc2, 8, $color4);}	 
$text = imagecolorallocate($im, 0, 0, 0);
ImageString($im, 0, 76, 1, "".$perc."%", $text);
ImageGIF($im); 
?>