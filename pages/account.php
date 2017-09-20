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

echo '<img src="../images/img/profiles.gif" alt="image" /> <b>Мои данные</b><br /><br />';

if (is_user()){
if ($action==""){

############################################################################################
##                                    Изменение e-mail                                    ##
############################################################################################

echo '<b><big>Изменение E-mail</big></b><br /><br />';

if ($udata[36]>=150){
echo '<form method="post" action="account.php?action=editmail&amp;uid='.$_SESSION['token'].'">';

echo 'Е-mail:<br />';
echo '<input name="meil" value="'.$udata[4].'" /><br />';

$string = search_string(DATADIR."subscribe.dat", $log, 3);
if (empty($string)) {
echo '<br /><input name="subnews" type="checkbox" value="yes" /> Подпиcаться на новости<br />';
} else {
echo '<br /><input name="subnews" type="checkbox" value="no" /> Отписаться от новостей<br />';}

echo 'Подтверждение пароля:<br />';
echo '<input name="provpass" type="password" /><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';

} else {echo '<b>Изменять e-mail могут пользователи у которых более 150 баллов!</b><hr />';}

############################################################################################
##                                Изменение ника                                          ##
############################################################################################
echo '<b><big>Изменение ника</big></b><br /><br />';

if ($config['includenick']==1){
if ($udata[36]>=300){

echo '<form method="post" action="nickname.php?uid='.$_SESSION['token'].'">';
echo 'Ваш ник:<br />';
echo '<input name="nickname" value="'.$udata[65].'" /><br />';
echo '<br /><input value="Изменить" type="submit" /></form><hr />';

} else {echo '<b>Изменять ник могут пользователи у которых более 300 баллов!</b><hr />';}
} else {echo '<b>Измение ника запрещено администрацией!</b><hr />';}


############################################################################################
##                                    Изменение пароля                                    ##
############################################################################################
echo '<b><big>Изменение пароля</big></b><br /><br />';

echo '<form method="post" action="newpass.php?uid='.$_SESSION['token'].'">';
echo 'Новый пароль:<br /><input name="newpar" maxlength="20" /><br />';
echo 'Повторите пароль:<br /><input name="newpar2" maxlength="20" /><br />';
echo 'Старый пароль:<br /><input name="oldpar" maxlength="20" /><br />';
echo '<br /><input value="Изменить" type="submit" /></form><hr />';
}

############################################################################################
##                                     Изменение e-mail                                   ##
############################################################################################
if ($action=="editmail") {

$uid = check($_GET['uid']);
$meil = strtolower(check($_POST['meil']));
$provpass = check($_POST['provpass']);
if (isset($_POST['subnews'])) {$subnews = check($_POST['subnews']);} else {$subnews = '';}

if ($uid==$_SESSION['token']){
if ($udata[36]>=150){
if (md5(md5($provpass))==$udata[1]){
if (preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#', $meil)) {

$string = search_string(DATADIR."blackmail.dat", $meil, 1);
if (empty($string)) {

change_profil($log, array(4=>$meil));

//--------------------------------------------------------------------//
if ($subnews=="yes"){

$logstring = search_string(DATADIR."subscribe.dat", $log, 3);
$mailstring = search_string(DATADIR."subscribe.dat", $meil, 0);

if (empty($logstring) && empty($mailstring)) {

$text = no_br($meil.'|'.generate_password().'|'.SITETIME.'|'.$log.'|');

write_files(DATADIR."subscribe.dat", "$text\r\n");
}}

//--------------------------------------------------------------------//
if ($subnews=="no"){

$string = search_string(DATADIR."subscribe.dat", $log, 3);
if ($string) {

delete_lines(DATADIR."subscribe.dat", $string['line']);
}}

header ("Location: account.php?isset=editaccount"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Указанный вами адрес e-mail занесен в черный список</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Неправильный адрес e-mail, необходим формат name@site.domen</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Пароль не совпадает с данными в профиле</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Изменять e-mail могут пользователи у которых более 150 баллов!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="account.php">Вернуться</a><br />';
}

} else {show_login('Вы не авторизованы, чтобы изменять свои данные, необходимо');}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
