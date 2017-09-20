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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Выбор ника</b><br /><br />';

$nickname = check(trim($_POST['nickname']));

if (is_user()){

if ($config['includenick']==1){

if ($udata[36]>=150){
if ($udata[75]<SITETIME){

if (empty($nickname)){

//------------------------------ Запись в профиль ----------------------------//
change_profil($log, array(14=>$ip, 65=>"", 75=>SITETIME + 86400));

header ("Location: ".BASEDIR."index.php?isset=delnick"); exit;
}

//------------------------------------------------------------------------------//
if (preg_match('|^[0-9a-zA-Zа-яА-ЯЁё_\.\-\s]+$|u', $nickname)){
if (utf_strlen(trim($nickname))>=3 && utf_strlen(trim($nickname))<=20){
if ($nickname!=$udata[65]){

$reguserlogin = search_string(DATADIR."datatmp/reguser.dat", rus_utf_tolower($nickname), 0);
$regusernick = search_string(DATADIR."datatmp/reguser.dat", rus_utf_tolower($nickname), 2);
$blacklogin = search_string(DATADIR."blacklogin.dat", rus_utf_tolower($nickname), 1);

//------------------- Проверка на уникальность ника ----------------------//
if (empty($blacklogin)){
if (empty($reguserlogin)){
if (empty($regusernick)){

//------------------------------ Запись в профиль ----------------------------//
change_profil($log, array(14=>$ip, 65=>$nickname, 75=>SITETIME + 86400));

header ("Location: ".BASEDIR."index.php?isset=editnick");  exit;

} else {show_error('К сожалению выбранный вами ник уже занят!');}
} else {show_error('К сожалению выбранный вами ник используется кем-то в качестве логина!');}
} else {show_error('К сожалению выбранный вами ник занесен в черный список!');}
} else {show_error('Ошибка изменения, вы уже используете этот ник!');}
} else {show_error('Ошибка, слишком длинный или короткий ник!');}
} else {show_error('Вы ввели недопустимые символы, разрешены символы русского и латинского алфавита, а также цифры!');}
} else {show_error('Изменять ник можно не чаще чем 1 раз в сутки!');}
} else {show_error('У вас недостаточно баллов для изменения ника!');}
} else {show_error('Ошибка, изменение ника запрещено администрацией сайта!');}

} else {show_login('Вы не авторизованы, чтобы изменять свой ник, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="account.php">Вернуться</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

include_once"../themes/".$config['themes']."/foot.php";
?>
