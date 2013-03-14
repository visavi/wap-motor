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

$nfile = file(DATADIR."online.dat");
$onliner_users = array();

foreach($nfile as $value){
$ndata = explode('|', $value);
if ($ndata[2]!=""){
$onliner_users[] = $ndata[2];
}}


echo '<marquee>';
echo '<span style="color:#ff0000">На сайте: ';

if (count($onliner_users)>0){

foreach($onliner_users as $key=> $value){	
if ($key==0){
echo nickname($value);
} else {
echo ', '.nickname($value);
}}

} else {
echo 'Нет авторизованных пользователей!';
}

echo '</span>';
echo '</marquee><br />';

?>