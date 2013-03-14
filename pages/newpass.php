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
   	   
echo '<img src="../images/img/profiles.gif" alt="image" /> <b>Изменение пароля</b><br /><br />';

if (is_user()){

$newpar = check($_POST['newpar']);
$newpar2 = check($_POST['newpar2']);
$oldpar = check($_POST['oldpar']);

if (preg_match('|^[a-z0-9\-]+$|i',$newpar)){
if ($log!=$newpar){
if ($newpar==$newpar2){
if (md5(md5($oldpar))==$udata[1]){
if (!ctype_digit($newpar)){
if (strlen($newpar)<=20 && strlen($newpar)>=3){

change_profil($log, array(1=>md5(md5($newpar))));

//------------------------- Уведомление о регистрации на E-mail --------------------------//
if($udata[4]!=""){
addmail($udata[4], "Изменение пароля на сайте ".$config['title'], "Здравствуйте, ".$log." \nВами была произведена операция по изменению пароля \n\nВаш новый пароль: ".$newpar." \nСохраните его в надежном месте \n\nДанные инициализации: \nIP: ".$ip." \nБраузер: ".$brow." \nВремя: ".date('j.m.y / H:i',SITETIME));
}
//----------------------------------------------------------------------------------------//

setcookie('cookpar', '');
setcookie('cooklog', '');
setcookie(session_name(), '');
session_destroy();
session_unset();

header ("Location: ".BASEDIR."index.php?isset=editpass&".SID); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком длинный или короткий новый пароль (От 3 до 20 символов)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Запрещен пароль состоящий только из цифр, используйте буквы</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Старый пароль не совпадает с данными в профиле!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Новые пароли не совпадают!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Пароль и логин должны отличаться друг от друга</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Недопустимые символы в пароле, только знаки латинского алфавита и цифры</b><br />';}

} else {show_login('Вы не авторизованы, чтобы изменять свой пароль, необходимо');}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="profil.php?'.SID.'">Вернуться</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>