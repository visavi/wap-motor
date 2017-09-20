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

if (is_admin(array(101,102,103))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Управление антиматом</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo 'Все слова в списке будут заменяться на ***<br />';
echo 'Чтобы удалить слово нажмите на него, добавить слово можно в форме ниже<br /><br />';

$file = file(DATADIR."antimat.dat");
$total = count($file);

if ($total>0){

foreach($file as $key=>$value){
$data = explode("|",$value);

if ($key==0){
echo '<a href="antimat.php?action=del&amp;del='.$key.'&amp;uid='.$_SESSION['token'].'">'.$data[0].'</a>';
} else {
echo ', <a href="antimat.php?action=del&amp;del='.$key.'&amp;uid='.$_SESSION['token'].'">'.$data[0].'</a>';
}}

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Список пуст, добавьте слово!</b>';}

echo '<br /><br />Добавить слово:<br />';

echo '<form action="antimat.php?action=add&amp;uid='.$_SESSION['token'].'" method="post">';
echo '<input name="strmat" /> ';
echo '<input type="submit" value="Добавить" /></form><hr />';

echo 'Слова необходимо добавлять в нижнем регистре (маленькими буквами)<br /><br />';
echo 'Всего слов в базе: <b>'.(int)$total.'</b><br />';

if (is_admin(array(101))) {
if ($total>1){
echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="antimat.php?action=prodel">Очистить</a>';
}}
}

############################################################################################
##                                Добавление в список                                     ##
############################################################################################
if ($action=="add"){

$uid = check($_GET['uid']);
$strmat = check($_POST['strmat']);

if ($uid==$_SESSION['token']){
if ($strmat!=""){

$string = search_string(DATADIR."antimat.dat", $strmat, 0);
if (empty($string)){

write_files(DATADIR."antimat.dat", "$strmat|\r\n");

header ("Location: antimat.php?isset=mp_addmat"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Введенное слово уже имеетеся в списке!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не ввели слово для занесения в список!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="antimat.php">Вернуться</a>';
}


############################################################################################
##                                   Удаление из списка                                   ##
############################################################################################
if ($action=="del"){

$uid = check($_GET['uid']);
if (isset($_GET['del'])) {$del = (int)$_GET['del'];} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."antimat.dat", $del);

header ("Location: antimat.php?isset=mp_delmat"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка удаления! Отсутствуют выбранное слово!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="antimat.php">Вернуться</a>';
}

############################################################################################
##                                 Подтверждение очистки                                  ##
############################################################################################
if ($action=="prodel") {
echo 'Вы уверены что хотите удалить все слова в антимате?<br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="antimat.php?action=alldel&amp;uid='.$_SESSION['token'].'">Да уверен!</a></b><br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="antimat.php">Вернуться</a>';
}

############################################################################################
##                                   Очистка антимата                                    ##
############################################################################################
if ($action=="alldel") {

$uid = check($_GET['uid']);

if (is_admin(array(101))){
if ($uid==$_SESSION['token']){

clear_files(DATADIR."antimat.dat");

header ("Location: antimat.php?isset=mp_clearmat"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Очищать список антимата могут только суперадмины!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="antimat.php">Вернуться</a>';
}


//-------------------------------- КОНЦОВКА ------------------------------------//
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
