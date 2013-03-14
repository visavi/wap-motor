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
header("Content-type:text/html; charset=utf-8");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>';
echo '<title>'.site_title($php_self).'</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<style type="text/css">
body {text-decoration: none; font-family: arial; font-size: 15pt; margin: 5px; padding: 5px; background: #fff; color: #000;}
.a {background-color: #333; margin: 5px; padding: 5px; color: #fff; font-style: italic;}
.x {background-color: #eee; margin: 10px; padding: 15px;}  
</style>';
echo '<link rel="shortcut icon" href="'.$config['home'].'/favicon.ico" />';
echo '<meta name="keywords" content="'.$config['keywords'].'" />';
echo '<meta name="description" content="'.$config['description'].'" />';
echo '<meta name="generator" content="Wap-Motor '.MOTOR_VERSION.'" />';
echo '</head><body>';
echo '<!--Design by Vantuz (http://pizdec.ru)-->';

function amendment($skinxhtml) {
$skinxhtml = str_replace('images/img/act.gif','themes/lite/act.gif',$skinxhtml);
$skinxhtml = str_replace('images/img/act1.gif','themes/lite/act.gif',$skinxhtml);
$skinxhtml = str_replace('images/img/act2.gif','themes/lite/act.gif',$skinxhtml);
$skinxhtml = str_replace('images/img/act3.gif','themes/lite/act.gif',$skinxhtml);
$skinxhtml = str_replace('images/img/act_home.gif','themes/lite/act.gif',$skinxhtml);
$skinxhtml = str_replace('<hr />','<br />',$skinxhtml);
return $skinxhtml; }
ob_start('amendment');

echo '<div class="x" id="up">';
echo '<div class="a">'.site_title($php_self).'</div>';

if ($config['rekhead']==1){include_once DATADIR."datamain/reklama_head.dat";}
include_once (BASEDIR."includes/isset.php");
echo '<div>';
?>
