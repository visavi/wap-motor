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

if (isset($_GET['dir'])) {$dir = check($_GET['dir']);} else {$dir = basename(DATADIR).'/datagallery';}
if (isset($_GET['name'])) {$name = check($_GET['name']);} else {$name = "";}

if (preg_match('|^[a-z0-9_\-/]+$|i', $dir) && preg_match('|^[a-z0-9_\.\-]+$|i', $name)){

if (file_exists(BASEDIR.$dir.'/'.$name)){
$ext = strtolower(substr($name, strrpos($name, '.') + 1));

if ($ext=='jpg' || $ext=='gif'){
$filename = file_get_contents(BASEDIR.$dir.'/'.$name);
header('Content-Disposition: inline; filename="'.$name.'"');
header("Content-type: image/$ext");
header("Content-Length: ".strlen($filename));
echo $filename;
}}}
exit;
?>