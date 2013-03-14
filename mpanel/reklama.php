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

if (is_admin(array(101,102,103,105))){
	
echo'<img src="../images/img/menu.gif" alt="image" /> <b>Управление рекламой</b><br /><br />';	

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){	

echo 'Каждый админ или модер сможет добавить 1 рекламную ссылку которая будет в случайном порядке выводится на главную страницу вместе с другими ссылками старших сайта<br /><br />';

if (file_exists(DATADIR."reklama.dat")){
$filerek = file(DATADIR."reklama.dat"); 	

//---------------------- Обзор ссылок --------------------------------//
if (is_admin(array(101))){	

echo '<big><b>Список всех ссылок</b></big><br /><br />';

$total = count($filerek);

if ($total>0){

echo '<form action="reklama.php?action=delstr&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

foreach ($filerek as $key=>$val){

$dtrek = explode("|", $val);

echo '<input type="checkbox" name="del[]" value="'.$key.'" /> ';
echo '<img src="../images/img/edit.gif" alt="image" /> <b><a href="'.$dtrek[1].'">'.$dtrek[2].'</a></b> (Добавил: '.nickname($dtrek[3]).')<br />';

}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

} else {echo '<b>Ссылок еще нет!</b><br />';}

echo '<br />Всего ссылок: <b>'.(int)$total.'</b><hr />';
}

//-------------------------------------------------------------------//

$string = search_string(DATADIR."reklama.dat", $log, 3);
if ($string) {

//--------------------------- Изменение -------------------------------//
echo '<big><b>Изменение ссылки</b></big><br /><br />';

echo '<form action="reklama.php?action=edit&amp;id='.$string['line'].'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Ссылка:<br />';
echo '<input name="urlrek" value="'.$string[1].'" /> <br />';
echo 'Название:<br />';
echo '<input name="namerek" value="'.$string[2].'" /> <br /><br />';
echo '<input type="submit" value="Изменить" /></form><hr />';

echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="reklama.php?action=del&amp;del='.$string['line'].'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Удалить ссылку</a></b><br />';
} else {

//--------------------------- Добавление -------------------------------//
echo '<big><b>Добавление ссылки</b></big><br /><br />';

echo '<form action="reklama.php?action=add&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Ссылка:<br />';
echo '<input name="urlrek" value="http://" /> <br />';
echo 'Название:<br />';
echo '<input name="namerek" /> <br /><br />';
echo '<input type="submit" value="Добавить" /></form><hr />';

}

} else {echo '<b>Ошибка! Отстутствует файл рекламы!</b><br />';}

echo '<br />Вы можете добавить ссылку если вы этого еще не сделали, изменить или удалить ее если она уже имеется<br />';
}

############################################################################################
##                                   Добавление ссылки                                    ##
############################################################################################
if ($action=="add"){

$uid = check($_GET['uid']);
$urlrek = check($_POST['urlrek']);
$namerek = check($_POST['namerek']);

if ($uid==$_SESSION['token']){
if (strlen($urlrek)<=50) {
if (utf_strlen(trim($namerek))>=10 && utf_strlen($namerek)<=35) {
if (preg_match('#^http://([a-z0-9_\-\.])+(\.([a-z0-9\/])+)+$#',$urlrek)){

$string = search_string(DATADIR."reklama.dat", $log, 3);
if (empty($string)) {

$text = no_br('|'.$urlrek.'|'.$namerek.'|'.$log.'|');

write_files(DATADIR."reklama.dat", "$text\r\n");

header ("Location: reklama.php?isset=mp_addreklama&".SID); exit;

} else {echo '<b>Ошибка! Ваша ссылка уже добавлена!</b><br />';}
} else {echo '<b>Ошибка! Недопустимый адрес сайта! (http://sitename.domen)</b><br />';}
} else {echo '<b>Ошибка! Слишком длинное или короткое название! (от 10 до 35 символов)</b><br />';}
} else {echo '<b>Ошибка! Слишком длинный адрес ссылки (до 50 символов)</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="reklama.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                    Изменение ссылки                                    ##
############################################################################################
if ($action=="edit"){

$uid = check($_GET['uid']);
$urlrek = check($_POST['urlrek']);
$namerek = check($_POST['namerek']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($uid==$_SESSION['token']){
if ($id!==""){
if (strlen($urlrek)<=50) {
if (utf_strlen(trim($namerek))>=10 && utf_strlen($namerek)<=35) {
if (preg_match('#^http://([a-z0-9_\-\.])+(\.([a-z0-9\/])+)+$#',$urlrek)){

$string = search_string(DATADIR."reklama.dat", $log, 3);
if ($string) {

if ($id == $string['line']){

$text = no_br('|'.$urlrek.'|'.$namerek.'|'.$log.'|');

replace_lines(DATADIR."reklama.dat", $id, $text);

header ("Location: reklama.php?isset=mp_editreklama&".SID); exit;

} else {echo '<b>Ошибка! Нельзя изменять чужую ссылку!</b><br />';}
} else {echo '<b>Ошибка! Вашей ссылки нет в списке!</b><br />';} 
} else {echo '<b>Ошибка! Недопустимый адрес сайта! (http://sitename.domen)</b><br />';}
} else {echo '<b>Ошибка! Слишком длинное или короткое название! (от 10 до 35 символов)</b><br />';}
} else {echo '<b>Ошибка! Слишком длинный адрес ссылки (до 50 символов)</b><br />';}
} else {echo '<b>Ошибка! Отстутствует ID редактируемой ссылки!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="reklama.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                    Удаление ссылки                                     ##
############################################################################################
if ($action=="del"){

$uid = check($_GET['uid']);
if (isset($_GET['del'])) {$del = (int)$_GET['del'];} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

$string = search_string(DATADIR."reklama.dat", $log, 3);
if ($string){

if ($del == $string['line']){

delete_lines(DATADIR."reklama.dat", $del); 

header ("Location: reklama.php?isset=mp_delreklama&".SID); exit;

} else {echo '<b>Ошибка! Нельзя удалять чужую ссылку!</b><br />';} 
} else {echo '<b>Ошибка! Вашей ссылки нет в списке!</b><br />';}
} else {echo '<b>Ошибка! Отстутствует ID ссылки!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="reklama.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                   Админское удаление                                   ##
############################################################################################
if ($action=="delstr"){

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if (is_admin(array(101))){
if ($del!==""){

delete_lines(DATADIR."reklama.dat", $del); 

header ("Location: reklama.php?isset=mp_alldelreklama&".SID); exit;

} else {echo '<b>Ошибка! Отстутствуют ID выбранных ссылок!</b><br />';}
} else {echo '<b>Ошибка! Удалять ссылки могут только суперадмины!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="reklama.php?'.SID.'">Вернуться</a>';
}

//-------------------------------- КОНЦОВКА ------------------------------------//	
echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>