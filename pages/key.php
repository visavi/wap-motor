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

echo '<img src="../images/img/site.png" alt="image" /> <b>Подтверждение регистрации</b><br /><br />';

if ($config['regkeys']>0){
if (is_user()){
if ($udata[46]>0){

if ($udata[46]==1){

############################################################################################
##                                 Форма ввода мастер-ключа                               ##
############################################################################################
if ($action==""){

echo 'Добро пожаловать, <b>'.check($log).'!</b><br />';	
echo 'Для подтверждения регистрации вам необходимо ввести мастер-ключ, который был отправлен вам на E-mail<br />';

echo '<form method="post" action="key.php?action=inkey&amp;'.SID.'"><br />';
echo 'Мастер-код:<br />';
echo '<input name="key" maxlength="30" /><br /><br />';
echo '<input value="Подтвердить" type="submit" /></form><hr />';

echo 'Пока вы не подтвердите регистрацию вы не сможете войти на сайт<br />';
echo 'Ваш профиль будет ждать активации в течении 24 часов, после чего автоматически удален<br />';

echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="../input.php?action=exit&amp;'.SID.'">Выход</a>';
}

############################################################################################
##                                   Проверка мастер-ключа                                ##
############################################################################################
if ($action=="inkey"){

if (isset($_GET['key'])){$key = check(trim($_GET['key']));} else {$key = check(trim($_POST['key']));}

if ($key!=""){	
if ($key==$udata[47]){

$string = search_string(DATADIR."datatmp/reglist.dat", $log, 0);
if ($string) {
delete_lines(DATADIR."datatmp/reglist.dat", $string['line']); 
}

change_profil($log, array(46=>0, 47=>''));

echo 'Мастер-код подтвержден, теперь вы можете войти на сайт!<br /><br />';
echo '<b><img src="../images/img/reload.gif" alt="image" /> <a href="../index.php?'.SID.'">Вход на сайт!</a></b><br />';

} else {echo 'Ошибка! Мастер-код не совпадает с данными, проверьте правильность ввода!<br />';}
} else {echo 'Ошибка! Вы не ввели мастер-код, пожалуйста повторите!<br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="key.php?'.SID.'">Вернуться</a>';
}}

############################################################################################
##                                 Разрешение администрации                               ##
############################################################################################
if ($udata[46]==2){

echo 'Добро пожаловать, <b>'.check($log).'!</b><br />';

echo 'Ваш аккаунт еще не прошел проверку администрацией<br />';
echo 'Если после авторизации вы видите эту страницу, то значит ваш профиль еще не активирован<br />';

echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="../input.php?action=exit&amp;'.SID.'">Выход</a>';
}


} else {echo '<b>Ошибка! Вашему профилю не требуется подтверждение регистрации</b><br />'; }
} else {echo '<b>Ошибка! Для подтверждение регистрации  необходимо быть авторизованным!';}
} else {echo '<b>Ошибка! Подтверждение регистрации выключено на сайте</b><br />'; }

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>