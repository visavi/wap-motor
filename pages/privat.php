<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#	
require_once "../includes/start.php";
require_once "../includes/functions.php";
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}
if (isset($_GET['uz'])) {$uz=check($_GET['uz']);} elseif (isset($_POST['uz'])) {$uz=check($_POST['uz']);} else {$uz="";}

show_title('mails.gif', 'Приватные сообщения');

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action=="") {
	
if ($udata[10]>0){
change_profil($log, array(10=>0));
}

$filesize = filesize(DATADIR.'privat/'.$log.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);

echo '<img src="../images/img/mail2.gif" alt="image" /> <b>Входящие</b> | <a href="privat.php?action=output&amp;'.SID.'">Отправленные</a><br />';

if ($udata[10]>0){echo 'Получено новых писем: <b>'.(int)$udata[10].'</b><br />';}

if ($pers>80 && $pers<98){
echo '<div style="text-align:center"><b><span style="color:#ff0000">Ваш ящик заполнен на '.$pers.'%, необходимо очистить или удалить старые сообщения!</span></b></div>';}

if ($pers>=98){
echo '<div style="text-align:center"><b><span style="color:#ff0000">Ваш ящик переполнен, вы не сможете получать письма, пока не очистите его!</span></b></div>';}

if (file_exists(DATADIR.'privat/'.$log.'.priv')){
$file = file(DATADIR.'privat/'.$log.'.priv');
$file = array_reverse($file);
$total = count($file);

if ($total>0){

echo '<form action="privat.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['privatpost']){ $end = $total; }
else {$end = $start + $config['privatpost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

echo '<div class="b">';

echo user_avatars($data[0]);
echo '<b><a href="anketa.php?uz='.$data[0].'&amp;'.SID.'">'.nickname($data[0]).'</a></b> '.user_online($data[0]).' ('.date_fixed($data[2]).')<br />';
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<a href="privat.php?action=submit&amp;uz='.$data[0].'&amp;'.SID.'">Ответить</a> | ';
echo '<a href="kontakt.php?action=add&amp;uz='.$data[0].'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">В контакт</a> | ';
echo '<a href="ignor.php?action=add&amp;uz='.$data[0].'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Игнор</a></div>';

echo '<div>'.bb_code($data[1]).'</div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('privat.php?', $config['privatpost'], $start, $total);
page_strnavigation('privat.php?', $config['privatpost'], $start, $total);


echo '<br /><br />Всего писем: <b>'.(int)$total.'</b><br />';
echo 'Объем ящика: <b>'.(int)$pers.'%</b><br />';

echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="privat.php?action=alldel&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Очистить ящик</a>';

} else {show_error('Входящих писем еще нет!');}
} else {show_error('Входящих писем еще нет!');}

echo '<br /><img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;'.SID.'">Написать письмо</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="privat.php?rand='.mt_rand(100,999).'&amp;'.SID.'">Обновить список</a><br />';
}

############################################################################################
##                                   Отправка привата                                     ##
############################################################################################
if ($action=="submit"){
echo '<img src="../images/img/mail2.gif" alt="image" /> <b>Отправка почты</b><br /><br />';

if ($uz==""){
echo '<form method="post" action="privat.php?action=send&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';
echo 'Введите логин:<br />';
echo '<input type="text" name="uz" maxlength="20" /><br />';
echo 'Текст:<br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input value="Отправить" name="do" type="submit" /></form><hr />';

} else {

echo '<form method="post" action="privat.php?action=send&amp;uz='.$uz.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';
echo 'Сообщение для <b>'.nickname($uz).'</b>:<br /><br />';
echo 'Текст:<br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input value="Отправить" name="do" type="submit" /></form><hr />';
}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="privat.php?'.SID.'">Вернуться в приват</a><br />';
}

############################################################################################
##                                 Исходящие сообщения                                    ##
############################################################################################
if ($action=="output"){	
echo '<img src="../images/img/mail2.gif" alt="image" /> <a href="privat.php?'.SID.'">Входящие</a> | <b>Отправленные</b><br />';

if (file_exists(DATADIR.'dataoutput/'.$log.'.priv')){
$file = file(DATADIR.'dataoutput/'.$log.'.priv');
$file = array_reverse($file);
$total = count($file);

if ($total>0){
echo '<form action="privat.php?action=outdel&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['privatpost']){ $end = $total; }
else {$end = $start + $config['privatpost']; }
for ($i = $start; $i < $end; $i++){

$num = $total - $i - 1;
$data = explode("|",$file[$i]);

echo '<div class="b">';
echo user_avatars($data[0]);
echo 'Получатель: <b><a href="anketa.php?uz='.$data[0].'&amp;'.SID.'">'.nickname($data[0]).'</a></b> ('.date_fixed($data[2]).')<br />';
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<a href="privat.php?action=submit&amp;uz='.$data[0].'&amp;'.SID.'">Написать еще</a></div>'; 

echo '<div>Текст письма: '.bb_code($data[1]).'</div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('privat.php?action=output&amp;', $config['privatpost'], $start, $total);
page_strnavigation('privat.php?action=output&amp;', $config['privatpost'], $start, $total);

echo '<br /><br /><img src="../images/img/error.gif" alt="image" /> <a href="privat.php?action=alloutdel&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Очистить ящик</a>';

} else {show_error('Отправленных писем еще нет!');}
} else {show_error('Отправленных писем еще нет!');}

echo '<br /><img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;'.SID.'">Написать письмо</a><br />';
}


############################################################################################
##                                   Отправка сообщений                                   ##
############################################################################################
if ($action=="send"){

$uid = check($_GET['uid']);
$msg = check($_POST['msg']);

if ($uid==$_SESSION['token']){
if ($uz!=$log){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){
if (preg_match('|^[a-z0-9_\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){

$filesize = filesize(DATADIR.'privat/'.$uz.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);
if ($pers < 100){

$string = search_string(DATADIR."dataignor/$uz.dat", $log, 1);
if (empty($string)) {

antiflood("Location: privat.php?action=submit&isset=antiflood&uz=$uz&".SID);

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$text = no_br($log.'|'.$msg.'|'.SITETIME.'|'); 

write_files(DATADIR.'privat/'.$uz.'.priv', "$text\r\n");

$uzdata = reading_profil($uz);
change_profil($uz, array(10=>$uzdata[10]+1));

$sendtext = no_br($uz.'|'.$msg.'|'.SITETIME.'|'); 

write_files(DATADIR.'dataoutput/'.$log.'.priv', "$sendtext\r\n", 0, 0666);

$countstr = counter_string(DATADIR.'dataoutput/'.$log.'.priv');
if ($countstr>=20) {
delete_lines(DATADIR.'dataoutput/'.$log.'.priv', 0);
}

header ("Location: privat.php?isset=mail&".SID); exit;

} else {show_error('Ошибка! Вы внесены в игнор-лист получателя!');}
} else {show_error('Ошибка! Ящик получателя переполнен!');}
} else {show_error('Ошибка! Такого адресата не существует!');}
} else {show_error('Ошибка! Недопустимый логин пользователя!');}
} else {show_error('Ошибка! Слишком длинное или короткое сообщение!');}
} else {show_error('Ошибка! Нельзя отправлять письмо самому себе!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="privat.php?action=submit&amp;uz='.$uz.'&amp;'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/reload.gif" alt="image" /> <a href="privat.php?'.SID.'">К письмам</a><br />';
}
############################################################################################
##                                   Очистка сообщений                                    ##
############################################################################################
if ($action=="alldel") {

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if (empty($udata[10])){

clear_files(DATADIR.'privat/'.$log.'.priv');

header ("Location: privat.php?isset=alldelpriv&".SID); exit;

} else {show_error('Ошибка! У вас имеются непрочитанные сообщения!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="privat.php?'.SID.'">Вернуться</a><br />';
}

############################################################################################
##                           Очистка отправленных сообщений                               ##
############################################################################################
if ($action=="alloutdel") {

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){

clear_files(DATADIR.'dataoutput/'.$log.'.priv');

header ("Location: privat.php?action=output&isset=alldelpriv&".SID); exit;

} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="privat.php?action=output&amp;'.SID.'">Вернуться</a><br />';
}

############################################################################################
##                                 Удаление сообщений                                     ##
############################################################################################
if ($action=="del"){

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR.'privat/'.$log.'.priv', $del);

header ("Location: privat.php?start=$start&isset=selectpriv&".SID);  exit;

} else {show_error('Ошибка удаления! Отсутствуют выбранные сообщения!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="privat.php?start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
}

############################################################################################
##                           Удаление отправленных сообщений                              ##
############################################################################################
if ($action=="outdel"){
$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR.'dataoutput/'.$log.'.priv', $del);

header ("Location: privat.php?action=output&start=$start&isset=selectpriv&".SID); exit;

} else {show_error('Ошибка удаления! Отсутствуют выбранные сообщения!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="privat.php?action=output&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
}

} else {show_login('Вы не авторизованы, для просмотра писем, необходимо');}

echo '<img src="../images/img/chat.gif" alt="image" /> <a href="kontakt.php?'.SID.'">Контакт</a> / <a href="ignor.php?'.SID.'">Игнор</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">Вернуться на главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>