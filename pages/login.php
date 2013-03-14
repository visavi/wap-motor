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

if (isset($_COOKIE['cookname'])){$cookname = check($_COOKIE['cookname']);} else {$cookname = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Авторизация</b><br /><br />';

if (!is_user()){

echo '<form method="post" action="'.BASEDIR.'input.php?'.SID.'">';
echo 'Логин:<br /><input name="login" value="'.$cookname.'" /><br />';
echo 'Пароль:<br /><input name="pass" type="password" /><br /><br />';
if ($config['cookies']==1){
echo 'Запомнить меня:';
echo '<input name="cookietrue" type="checkbox" value="1" checked="checked" /><br /><br />';}
echo '<input value="Войти" type="submit" /></form><hr />';

echo '<a href="registration.php?'.SID.'">Регистрация</a><br />';
echo '<a href="../mail/lostpassword.php?'.SID.'">Забыли пароль?</a><br />';

echo '<br />Вы можете сделать закладку для быстрого входа, она будет иметь вид:<br />';
echo '<span style="color:#ff0000">'.$config['home'].'/input.php?login=ВАШ_ЛОГИН&amp;pass=ВАШ_ПАРОЛЬ</span><br />';

} else { echo '<b>Ошибка! Вы уже авторизованы</b><br />'; }

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once "../themes/".$config['themes']."/foot.php";
?>