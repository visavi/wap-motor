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
if (isset($_GET['uz'])) {$uz=check($_GET['uz']);} elseif (isset($_POST['uz'])) {$uz=check($_POST['uz']);} else {$uz="";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Перевод денег</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

echo 'В наличии: '.moneys($udata[41]).'<br /><br />';

if($udata[36]<150){
echo 'Ваш статус не позволяет вам переводить деньги<br />';
echo 'Необходимо иметь в активе не менее 150 баллов<br />';
}

if ($uz==""){
echo '<form action="perevod.php?action=go&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Логин юзера:<br />';
echo '<input type="text" name="uz" maxlength="20" /><br />';
echo 'Кол-во денег:<br />';
echo '<input name="gold" /><br /><br />';
echo '<input type="submit" value="Перевести" /></form><hr />';
} else {
echo '<form action="perevod.php?action=go&amp;uz='.$uz.'&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Перевод для <b>'.$uz.'</b>:<br /><br />';
echo 'Кол-во денег:<br />';
echo '<input name="gold" /><br /><br />';
echo '<input type="submit" value="Перевести" /></form><hr />';
}
}

############################################################################################
##                                       Перевод                                          ##
############################################################################################
if($action=="go"){

$gold = (int)$_POST['gold'];
$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){
if ($gold>0){
if ($udata[36]>=150){
if ($gold<=$udata[41]){


if (preg_match('|^[a-z0-9_\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){
if ($uz!=$log){

$uzdata = reading_profil($uz);
change_profil($uz, array(10=>$uzdata[10]+1, 41=>$uzdata[41]+$gold));

change_profil($log, array(41=>$udata[41]-$gold, 74=>$udata[74]+300));
//------------------------Уведомление по привату------------------------//
if ($udata[74]<SITETIME){

$ignorstr = search_string(DATADIR."dataignor/$uz.dat", $log, 1);
if (empty($ignorstr)) {

$filesize = filesize(DATADIR.'privat/'.$uz.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);
if ($pers < 99){

$text = no_br($log.'|Пользователь '.nickname($log).' перечислил вам '.moneys($gold).'|'.SITETIME.'|');

write_files(DATADIR.'privat/'.$uz.'.priv', "$text\r\n");
}}}

echo 'Перевод успешно завершен! Пользователь <b>'.$uz.'</b> уведомлен о переводе.<br />';

} else {show_error('Произошла ошибка, нельзя переводить самому себе!');}
} else {show_error('Произошла ошибка, такого адресата не существует!');}
} else {show_error('Произошла ошибка, недопустимый логин!');}
} else {show_error('Недостаточно средств для перевода такого количества денег!');}
} else {show_error('Ваш статус не позволяет вам переводить деньги!');}
} else {show_error('Перевод невозможен укажите верную сумму!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="perevod.php">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, чтобы совершать операции, необходимо');}

echo '<br /><img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada">Развлечения</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
