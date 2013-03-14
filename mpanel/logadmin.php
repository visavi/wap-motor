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

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}
if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}

if (is_admin(array(101,102))){
	
echo'<img src="../images/img/menu.gif" alt="image" /> <b>Админ-логи</b><br /><br />';	

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){	

$file = file(DATADIR."datalog/admin.dat");
$file = array_reverse($file);
$total = count($file);

if($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['loglist']){ $end = $total; }
else {$end = $start + $config['loglist']; }
for ($i = $start; $i < $end; $i++){	

$dtlog=explode("|", $file[$i]);

echo '<div class="b">';
echo '<img src="../images/img/files.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$dtlog[3].'&amp;'.SID.'">'.nickname($dtlog[3]).'</a></b>';
echo ' ('.date_fixed($dtlog[6]).')</div>';
echo '<div>Страница: '.$dtlog[4].'<br />';
echo 'Откуда: '.$dtlog[5].'<br />';
echo '<small><span style="color:#cc00cc">('.$dtlog[1].', '.$dtlog[2].')</span></small></div>';

}

page_jumpnavigation('logadmin.php?', $config['loglist'], $start, $total);
page_strnavigation('logadmin.php?', $config['loglist'], $start, $total);

if (is_admin(array(101))) {
echo '<br /><br /><img src="../images/img/error.gif" alt="image" /> <a href="logadmin.php?action=del&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Очистить логи</a>';}

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Записей еще нет!</b><br />';}

}
	
############################################################################################
##                                    Очистка логов                                       ##
############################################################################################
if ($action=="del"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if (is_admin(array(101))){	

clear_files(DATADIR."datalog/admin.dat");

header ("Location: logadmin.php?isset=mp_dellogs&".SID); exit;

} else {echo '<b>Ошибка! Очищать логи могут только суперадмины!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="logadmin.php?'.SID.'">Вернуться</a>';
}

//-------------------------------- КОНЦОВКА ------------------------------------//	
echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>