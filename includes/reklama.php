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

if (file_exists(DATADIR."reklama.dat")){
$filereklama = file(DATADIR."reklama.dat"); 
if ($filereklama){

$reklama_rand = array_rand($filereklama);

$str_reklama = explode("|",$filereklama[$reklama_rand]);	

echo '<b><a href="'.$str_reklama[1].'">'.$str_reklama[2].'</a></b><br />';

}}

?>