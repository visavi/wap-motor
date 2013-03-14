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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}
if (isset($_GET['list'])) {$list = check($_GET['list']);} else {$list = 404;}

if (is_admin(array(101,102))){
	
echo '<img src="../images/img/menu.gif" alt="image" /> <b>Просмотр лог-файлов</b><br /><br />';	

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){	

if ($list==404){
echo '<b><big>Ошибки 404 - несуществующие файлы</big></b><br /><br />';
echo '<b>404</b> | <a href="logfiles.php?list=403&amp;'.SID.'">403</a> | <a href="logfiles.php?list=ban&amp;'.SID.'">Автобаны</a><br /><br />';
$filename = DATADIR."datalog/error404.dat";}

if ($list==403){
echo '<b><big>Ошибки 403 - недопустимые запросы</big></b><br /><br />'; 
echo '<a href="logfiles.php?'.SID.'">404</a> | <b>403</b> | <a href="logfiles.php?list=ban&amp;'.SID.'">Автобаны</a><br /><br />';	
$filename = DATADIR."datalog/error403.dat";}


if ($list=='ban'){
echo '<b><big>Автоматические баны</big></b><br /><br />'; 	
echo '<a href="logfiles.php?'.SID.'">404</a> | <a href="logfiles.php?list=403&amp;'.SID.'">403</a>  | <b>Автобаны</b><br /><br />';
$filename = DATADIR."datalog/ban.dat";}

if (file_exists($filename)){
$file = file($filename);
$file = array_reverse($file);
$total = count($file);

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['loglist']){ $end = $total; }
else {$end = $start + $config['loglist']; }
for ($i = $start; $i < $end; $i++){	

$dtlog=explode("|", $file[$i]);

echo '<div class="b">';
echo '<img src="../images/img/files.gif" alt="image" /> <b>'.$dtlog[1].'</b> <small>('.date_fixed($dtlog[2]).')</small></div>';
echo '<div>Referer: '.$dtlog[3].'<br />';
echo 'Пользователь: '.$dtlog[4].'<br />';
echo '<small><span style="color:#cc00cc">('.$dtlog[5].', '.$dtlog[6].')</span></small></div>';
}

page_jumpnavigation('logfiles.php?list='.$list.'&amp;', $config['loglist'], $start, $total);
page_strnavigation('logfiles.php?list='.$list.'&amp;', $config['loglist'], $start, $total);

if (is_admin(array(101))) {
echo '<br /><br /><img src="../images/img/error.gif" alt="image" /> <a href="logfiles.php?action=del&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Очистить логи</a>';}

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Записей еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Записей еще нет!</b><br />';}
}
	
############################################################################################
##                                     Очистка логов                                      ##
############################################################################################
if ($action=="del"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if (is_admin(array(101))){	

clear_files(DATADIR."datalog/error404.dat");
clear_files(DATADIR."datalog/error403.dat");
clear_files(DATADIR."datalog/ban.dat");		
	
header ("Location: logfiles.php?isset=mp_dellogs&".SID); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Очищать логи могут только суперадмины!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="logfiles.php?'.SID.'">Вернуться</a>';
}

//-------------------------------- КОНЦОВКА ------------------------------------//	
echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>