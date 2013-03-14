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
echo '<link rel="shortcut icon" href="'.$config['home'].'/favicon.ico" />';
echo '<link rel="stylesheet" href="'.$config['home'].'/themes/default/style.css" type="text/css" />';
echo '<link rel="alternate" type="application/rss+xml" title="RSS News" href="'.$config['home'].'/news/rss.php" />';
echo '<meta name="keywords" content="'.$config['keywords'].'" />';
echo '<meta name="description" content="'.$config['description'].'" />';
echo '<meta name="generator" content="Wap-Motor '.MOTOR_VERSION.'" />';
echo '</head><body>';
echo '<!--Themes by wap.imgstudio.ru-->';

function myhtml($myhtml) {
$myhtml = str_replace('<img src="'.BASEDIR.'images/img/act.gif" alt="image" />','<img src="'.BASEDIR.'themes/default/b.png" alt="image" />',$myhtml); 
$myhtml = str_replace('<img src="'.BASEDIR.'images/img/act1.gif" alt="image" />','<img src="'.BASEDIR.'themes/default/b.png" alt="image" />',$myhtml);
$myhtml = str_replace('<img src="'.BASEDIR.'images/img/act2.gif" alt="image" />','<img src="'.BASEDIR.'themes/default/b.png" alt="image" />',$myhtml);
$myhtml = str_replace('<img src="'.BASEDIR.'images/img/act3.gif" alt="image" />','<img src="'.BASEDIR.'themes/default/b.png" alt="image" />',$myhtml);
$myhtml = str_replace('<img src="'.BASEDIR.'images/img/act_home.gif" alt="image" />','<img src="'.BASEDIR.'themes/default/b.png" alt="image" />',$myhtml); 
return $myhtml; }
ob_start('myhtml');

echo '<div class="cs" id="up"><img src="'.$config['logotip'].'" alt="image" /><br />'.$config['logos'].' </div>';

if ($config['rekhead']==1){include_once DATADIR."datamain/reklama_head.dat";}
include_once (BASEDIR."includes/isset.php");
echo '<div>';
?>
