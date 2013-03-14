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
require_once ("includes/start.php");
require_once ("includes/functions.php");
require_once ("includes/header.php");
include_once ("themes/".$config['themes']."/index.php");

if (empty($_GET['p'])){

include_once ("includes/info.php");

if (is_user()){
echo '<img src="images/img/act1.gif" alt="image" /> <a href="pages/index.php?action=menu&amp;'.SID.'">Мое меню</a><br />';

if (is_admin(array(101,102))){
echo '<img src="images/img/act2.gif" alt="image" /> <a href="'.ADMINDIR.'index.php?'.SID.'">Админ-панель</a><br />';
}
 
if (is_admin(array(103,105))){
echo '<img src="images/img/act2.gif" alt="image" /> <a href="'.ADMINDIR.'index.php?'.SID.'">Mодер-панель</a><br />';
}
	
} else {
echo '<img src="images/img/act1.gif" alt="image" /> <a href="pages/login.php?'.SID.'">Авторизация</a><br />';
echo '<img src="images/img/act2.gif" alt="image" /> <a href="pages/registration.php?'.SID.'">Регистрация</a><br />';
echo '<img src="images/img/act2.gif" alt="image" /> <a href="mail/lostpassword.php?'.SID.'">Забыли пароль?</a><br />';
}

include_once (DATADIR."datamain/index.dat");

} else {

if (empty($_GET['f'])) {$_GET['f'] = 'index';}

if (preg_match('|^[a-z0-9_\-]+$|i', $_GET['p']) && preg_match('|^[a-z0-9_\-]+$|i', $_GET['f'])){

if (file_exists($_GET['p'].'/'.$_GET['f'].'.'.$config['ras'])){

include_once ($_GET['p'].'/'.$_GET['f'].'.'.$config['ras']);

} else {echo '<img src="images/img/error.gif" alt="image" /> <b>Ошибка! Файл с данными параметрами не найден!</b><br />';}
} else {echo '<img src="images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимое название страницы!</b><br />';}

echo '<br /><img src="'.BASEDIR.'images/img/act_home.gif" alt="image" /> <a href="'.BASEDIR.'index.php?'.SID.'">На главную</a>';
}

include_once ("themes/".$config['themes']."/foot.php");
?>