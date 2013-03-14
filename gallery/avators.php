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

if(isset($_GET['uz'])) {$uz = check($_GET['uz']); } else {$uz = "";}

if (preg_match('|^[a-z0-9\-]+$|i',$uz)){
if (file_exists(DATADIR."dataavators/$uz.gif")){
$filename = DATADIR."dataavators/$uz.gif";
} else {
$filename = BASEDIR."images/avators/noavatar.gif";
}
$filename = file_get_contents($filename);
header('Content-Disposition: inline; filename="'.$uz.'.gif"');
header("Content-type: image/gif");
header("Content-Length: ".strlen($filename));
echo $filename;
}
exit;
?>