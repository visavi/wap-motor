<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#              Made by  :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#	
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Отписка от новостей сайта</b><br /><br />';

if (isset($_GET['key']) && $_GET['key']!=""){ 
if (preg_match('|^[a-z0-9]+$|i', $_GET['key'])){

$key = check($_GET['key']);

$string = search_string(DATADIR."subscribe.dat", $key, 1);
if ($string) {

delete_lines(DATADIR."subscribe.dat", $string['line']);

echo '<b>Вы успешно отписаны от рассылки!</b><br />';
echo 'Ваш e-mail удален из базы данных нашего сайта<br />';

} else {echo '<b>Ошибка, данный код отписки отсутствует в базе!</b><br />';}
} else {echo '<b>Ошибка, недопустимый код отписки от рассылки!</b><br />';}
} else {echo '<b>Ошибка, отсутствует код отписки от рассылки!</b><br />';}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
