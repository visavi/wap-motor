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

show_title('partners.gif', 'Добавление сообщения');

$msg = check($_POST['msg']);
$uid = check($_GET['uid']);

############################################################################################
##                                  Добавление сообщения                                  ##
############################################################################################
if (is_user()) {
if ($uid==$_SESSION['token']){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){

antiflood("Location: index.php?isset=antiflood&".SID);
karantin($udata[6], "Location: index.php?isset=karantin&".SID);
statistics(0);

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$text = no_br($msg.'|'.$log.'||'.SITETIME.'|'.$brow.'|'.$ip.'|||');

write_files(DATADIR."book.dat", "$text\r\n");

$countstr = counter_string(DATADIR."book.dat");
if ($countstr>=$config['maxpostbook']) {
delete_lines(DATADIR."book.dat",array(0,1));
}

change_profil($log, array(9=>$udata[9]+1, 14=>$ip, 36=>$udata[36]+1, 41=>$udata[41]+1));

$_SESSION['note'] = 'Сообщение успешно добавлено!';
header ("Location: index.php?".SID); exit;

} else {show_error('Ошибка! Слишком длинное или короткое сообщение!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

############################################################################################
##                                    Добавление от гостей                                ##
############################################################################################
} elseif($config['bookadds']==1){

$provkod = (int)$_POST['provkod'];

if ($uid==$_SESSION['token']){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){
if ($provkod==$_SESSION['protect']){

$_SESSION['protect'] = "";
unset($_SESSION['protect']);

antiflood("Location: index.php?isset=antiflood&".SID);
statistics(0);

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$text = no_br($msg.'|'.$config['guestsuser'].'||'.SITETIME.'|'.$brow.'|'.$ip.'|||');

write_files(DATADIR."book.dat", "$text\r\n");

$countstr = counter_string(DATADIR."book.dat");
if ($countstr>=$config['maxpostbook']) {
delete_lines(DATADIR."book.dat",array(0,1));
}

$_SESSION['note'] = 'Сообщение успешно добавлено!';
header ("Location: index.php?".SID); exit;

} else {show_error('Ошибка! Проверочное число не совпало с данными на картинке!');}
} else {show_error('Ошибка! Слишком длинное или короткое сообщение!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}
} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
