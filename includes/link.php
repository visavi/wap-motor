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
if (!defined('BASEDIR')) { header("Location:../index.php"); exit; }

if (file_exists(DATADIR."link.dat")){

$filelink = file(DATADIR."link.dat");
$filelink = array_reverse($filelink);
$total = count($filelink);

if ($total>0){

if ($config['showlink'] > $total){$config['showlink'] = $total;}

for ($i=0; $i < $config['showlink']; $i++){
$linkdata = explode("|",$filelink[$i]);	

echo '<img src="'.BASEDIR.'images/img/act.gif" alt="image" /> <a href="'.$linkdata[0].'">'.$linkdata[1].'</a><br />';	
}
} else {echo '<b>В списке еще никого нет, будь первым</b><br />';}
} else {echo '<b>В списке еще никого нет, будь первым</b><br />';}
?>