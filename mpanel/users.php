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

if (is_admin(array(101,102))){

echo '<img src="../images/img/site.png" alt="image" /> <b>Управление пользователями</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){
echo '<form method="post" action="users.php?action=edit">';
echo 'Введите логин юзера:<br />';
echo '<input type="text" name="users" maxlength="20" /><br /><br />';
echo '<input value="Получить данные" type="submit" /></form><hr />';

echo 'Введите логин пользователя который необходимо отредактировать<br />';
}


############################################################################################
##                                    Просмотр профиля                                    ##
############################################################################################
if ($action=="edit"){

if (isset($_POST['users'])){$users = check($_POST['users']);} else {$users = check($_GET['users']);}

if ($users!=""){
if (file_exists(DATADIR."profil/$users.prof")){

$uzdata = reading_profil($users);

echo '<img src="../images/img/user.gif" alt="image" /> <b>Профиль '.$users.'</b> '.user_visit($users).'<br /><br />';

if ($log==$config['nickname'] || $users==$log || ($uzdata[7]<101 || $uzdata[7]>105)){
if ($users==$log) {echo '<b><span style="color:#ff0000">Внимание! Вы редактируете cобственный аккаунт!</span></b><br /><br />';}

echo '<form method="post" action="users.php?action=upgrade&amp;users='.$users.'&amp;uid='.$_SESSION['token'].'">';

if ($log==$config['nickname']){
$arr_access = array(101,102,103,105,107);

echo 'Уровень доступа:<br />';
echo '<select name="ud7"><option value="'.$uzdata[7].'">'.user_status($uzdata[7]).'</option>';

foreach ($arr_access as $value){
if ($value!=$uzdata[7]){
echo '<option value="'.$value.'">'.user_status($value).'</option>';
}}
echo '</select><br />';
}

echo 'Новый пароль: (Oставьте пустым если не надо менять)<br />';
echo '<input name="ud1" /><br />';
echo 'Откуда:<br />';
echo '<input name="ud2" value="'.$uzdata[2].'" /><br />';
echo 'Инфа:<br />';
echo '<input name="ud3" value="'.$uzdata[3].'" /><br />';
echo 'Е-мэил:<br />';
echo '<input name="ud4" value="'.$uzdata[4].'" /><br />';
echo 'Сайт:<br />';
echo '<input name="ud5" value="'.$uzdata[5].'" /><br />';
echo 'Зарегистрирован:<br />';
echo '<input name="ud6" value="'.date_fixed($uzdata[6],"j.m.Y").'" /><br />';
echo 'Мобила:<br />';
echo '<input name="ud13" value="'.$uzdata[13].'" /><br />';
echo 'ICQ:<br />';
echo '<input name="ud19" value="'.$uzdata[19].'" /><br />';
echo 'Имя юзера:<br />';
echo '<input name="ud29" value="'.$uzdata[29].'" /><br />';
echo 'Ник юзера:<br />';
echo '<input name="ud65" value="'.$uzdata[65].'" /><br />';
echo 'Актив:<br />';
echo '<input name="ud36" value="'.$uzdata[36].'" /><br />';
echo 'Особый статус:<br />';
echo '<input name="ud40" value="'.$uzdata[40].'" /><br />';
echo 'Деньги:<br />';
echo '<input name="ud41" value="'.$uzdata[41].'" /><br />';
echo 'Аватар:<br />';
echo '<input name="ud43" value="'.$uzdata[43].'" /><br />';
echo 'Авторитет:<br />';
echo '<input name="ud49" value="'.$uzdata[49].'" /><br /><br />';

if ($uzdata[37]==1 && $uzdata[38]>SITETIME){echo '<span style="color:#ff0000"><b>Юзер забанен</b></span><br />';}
if ($uzdata[46]==1){echo '<span style="color:#ff0000"><b>Аккаунт не активирован</b></span><br />';}
echo 'Общее число банов: <b>'.(int)$uzdata[64].'</b><br />';
echo 'Авторизация: '.date_fixed($uzdata[44], 'j F Y / H:i').'<br />';
echo 'IP: <b>'.$uzdata[14].'</b><br />';

echo '<br /><input value="Изменить" type="submit" /></form><hr />';

if ($uzdata[7]<101 || $uzdata[7]>105){
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="users.php?action=poddel&amp;users='.$users.'">Удалить профиль</a></b>';}

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, у вас недостаточно прав для редактирования этого профиля!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, необходимо ввести логин пользователя!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="users.php">Вернуться</a>';
}



############################################################################################
##                                   Изменение профиля                                    ##
############################################################################################
if ($action=="upgrade"){

$uid = check($_GET['uid']);
$users = check($_GET['users']);
if (isset($_POST['ud7'])){$ud7 = (int)$_POST['ud7'];}

$ud1 = check(no_br($_POST['ud1']));
$ud2 = check(no_br($_POST['ud2']));
$ud3 = check(no_br($_POST['ud3']));
$ud4 = check(no_br($_POST['ud4']));
$ud5 = check(no_br($_POST['ud5']));
$ud6 = check(no_br($_POST['ud6']));
$ud13 = check(no_br($_POST['ud13']));
$ud19 = check(no_br($_POST['ud19']));
$ud29 = check(no_br($_POST['ud29']));
$ud36 = (int)$_POST['ud36'];
$ud40 = check(no_br($_POST['ud40']));
$ud41 = (int)$_POST['ud41'];
$ud43 = check(no_br($_POST['ud43']));
$ud49 = (int)$_POST['ud49'];
$ud65 = check(no_br($_POST['ud65']));

if ($uid==$_SESSION['token']){
if (file_exists(DATADIR."profil/$users.prof")) {
if ($ud1=="" || preg_match('|^[a-z0-9\-]+$|i',$ud1)){
if (preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#',$ud4)){
if ($ud5=="" || preg_match('|^https?://([а-яa-z0-9_\-\.])+(\.([а-яa-z0-9\/\-?_=#])+)+$|iu',$ud5)){
if (preg_match('#^[0-9]{1,2}+\.[0-9]{2}+\.([0-9]{2}|[0-9]{4})$#',$ud6)){

list($uday, $umonth, $uyear) = explode(".", $ud6);
$ud6 = mktime('0','0','0',$umonth,$uday,$uyear);

$uzdata = reading_profil($users);

if ($ud1!="") {$pass = md5(md5($ud1));} else {$pass = $uzdata[1];}
if ($log==$config['nickname']) {$access = $ud7;} else {$access = $uzdata[7];}


change_profil($users, array(1=>$pass, 2=>$ud2, 3=>$ud3, 4=>$ud4, 5=>$ud5, 6=>$ud6, 7=>$access, 13=>$ud13, 19=>$ud19, 29=>$ud29, 36=>$ud36, 40=>$ud40, 41=>$ud41, 43=>$ud43, 49=>$ud49, 65=>$ud65));

echo '<b>Данные юзера успешно изменены!</b><br /><br />';

if ($ud1!=""){
echo '<span style="color:#ff0000">Внимание! Вы изменили пароль пользователя!</span><br />';
echo 'Не забудьте ему напомнить его новый пароль: <b>'.$ud1.'</b><br /><br />';
}

echo '<a href="users.php">Редактировать нового юзера</a><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, недопустимая дата регистрации, необходим формат (дд.мм.гггг)</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, недопустимый адрес сайта, необходим формат http://site.domen</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, вы ввели неверный адрес e-mail, необходим формат name@site.domen</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Недопустимые символы в пароле. Разрешены только знаки латинского алфавита и цифры</b>';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="users.php?action=edit&amp;users='.$users.'">Вернуться</a>';
}

############################################################################################
##                           Подтверждение удаление профиля                               ##
############################################################################################
if ($action=="poddel"){

$users = check($_GET['users']);

echo 'Вы подтверждаете, что хотите полностью удалить аккаунт пользователя <b>'.$users.'</b>?<br /><br />';

echo '<form action="users.php?action=deluser&amp;users='.$users.'&amp;uid='.$_SESSION['token'].'" method="post">';

echo '<b>Добавить в черный список:</b><br /><br />';
echo 'E-mail: <input name="mailblack" type="checkbox" value="1"  checked="checked" /><br />';
echo 'Логин: <input name="loginblack" type="checkbox" value="1"  checked="checked" /><br />';

echo '<br /><input type="submit" value="Удалить профиль" /></form><hr />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="users.php?action=edit&amp;users='.$users.'">Вернуться</a>';
}

############################################################################################
##                                   Удаление профиля                                     ##
############################################################################################
if ($action=="deluser"){

$uid = check($_GET['uid']);
$users = check($_GET['users']);
if (isset($_POST['mailblack'])) {$mailblack = (int)$_POST['mailblack'];} else {$mailblack = 0;}
if (isset($_POST['loginblack'])) {$loginblack = (int)$_POST['loginblack'];} else {$loginblack = 0;}

if ($uid==$_SESSION['token']){
if (file_exists(DATADIR."profil/$users.prof")){

$uzdata = reading_profil($users);

if ($uzdata[7]<101 || $uzdata[7]>105){

if ($mailblack==1){
$mailstring = search_string(DATADIR."blackmail.dat", $uzdata[4], 1);
if (empty($mailstring)){
write_files(DATADIR."blackmail.dat", $log.'|'.$uzdata[4].'|'.SITETIME."|\r\n");
}}

if ($loginblack==1){
$loginstring = search_string(DATADIR."blacklogin.dat", $uzdata[0], 1);
if (empty($loginstring)){
write_files(DATADIR."blacklogin.dat", $log.'|'.$uzdata[0].'|'.SITETIME."|\r\n");
}}

delete_users($users);

echo '<b>Профиль пользователя успешно удален!</b><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, у вас недостаточно прав для удаления этого профиля</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="users.php">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
