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

if (is_admin(array(101,102))){

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Управление заголовками</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$file = file(DATADIR."headlines.dat");
$total = count($file);    

if ($total>0) {
echo '<form action="headlines.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['headlines']){ $end = $total; }
else {$end = $start + $config['headlines']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<input type="checkbox" name="del[]" value="'.$i.'" /> ';
echo '<img src="../images/img/edit.gif" alt="image" /> <b><a href="headlines.php?action=edit&amp;id='.$i.'&amp;start='.$start.'&amp;'.SID.'">'.$data[2].'</a></b> ('.$data[1].')<br />';
}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('headlines.php?', $config['headlines'], $start, $total);
page_strnavigation('headlines.php?', $config['headlines'], $start, $total);


echo '<br /><br />Всего заголовков: <b>'.(int)$total.'</b><br />';

} else {echo '<br /><img src="../images/img/reload.gif" alt="image" /> <b>Заголовков еще нет!</b><br />';}

echo '<br /><img src="../images/img/edit.gif" alt="image" /> <a href="headlines.php?action=add&amp;start='.$start.'&amp;'.SID.'">Добавить</a>';
}

############################################################################################
##                               Подготовка к редактированию                              ##
############################################################################################
if($action=="edit") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!==""){

$file = file(DATADIR."headlines.dat");

if (isset($file[$id])){
$data = explode("|",$file[$id]);

echo '<form action="headlines.php?id='.$id.'&amp;action=addedit&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Страница: <br /><input type="text" name="headstr" value="'.$data[1].'" /><br />';
echo 'Название: <br /><input type="text" name="headname" value="'.$data[2].'" /><br />';
echo '<br /><input type="submit" value="Изменить" /></form><hr />';

} else {echo '<b>Ошибка! Данного заголовка не существует!</b><br />';}
} else {echo '<b>Ошибка! Не выбран заголовок для редактирования!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="headlines.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                                     Редактирование                                     ##
############################################################################################
if ($action=="addedit") {

$uid = check($_GET['uid']);
$headstr = check($_POST['headstr']);
$headname = check($_POST['headname']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){
if ($headstr!="" && $headname!=""){

$text = no_br('|'.$headstr.'|'.$headname.'|');

replace_lines(DATADIR."headlines.dat", $id, $text);

header ("Location: headlines.php?start=$start&isset=mp_headlines&".SID); exit;

} else {echo '<b>Ошибка! Не указан заголовок или название!</b><br />';}
} else {echo '<b>Ошибка! Не выбран заголовок для редактирования!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="headlines.php?action=edit&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/back.gif" alt="image" /> <a href="headlines.php?start='.$start.'&amp;'.SID.'">К списку</a>';
}

############################################################################################
##                                  Подготовка к добавлению                               ##
############################################################################################
if ($action=="add") {

echo '<form action="headlines.php?action=addstr&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Страница: <br /><input type="text" name="headstr" /><br />';
echo 'Название: <br /><input type="text" name="headname" /><br />';
echo '<br /><input type="submit" value="Добавить" /></form><hr />';

echo '<img src="../images/img/back.gif" alt="image" /> <a href="headlines.php?'.SID.'">Вернуться</a>';
}


############################################################################################
##                                         Добавление                                     ##
############################################################################################
if ($action=="addstr") {

$uid = check($_GET['uid']);
$headstr = check($_POST['headstr']);
$headname = check($_POST['headname']);

if ($uid==$_SESSION['token']){
if ($headstr!="" && $headname!=""){

$text = no_br('|'.$headstr.'|'.$headname.'|');

write_files(DATADIR."headlines.dat", "$text\r\n");

header ("Location: headlines.php?start=$start&isset=mp_addheadlines&".SID); exit;

} else {echo '<b>Ошибка! Не указан заголовок или название!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="headlines.php?action=add&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/back.gif" alt="image" /> <a href="headlines.php?start='.$start.'&amp;'.SID.'">К списку</a>';
}

############################################################################################
##                                   Удаление заголовков                                  ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if (is_admin(array(101))){
if ($del!==""){

delete_lines(DATADIR."headlines.dat", $del); 

header ("Location: headlines.php?start=$start&isset=mp_headdel&".SID); exit;

} else {echo '<b>Ошибка! Отстутствуют ID выбранных заголовков!</b><br />';}
} else {echo '<b>Ошибка! Удалять заголовки может только суперадмины!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="headlines.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';

}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>