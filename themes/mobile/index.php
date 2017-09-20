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
header('Content-type:text/html; charset=utf-8');
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>';
echo '<title>%TITLE%</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<style type="text/css">
body, td, tr {text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-size: 8pt; cursor: default; color: #666;}
body {margin: 5px; padding: 5px; background: #f3f3f3; color: #666; max-width: 600px; margin: auto;}
legend {color: #ccc; width: 100%; font-size: 12px; font-weight: bold; border-bottom: solid 1px #f7f7f7; padding-bottom: 5px; margin-bottom: 5px;}
fieldset {border: solid 1px #fff; padding-bottom: 10px;}
form {margin: 0px; padding: 0px;}
a:active, a:visited, a:link {color: #446488; text-decoration: none; font-size: 8pt;}
a:hover {color: #00004f; text-decoration: none; font-size: 8pt;}
a.nav:active, a.nav:visited, a.nav:link {color: #666; font-size: 10px; font-weight: bold; text-decoration: none;}
a.nav:hover {font-size: 10px; font-weight: bold; color: #666; text-decoration: underline;}
input, select {font-size: 8pt;}
textarea {width: 98%; font-size: 9pt; padding: 5px;}
div {margin: 1px 0px 1px 0px; padding: 5px 5px 5px 5px; background: #fff;}
table {margin: 1px 0px 1px 0px; padding: 1px 1px 1px 1px; font-size: 8pt;}
q {font-family: Times, serif;  font-style: italic; color: navy;quotes: "\00AB" "\00BB"}
hr {border : 1px dotted #ccc;}
.a {border: 1px solid #ccc; color: #666; background: #E9E9E9;}
.b {font-size: 13px; color: #666; background-color: #f3f3f3; padding: 3px; color: #666; border: 1px solid #ccc;}
.c {border: 1px solid #ccc; color: #666; background: #E9E9E9;}
.d {background-color: #E3E5E3; border-style: dotted; border-width: 1px; border-color: #B8C1B7; padding: 10px; padding-left: 35px;  background-image: url(/images/img/code.gif); background-repeat: repeat-y; font-size: 11px; display: block; overflow: auto;}
.form {color: #666; padding : 3px; background-color: #f3f3f3; border: 1px dotted #ccc;}
.login {color: #666; padding : 10px; margin : 10px 0 10px 0; background-color: #f3f3f3; border: 1px dotted #ccc;}
</style>';
echo '<link rel="shortcut icon" href="/favicon.ico" />';
echo '<link rel="alternate" type="application/rss+xml" title="RSS News" href="/news/rss.php" />';
echo '<meta name="keywords" content="%KEYWORDS%" />';
echo '<meta name="description" content="%DESCRIPTION%" />';
echo '<meta name="generator" content="Wap-Motor '.MOTOR_VERSION.'" />';
echo '</head><body>';
echo '<!--Design by Vantuz (http://pizdec.ru)-->';

echo '<div class="a" id="up"><a href="/index.php"><img src="'.$config['logotip'].'" alt="'.$config['title'].'" /></a><br />'.$config['logos'].' </div>';
echo '<div>';

if ($config['rekhead']==1){include_once DATADIR."datamain/reklama_head.dat";}
include_once (BASEDIR."includes/isset.php");
?>
