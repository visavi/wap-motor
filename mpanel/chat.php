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

if (is_admin(array(101,102,103,105))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Управление мини-чатом</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){	

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';	
echo '<a href="chat.php?rand='.mt_rand(100,990).'&amp;'.SID.'">Обновить</a> | ';
echo '<a href="../chat/index.php?start='.$start.'&amp;'.SID.'">Обзор</a><br /><hr />';	
	
	
$file = file(DATADIR."chat.dat");
$file = array_reverse($file);
$total = count($file);
    
if ($total>0){   

echo '<form action="chat.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['chatpost']){$end = $total;}
else {$end = $start + $config['chatpost'];}
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

$useronline = user_online($data[1]);
$useravatars = user_avatars($data[1]);

if ($data[1]=='Вундер-киндер'){$useravatars='<img src="../images/img/mag.gif" alt="image" /> '; $useronline='<span style="color:#00ff00">[On]</span>';}
if ($data[1]=='Настюха'){$useravatars='<img src="../images/img/bot.gif" alt="image" /> '; $useronline='<span style="color:#00ff00">[On]</span>';}
if ($data[1]=='Весальчак'){$useravatars='<img src="../images/img/shut.gif" alt="image" /> '; $useronline='<span style="color:#00ff00">[On]</span>';}

echo '<div class="b">';

echo $useravatars;

echo '<b><a href="../pages/anketa.php?uz='.$data[1].'&amp;'.SID.'"> '.nickname($data[1]).'</a></b> '.user_title($data[1]).$useronline.' <small> ('.date_fixed($data[3]).')</small><br />';
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<a href="chat.php?action=edit&amp;id='.$num.'&amp;start='.$start.'&amp;'.SID.'">Редактировать</a>';

echo '</div><div>'.bb_code($data[0]).'<br />';
echo '<span style="color:#cc00cc"><small>('.$data[4].', '.$data[5].')</small></span></div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('chat.php?', $config['chatpost'], $start, $total);
page_strnavigation('chat.php?', $config['chatpost'], $start, $total);

echo '<br /><br />Всего сообщений: <b>'.(int)$total.'</b><br />';

if (is_admin(array(101))) {
echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="chat.php?action=prodel&amp;'.SID.'">Очистить</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="chat.php?action=restatement&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Пересчитать</a>';
}

} else {echo '<img src="../images/img/reload.gif" alt="image" />  <b>Сообщений еще нет!</b><br />';} 
}

############################################################################################
##                                 Подтверждение очистки                                  ##
############################################################################################
if ($action=="prodel") {
echo '<br />Вы уверены что хотите удалить все сообщения в мини-чате?<br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="chat.php?action=alldel&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Да уверен!</a></b><br />';	
	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="chat.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                   Очистка мини-чата                                    ##
############################################################################################
if ($action=="alldel") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

clear_files(DATADIR."chat.dat");	

header ("Location: chat.php?isset=mp_chatclear&".SID); exit;

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<b>Ошибка! Очищать мини-чат могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="chat.php?'.SID.'">Вернуться</a>';

}


############################################################################################
##                                  Пересчет мини-чата                                    ##
############################################################################################
if($action=="restatement") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

$count = counter_string(DATADIR."chat.dat");

statistics(8, $count);

header ("Location: chat.php?isset=mp_chatrestatement&".SID); exit;	

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<b>Ошибка! Пересчитывать сообщения могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="chat.php?'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                 Удаление сообщений                                     ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."chat.dat", $del); 

header ("Location: chat.php?start=$start&isset=mp_checkdelpost&".SID); exit;

} else {echo '<b>Ошибка удаления! Отсутствуют выбранные сообщения</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="chat.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                    Редактирование                                      ##
############################################################################################
if ($action=="edit") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!==""){
$file = file(DATADIR."chat.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$data[0] = nosmiles($data[0]);
$data[0] = str_replace("<br />","\r\n",$data[0]);

echo '<b><big>Редактирование сообщения</big></b><br /><br />';

echo '<form action="chat.php?action=addedit&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

echo '<img src="../images/img/edit.gif" alt="image" /> <b>'.nickname($data[1]).'</b> <small>('.date_fixed($data[3]).')</small><br /><br />';

echo 'Cообщение:<br />';
echo '<textarea cols="25" rows="3" name="msg">'.$data[0].'</textarea><br/>';
echo '<br /><input type="submit" value="Изменить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения для редактирования не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано сообщение для редактирования!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="chat.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                                 Изменение сообщения                                    ##
############################################################################################
if ($action=="addedit") {
	
$uid = check($_GET['uid']);
$msg = check($_POST['msg']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){
if ($msg!=""){

$file = file(DATADIR."chat.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$msg = no_br($msg,' <br /> ');
$msg = smiles($msg);

$text = no_br($msg.'|'.$data[1].'|'.$data[2].'|'.$data[3].'|'.$data[4].'|'.$data[5].'|'.$data[6].'|'.$data[7].'|'.$data[8].'|');

replace_lines(DATADIR."chat.dat", $id, $text);

header ("Location: chat.php?start=$start&isset=mp_chateditpost&".SID); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения для редактирования не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не написали текст сообщения!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано сообщение для редактирования!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="chat.php?action=edit&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

//-------------------------------- КОНЦОВКА ----------------------------------//
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>