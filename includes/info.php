<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#-----------------------------------------------------#
if (is_user()){

$chas = date_fixed(SITETIME,"H");
if ($chas>24){$chas=round($chas-24);}
if ($chas<0){$chas=round($chas+24);}

if ($chas<=4 || $chas>=23){echo '<div style="text-align:center"><span style="color:#ff0000"><b>Доброй ночи, '.nickname($_SESSION['log']).'</b></span></div>';}
if ($chas>=5 && $chas<=10){echo '<div style="text-align:center"><span style="color:#ff0000"><b>Доброе утро, '.nickname($_SESSION['log']).'</b></span></div>';}
if ($chas>=11 && $chas<=17){echo '<div style="text-align:center"><span style="color:#ff0000"><b>Добрый день, '.nickname($_SESSION['log']).'</b></span></div>';}
if ($chas>=18 && $chas<=22){echo '<div style="text-align:center"><span style="color:#ff0000"><b>Добрый вечер, '.nickname($_SESSION['log']).'</b></span></div>';}	

$uzertime = substr($udata[18],0,5);
$montime = date_fixed(SITETIME,"d.m");
if ($uzertime==$montime){
echo '<div style="text-align:center"><span style="color:#ff0000"><b>Поздравляем вас с днем рождения!</b></span></div>';
}}

if ($config['welcome']==1){
if (file_exists(DATADIR."welcome.dat")){
$welcome_file = file_get_contents(DATADIR."welcome.dat");
echo '<div style="text-align:center">'.$welcome_file.'</div>';
}}


if ($config['showtime']==1){
echo '<div style="text-align:center"><b>'.date_fixed(SITETIME,'j F Y').'</b><br /><small>'.date_fixed(SITETIME,'H:i:s').'</small></div>';
} 

if ($config['quotes']==1){
$quot_file = file(BASEDIR."includes/quotesbase.php");
$quot_rand = array_rand($quot_file);
echo $quot_file[$quot_rand].'<br />'; 
}

if ($config['calendar']==1){include_once (BASEDIR."includes/calendar.php");}

if ($config['onliner']==1){include_once (BASEDIR."includes/onliner.php");}

if ($config['autoskins']>0){include_once (BASEDIR."includes/skin.php");}
?>