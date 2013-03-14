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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Статистика трафика</b><br /><br />';

if($config['gzip']==1){
echo '<span style="color:#00ff00">Сжатие GZIP включено</span><br /><br />';
}else{
echo '<span style="color:#ff0000">Сжатие GZIP выключено</span><br /><br />';
}

if(empty($_SESSION['traffic'])){$_SESSION['traffic'] = 0;}
if(empty($_SESSION['traffic2'])){$_SESSION['traffic2'] = 0;}

echo 'Общий трафик: <b>'.formatsize($_SESSION['traffic2']).'</b><br />';
echo 'Трафик с учетом сжатия: <b>'.formatsize($_SESSION['traffic']).'</b><br />';
$traffic3 = $_SESSION['traffic2'] - $_SESSION['traffic'];
echo 'Сэкономленно за сеанс: <b>'.formatsize($traffic3).'</b><br /><br />';

echo 'Переходов по сайту: <b>'.(int)$_SESSION['counton'].'</b><br />';
echo 'Время проведенное на сайте: <b>'.$_SESSION['timeon'].'</b><br /><br />';

echo 'Внимание! В подсчет трафика не входит трафик за загруженные картинки и прочее<br />';
echo 'Если в браузере есть свой алгоритм сжатия, вы пользуетесь прокси или работаете с программами сжимающими трафик результаты могут несовпадать с реальными данными<br />';
echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>


