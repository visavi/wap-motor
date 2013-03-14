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
if (!defined("BASEDIR")) { header("Location:../index.php"); exit; }

if ($config['navigation']>0){include_once (BASEDIR."includes/navigation.php");}

if ($config['rekfoot']==1){include_once (DATADIR."datamain/reklama_foot.dat");}

if ($config['gzip']==1){
$contents = ob_get_contents();
$gzib_file = strlen($contents); 


if($support_gzip){
$gzib_file_out = strlen(compress_output_gzip($contents));
} else {
if ($support_deflate) {
$gzib_file_out = strlen(compress_output_deflate($contents));
} else {
$gzib_file_out = strlen($contents);
}}

$gzib_pro = round(100 - (100 / ($gzib_file / $gzib_file_out)), 1);
if ($gzib_pro > 0 && $gzib_pro < 100){
echo 'Cжатие: '.$gzib_pro.'%<br />';}

} else {
$gzib_file = ob_get_length();
$gzib_file_out = $gzib_file;
}

//---------------------- Установка сессионных переменных -----------------------//

if(empty($_SESSION['traffic'])){$_SESSION['traffic'] = 0;}
if(empty($_SESSION['traffic2'])){$_SESSION['traffic2'] = 0;}
if(empty($_SESSION['counton'])){$_SESSION['counton'] = 0;}

$_SESSION['traffic'] = $_SESSION['traffic'] + $gzib_file_out;
$_SESSION['traffic2'] = $_SESSION['traffic2'] + $gzib_file;
$_SESSION['counton']++;

if ($config['generics']==1) {
echo round(microtime(1)-$starttime, 4).' сек.<br />'; 
}
?>