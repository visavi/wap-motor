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

if (isset($_GET['id'])) {$id = (int)$_GET['id'];}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

show_title('partners.gif', 'Добавление объявления');

if (is_user()){
############################################################################################
##                              Форма добавления объявления                               ##
############################################################################################
if ($action==""){	

if (search_string(DATADIR."databoard/database.dat", $id, 2)) {

echo '<form action="add.php?action=add&amp;id='.$id.'&amp;'.SID.'" method="post">';
echo '<b>Заголовок:</b><br /><input type="text" name="zag" maxlength="50" /><br />';
echo '<b>Объявление:</b><br /><textarea cols="25" rows="3" name="msg"></textarea><br />';	
echo '<b>Срок показа:</b><br /><select name="days">';

for($i=5; $i<=$config['boarddays']; $i=$i+5){
echo '<option  value="'.$i.'">'.$i.' дней</option>';	
}


echo '</select><br /> (Максимальный срок показа -  <b>'.(int)$config['boarddays'].'</b> дней.)<br /><br />';
echo '<input type="submit" value="Добавить" /></form><hr />';

} else {show_error('Ошибка! Данного раздела не существует!');}	

}
	
############################################################################################
##                                  Добавление объявления                                 ##
############################################################################################
if ($action=="add"){	

if (search_string(DATADIR."databoard/database.dat", $id, 2)) {	

$zag = check($_POST['zag']);
$msg = check($_POST['msg']);
$days = (int)$_POST['days'];

if (utf_strlen(trim($zag))>=5 && utf_strlen($zag)<=50){
if (utf_strlen(trim($msg))>=10 && utf_strlen($msg)<=1000){
if ($days>0 && $days<=$config['boarddays']){	

antiflood("Location: add.php?id=$id&isset=antiflood&".SID);
karantin($udata[6], "Location: add.php?id=$id&isset=karantin&".SID);

$deltime = SITETIME + ($days * 86400);	

$msg = no_br($msg,'<br />');

$unifile = unifile(DATADIR."databoard/$id.dat", 5);

$text = no_br($zag.'|'.$log.'|'.$msg.'|'.SITETIME.'|'.$deltime.'|'.$unifile.'|'.$id.'|');

write_files(DATADIR."databoard/$id.dat", "$text\r\n", 0, 0666);

header ("Location: index.php?action=board&id=$id&isset=addboard&".SID);	exit;

} else {show_error('Ошибка, не указано число дней показа объявления!');}
} else {show_error('Слишком длинное или короткое объявление (Необходимо от 10 до 1000 символов)');}
} else {show_error('Слишком длинный или короткий заголовок (Необходимо от 5 до 50 символов)');}
} else {show_error('Ошибка! Данной рубрики не существует!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="add.php?id='.$id.'&amp;'.SID.'">Вернуться</a>';	
}

} else {show_login('Вы не авторизованы, чтобы добавить объявление, необходимо');}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="index.php?'.SID.'">Объявления</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>
