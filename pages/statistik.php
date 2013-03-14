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
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";

echo '<img src="../images/img/profiles.gif" alt="image" /> <b>Статистика сайта</b><br /><br />'; 

$localfile = file_get_contents(DATADIR."local.dat"); 
$arrloc = explode("|",$localfile);

$fileforum = file_get_contents(DATADIR."forum.dat"); 
$dataforum = explode(":||:",$fileforum);

echo 'Тем в форуме: <b>'.(int)$dataforum[2].'</b><br />';
echo 'Записей в форуме: <b>'.(int)$dataforum[3].'</b><br />';
echo 'Записей в гостевой: <b>'.(int)$arrloc[0].'</b><br />';
echo 'Всего новостей: <b>'.stats_allnews().'</b><br />';
echo 'Комментариев в новостях: <b>'.(int)$arrloc[3].'</b><br />';
echo 'Комментариев в загрузках: <b>'.(int)$arrloc[5].'</b><br />';
echo 'Комментариев в библиотеке: <b>'.(int)$arrloc[6].'</b><br />';
echo 'Комментариев в галерее: <b>'.(int)$arrloc[7].'</b><br /><br />';
echo 'Записей в чате: <b>'.(int)$arrloc[8].'</b><br />';

echo 'Забаненых: <b>'.stats_banned().'</b><br />';
echo 'Забаненых по IP: <b>'.stats_ipbanned().'</b><br />';
echo 'Зарегистрированных: <b>'.stats_users().'</b><br />'; 
echo 'Логинов в черном списке: <b>'.stats_blacklogin().'</b><br />'; 
echo 'E-mail в черном списке: <b>'.stats_blackmail().'</b><br />'; 

$tot = array_sum($arrloc);

//$arrloc[0] = Сообщений в гостевой
//$arrloc[1] = Тем в форуме
//$arrloc[2] = Сообщений в форуме
//$arrloc[3] = Комментарий в новостях
//$arrloc[4] = Сообщений в админ-чате
//$arrloc[5] = Комментарий в загрузках
//$arrloc[6] = Комментарий в библиотеке
//$arrloc[7] = Комментарий в галерее
//$arrloc[8] = Сообщений в чате

echo '<br />Актив сайта: <b>'.(int)$tot.'</b> баллoв(а)<br /><br />';

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>