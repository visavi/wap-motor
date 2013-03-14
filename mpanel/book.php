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

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Управление гостевой</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){	
	
echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';	
echo '<a href="book.php?rand='.mt_rand(100,999).'&amp;'.SID.'">Обновить</a> | ';
echo '<a href="../book/index.php?start='.$start.'&amp;'.SID.'">Обзор</a><br /><hr />';
	
$file = file(DATADIR."book.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){  

echo '<form action="book.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['bookpost']){ $end = $total;}
else {$end = $start + $config['bookpost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

echo '<div class="b">';

echo user_avatars($data[1]);

if ($data[1]==$config['guestsuser']){ 
echo '<b>'.$data[1].'</b> ';
} else {
echo '<b><a href="../pages/anketa.php?uz='.$data[1].'&amp;'.SID.'">'.nickname($data[1]).'</a></b> '.user_title($data[1]).user_online($data[1]).' ';
}

echo '<small>('.date_fixed($data[3]).')</small><br />';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';

echo '<a href="book.php?action=edit&amp;id='.$num.'&amp;start='.$start.'&amp;'.SID.'">Редактировать</a> | ';
echo '<a href="book.php?action=otvet&amp;id='.$num.'&amp;start='.$start.'&amp;'.SID.'">Ответить</a></div>';

echo '<div>'.bb_code($data[0]).'<br /><small><span style="color:#cc00cc">('.$data[4].','. $data[5].')</span></small>'; 
if ($data[6]!=""){ echo '<br /><span style="color:#ff0000">Ответ: '.$data[6].'</span>';}
if ($data[7]!=""){ echo '<br /><span style="color:#ff0000">Отредактировано: '.nickname($data[7]).' ('.date_fixed($data[2]).')</span>';} 
echo '</div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('book.php?', $config['bookpost'], $start, $total);
page_strnavigation('book.php?', $config['bookpost'], $start, $total);

echo '<br /><br />Всего сообщений: <b>'.(int)$total.'</b><br />';

if (is_admin(array(101))) {
echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="book.php?action=prodel&amp;'.SID.'">Очистить</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="book.php?action=restatement&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Пересчитать</a>';
}

} else {echo '<img src="../images/img/reload.gif" alt="image" />  <b>Сообщений еще нет!</b><br />';} 
}

############################################################################################
##                                        Ответ                                           ##
############################################################################################
if ($action=="otvet") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!==""){
$file = file(DATADIR."book.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

echo '<b><big>Добавление ответа</big></b><br /><br />';

echo '<div class="b"><img src="../images/img/edit.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$data[1].'&amp;'.SID.'">'.nickname($data[1]).'</a></b> '.user_title($data[1]).user_online($data[1]).' <small>('.date_fixed($data[3]).')</small></div>';
echo '<div>Сообщение: '.bb_code($data[0]).'</div><hr />';
	
echo '<form action="book.php?id='.$id.'&amp;action=addotvet&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Cообщение:<br />';
echo '<textarea cols="25" rows="3" name="otvet">'.nosmiles($data[6]).'</textarea>';
echo '<br /><input type="submit" value="Ответить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения для ответа не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано сообщение для ответа!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                                  Добавление ответа                                     ##
############################################################################################
if ($action=="addotvet") {

$uid = check($_GET['uid']);
$otvet = check($_POST['otvet']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){
if ($otvet!=""){

$file = file(DATADIR."book.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$otvet = no_br($otvet,'<br />');
$otvet = smiles($otvet);

$text = no_br($data[0].'|'.$data[1].'|'.$data[2].'|'.$data[3].'|'.$data[4].'|'.$data[5].'|'.$otvet.'|'.$data[7].'|');

replace_lines(DATADIR."book.dat", $id, $text);
	
header ("Location: book.php?start=$start&isset=mp_bookotvet&".SID);	exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения для ответа не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не написали текст ответа!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано сообщение для ответа!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?action=otvet&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/smenu.gif" alt="image" /> <a href="book.php?start='.$start.'&amp;'.SID.'">В гостевую</a>';
}

############################################################################################
##                                    Редактирование                                      ##
############################################################################################
if ($action=="edit") {
	
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!==""){
$file = file(DATADIR."book.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$data[0] = nosmiles($data[0]);
$data[0] = str_replace("<br />","\r\n",$data[0]);

echo '<b><big>Редактирование сообщения</big></b><br /><br />';

echo '<form action="book.php?id='.$id.'&amp;action=addedit&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

echo '<img src="../images/img/edit.gif" alt="image" /> <b>'.nickname($data[1]).'</b> <small>('.date_fixed($data[3]).')</small><br /><br />';

echo 'Cообщение:<br />';
echo '<textarea cols="50" rows="3" name="msg">'.$data[0].'</textarea><br /><br />';
echo '<input type="submit" value="Изменить" /></form><hr />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения для редактирования не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано сообщение для редактирования!</b><br />';}
	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	
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
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){

$file = file(DATADIR."book.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$msg = no_br($msg,'<br />');
$msg = smiles($msg);

$text = no_br($msg.'|'.$data[1].'|'.SITETIME.'|'.$data[3].'|'.$data[4].'|'.$data[5].'|'.$data[6].'|'.$log.'|');

replace_lines(DATADIR."book.dat", $id, $text);

header ("Location: book.php?start=$start&isset=mp_bookeditpost&".SID); exit();

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Сообщения для редактирования не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинный или короткий текст сообщения!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано сообщение для редактирования!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?action=edit&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                 Удаление сообщений                                     ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."book.dat", $del); 

header ("Location: book.php?start=$start&isset=mp_checkdelpost&".SID); exit();

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка удаления! Отсутствуют выбранные сообщения!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                 Подтверждение очистки                                  ##
############################################################################################
if ($action=="prodel") {
echo 'Вы уверены что хотите удалить все сообщения в гостевой?<br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="book.php?action=alldel&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Да, уверен!</a></b><br />';	
	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}


############################################################################################
##                                   Очистка гостевой                                     ##
############################################################################################
if ($action=="alldel") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

clear_files(DATADIR."book.dat");	

header ("Location: book.php?isset=mp_bookclear&".SID); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Очищать гостевую могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                  Пересчет гостевой                                     ##
############################################################################################
if ($action=="restatement") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

$count = counter_string(DATADIR."book.dat");

statistics(0, $count);

header ("Location: book.php?isset=mp_bookrestatement&".SID); exit;

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<b>Ошибка! Пересчитывать сообщения могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="book.php?'.SID.'">Вернуться</a>';
}


echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>