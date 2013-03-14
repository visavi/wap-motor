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
if (isset($_GET['action'])){$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101))){

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Управление подписчиками</b><br /><br />';

############################################################################################
##                                 Главная страница                                       ##
############################################################################################	
if ($action==""){

$file = file(DATADIR."subscribe.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){  

echo '<form action="subscribe.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['maxpostsub']){ $end = $total;}
else {$end = $start + $config['maxpostsub']; }
for ($fm = $start; $fm < $end; $fm++){

$num = $total - $fm - 1;
	
$data = explode("|",$file[$fm]);

echo '<div class="b">';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<img src="../images/img/chel.gif" alt="image" /> <b>'.$data[0].'</b> ('.date_fixed($data[2]).')</div>';

echo '<div>Пользователь: <a href="../pages/anketa.php?uz='.$data[3].'&amp;'.SID.'">'.nickname($data[3]).'</a></div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('subscribe.php', $config['maxpostsub'], $start, $total);
page_strnavigation('subscribe.php', $config['maxpostsub'], $start, $total);

echo '<br /><br />Всего подписчиков: <b>'.(int)$total.'</b><br /><br />';

echo '<img src="../images/img/error.gif" alt="image" /> <a href="subscribe.php?action=poddel&amp;'.SID.'">Очистить</a>';

} else {echo '<img src="../images/img/reload.gif" alt="image" />  <b>Подписчиков еще нет!</b><br />';} 
}


############################################################################################
##                                 Удаление подписчиков                                   ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."subscribe.dat", $del); 

header ("Location: subscribe.php?start=$start&isset=mp_delsubmail&".SID); exit;

} else {echo '<b>Ошибка удаления! Отсутствуют выбранные подписчики!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="subscribe.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                 Подтверждение очистки                                  ##
############################################################################################
if ($action=="poddel") {
echo '<br />Вы уверены что хотите удалить всех подписчиков из базы?<br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="subscribe.php?action=alldel&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Да уверен!</a></b><br />';	
	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="subscribe.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                                 Очистка базы подписчиков                               ##
############################################################################################
if ($action=="alldel") {

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){

clear_files(DATADIR."subscribe.dat");	

header ("Location: subscribe.php?isset=mp_delsuball&".SID); exit;

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="subscribe.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}

//-------------------------------- КОНЦОВКА ------------------------------------//	
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>