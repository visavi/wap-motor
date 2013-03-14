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

$config['maxadminchat'] = 100;

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102,103,105))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Админ-чат</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="adminchat.php?rand='.mt_rand(100,999).'&amp;'.SID.'">Обновить</a> | ';
echo '<a href="../pages/smiles.php?'.SID.'">Смайлы</a> | ';
echo '<a href="../pages/tegi.php?'.SID.'">Теги</a><br />';

echo '<hr /><form action="adminchat.php?action=add&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post"><b>Сообщение:</b><br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input type="submit" value="Написать" /></form><hr />';

$file = file(DATADIR."adminchat.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['bookpost']){ $end = $total; }
else {$end = $start + $config['bookpost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b">';

echo user_avatars($data[1]);

echo '<b><a href="../pages/anketa.php?uz='.$data[1].'&amp;'.SID.'">'.nickname($data[1]).'</a></b> '.user_title($data[1]).user_online($data[1]);

echo ' <small>('.date_fixed($data[3]).')</small></div>';

echo '<div>'.bb_code($data[0]).'<br /><small><span style="color:#cc00cc">('.$data[4].', '. $data[5].')</span></small></div>';
}

page_jumpnavigation('adminchat.php?', $config['bookpost'], $start, $total);
page_strnavigation('adminchat.php?', $config['bookpost'], $start, $total);

if (is_admin(array(101))){
echo '<br /><br /><img src="../images/img/error.gif" alt="image" /> <a href="adminchat.php?action=prodel&amp;'.SID.'">Очистить чат</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="adminchat.php?action=restatement&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Пересчитать</a>';
}

} else {echo '<br /><img src="../images/img/reload.gif" alt="image" /> <b>Сообщений нет, будь первым!</b><br />';}
}


############################################################################################
##                                   Добавление сообщений                                 ##
############################################################################################
if($action=="add") {

$msg = check($_POST['msg']);
$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1500){

statistics(4);

$msg = no_br($msg,'<br />');
$msg = smiles($msg);

$text = no_br($msg.'|'.$log.'||'.SITETIME.'|'.$brow.'|'.$ip.'|');

write_files(DATADIR."adminchat.dat", "$text\r\n");

$countstr = counter_string(DATADIR."adminchat.dat");
if ($countstr>=$config['maxadminchat']) {
delete_lines(DATADIR."adminchat.dat",array(0,1));
}

header ("Location: adminchat.php?isset=addon&".SID); exit;

} else {echo '<b>Ошибка, слишком длинное или короткое сообщение!</b><br />'; }
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="adminchat.php?'.SID.'">Вернуться</a>';
}


############################################################################################
##                                  Подтверждение очистки                                 ##
############################################################################################
if ($action=="prodel") {
echo 'Вы уверены что хотите удалить все сообщения в админ-чате?<br /><br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="adminchat.php?action=alldel&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Да уверен!</a></b><br />';	
	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="adminchat.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                   Очистка админчата                                    ##
############################################################################################
if ($action=="alldel") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

clear_files(DATADIR."adminchat.dat");	

header ("Location: adminchat.php?isset=mp_admindelchat&".SID); exit;

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<b>Ошибка! Очищать админ-чат могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="adminchat.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                  Пересчет мини-чата                                    ##
############################################################################################
if($action=="restatement") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

$count = counter_string(DATADIR."adminchat.dat");

statistics(4, $count);

header ("Location: adminchat.php?isset=mp_adminrestatement&".SID); exit;	

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<b>Ошибка! Пересчитывать сообщения могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="adminchat.php?'.SID.'">Вернуться</a>';	
}


echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>