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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Регистрация</b><br /><br />';

if ($config['openreg']==1){

if (!is_user()){

echo 'Регистрация на сайте означает что вы ознакомлены и согласны с <b><a href="pravila.php">правилами</a></b> нашего сайта<br />';
echo 'Длина логина или пароля должна быть от 3 до 20 символов<br />';
echo 'В полях логин и пароль разрешено использовать только знаки латинского алфавита и цифры, а также знак тире!<br />';

if ($config['regkeys']==1){
echo '<span style="color:#ff0000">Включено подтверждение регистрации! Вам на почтовый ящик будет выслан мастер-ключ, который необходим для подтверждения регистрации!</span><br />';
}

if ($config['regkeys']==2){
echo '<span style="color:#ff0000">Включена модерация регистрации! Ваш аккаунт будет активирован только после проверки администрацией!</span><br />';
}

if ($config['karantin']>0){
echo '<span style="color:#ff0000">Включен карантин! Новые пользователи не могут писать сообщения в течении '.round($config['karantin']/3600).' час. после регистрации!</span><br />';
}

echo '<br /><form method="post" action="reguser.php">';
echo 'Логин: <br /><input name="logs" maxlength="40" /><br />';
echo 'Пароль: <br /><input name="pars" type="password" maxlength="20" /><br />';
echo 'Повторите пароль: <br /><input name="pars2" type="password" maxlength="20" /><br />';
echo 'Ваш e-mail: <br /><input name="meil" maxlength="50" /><br />';
echo 'Проверочный код: ';

if ($config['protectimg']==1){
echo '<img src="../gallery/protect.php" alt="" /><br />';
} else {
echo '<b>'.$_SESSION['protect'].'</b><br />';
}
echo '<input name="provkod" maxlength="6" /><br />';
echo '<br /><input value="Регистрация" name="do" type="submit" /></form><hr />';

echo 'Обновите страницу если вы не видите проверочный код!<br />';
echo 'Все поля обязательны для заполнения, более полную информацию о себе вы можете добавить в своем профиле после регистрации<br />';
echo 'Указывайте верный е-мэйл, на него будут высланы регистрационные данные<br /><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Вы уже регистрировались, нельзя регистрироваться несколько раз</b><br /><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Регистрация временно приостановлена, пожалуйста зайдите позже!</b><br /><br />';}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
