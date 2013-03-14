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

if (isset($_GET['dir'])) {$dir = check($_GET['dir']);} else {$dir = basename(DATADIR).'/datagallery';;}
if (isset($_GET['name'])) {$name = check($_GET['name']);} else {$name = "";}

if (preg_match('|^[a-z0-9_\-/]+$|i', $dir) && preg_match('|^[a-z0-9_\.\-]+$|i', $name)){

if (file_exists(BASEDIR.$dir.'/'.$name)){
$ext = strtolower(substr($name, strrpos($name, '.') + 1));

if ($ext=='jpg' || $ext=='gif'){

$size = getimagesize(BASEDIR.$dir.'/'.$name); 
$width = $size[0]; 
$height = $size[1]; 

if ($width>$config['previewsize'] || $height>$config['previewsize']){

$x_ratio = $config['previewsize'] / $width; 
$y_ratio = $config['previewsize'] / $height; 

if (($width <= $config['previewsize']) && ($height <= $config['previewsize'])) { 
$tn_width = $width; 
$tn_height = $height; 
} 
else if (($x_ratio * $height) < $config['previewsize']) { 
$tn_height = ceil($x_ratio * $height); 
$tn_width = $config['previewsize']; 
} 
else { 
$tn_width = ceil($y_ratio * $width); 
$tn_height = $config['previewsize']; 
} 

if ($ext=='jpg'){
$img = imagecreatefromjpeg(BASEDIR.$dir.'/'.$name); 
$dst = imagecreatetruecolor($tn_width,$tn_height); 
imagecopyresampled($dst, $img, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

header('content-type: image/jpeg');
header('Content-Disposition: filename="'.$name.'"');
imagejpeg ($dst, null, 40);
imagedestroy($img); 
imagedestroy($dst);
}	  

if ($ext=='gif'){
$img = imagecreatefromgif(BASEDIR.$dir.'/'.$name); 
$dst = imagecreatetruecolor($tn_width,$tn_height); 

$colorTransparent = imagecolortransparent($img);
imagepalettecopy($img, $dst);
imagefill($dst, 0, 0, $colorTransparent);
imagecolortransparent($dst, $colorTransparent);
imagetruecolortopalette($dst, true, 256);

imagecopyresampled($dst, $img, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

header('content-type: image/gif'); 
header('Content-Disposition: filename="'.$name.'"');
imagegif ($dst); 
imagedestroy($img); 
imagedestroy($dst);
}	  	  

} else {
$filename = file_get_contents(BASEDIR.$dir.'/'.$name);
header('Content-Disposition: inline; filename="'.$name.'"');
header("Content-type: image/$ext");
header("Content-Length: ".strlen($filename));
echo $filename;
}
}}}
exit;
?>