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

if (is_admin(array(101,102,103))){

echo'<img src="../images/img/partners.gif" alt="image" /> <b>Бан/Разбан</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo 'Логин пользователя:<br />';

echo '<form method="post" action="zaban.php?action=edit&amp;'.SID.'">';
echo '<input name="users" maxlength="20" /><br /><br />';
echo '<input value="Получить данные" type="submit" /></form><hr />';

}


############################################################################################
##                                   Редактирование                                       ##
############################################################################################
if ($action=="edit"){

if (isset($_POST['users'])) {$users = check($_POST['users']);} else {$users = check($_GET['users']);}

if ($users!=""){
if (file_exists(DATADIR."profil/$users.prof")){

$uzdata = reading_profil($users);

echo '<img src="../images/img/chel.gif" alt="image" /> <b>Профиль пользователя '.$users.'</b><br /><br />';

if ($uzdata[52]!=""){
echo 'Последний бан: '.date_fixed($uzdata[52]).'<br />';
echo 'Забанил: <b><a href="../pages/anketa.php?uz='.$uzdata[63].'&amp;'.SID.'">'.nickname($uzdata[63]).'</a></b><br />';
echo 'Причина: '.$uzdata[39].'<br />';
}

echo 'Общее число строгих нарушений: <b>'.(int)$uzdata[64].'</b><br /><br />';

if ($uzdata[7]<101 || $uzdata[7]>105){

if ($uzdata[37]<1 || $uzdata[38]<SITETIME){
if ($uzdata[64]<5){

echo '<form method="post" action="zaban.php?action=zaban&amp;users='.$users.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">';
echo 'Время бана:<br /><input name="bantime" /><br />';

echo '<input name="banform" type="radio" value="min" checked="checked" /> Минут<br />';	
echo '<input name="banform" type="radio" value="chas" /> Часов<br />';
echo '<input name="banform" type="radio" value="sut" /> Суток<br />';

echo 'Причина бана:<br /><textarea name="bancause" cols="25" rows="3"></textarea><br />';
echo '<input value="Забанить" type="submit" /></form><hr />';

echo 'Число нарушений считается при бане более чем на 3 часа (180 мин)<br />';
echo 'При общем числе нарушений более пяти, профиль пользователя удаляется<br />';
echo 'Максимальное время бана '.round($config['maxbantime']/1440).' суток<br />';
echo 'Внимание! Постарайтесь как можно подробнее описать причину бана<br />';

} else {
echo '<b><span style="color:#ff0000">Внимание! Пользователь превысил лимит банов</span></b><br />';	
echo 'Вы можете удалить этот профиль!<br /><br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="zaban.php?action=deluser&amp;users='.$users.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Удалить профиль</a></b>';
}

} else {
echo '<b><span style="color:#ff0000">Внимание, данный аккаунт заблокирован!</span></b><br />';
echo 'До окончания бана осталось '.formattime($uzdata[38]-SITETIME).'<br /><br />';

echo '<img src="../images/img/reload.gif" alt="image" /> <b><a href="zaban.php?action=razban&amp;users='.$users.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Разбанить</a></b><hr />';
}

} else {
echo '<b><span style="color:#ff0000">У вас недостаточно прав для бана этого аккаунта</span></b><br />';
echo 'Запрещается банить админов и модеров!<br />';
} 

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, необходимо ввести логин пользователя!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="zaban.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                     Бан пользователя                                   ##
############################################################################################
if ($action=="zaban"){

$uid = check($_GET['uid']);
$users = check($_GET['users']);
$bantime = (int)$_POST['bantime'];
$banform = check($_POST['banform']);
$bancause = check($_POST['bancause']);

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9\-]+$|i',$users)){
if (file_exists(DATADIR."profil/$users.prof")){

if ($banform=='min'){$bantotaltime = $bantime;}
if ($banform=='chas'){$bantotaltime = round($bantime*60);}		
if ($banform=='sut'){$bantotaltime = round($bantime*60*24);}	
		
if ($bantotaltime>0){
if ($bantotaltime<=$config['maxbantime']){	
if (utf_strlen(trim($bancause))>=5){

$bancause = no_br($bancause,' <br /> ');

$uzdata = reading_profil($users);

if (SITETIME>($uzdata[52]+10800) && $bantotaltime>180){$bancount = 1;} else {$bancount = 0;}
change_profil($users, array(37=>1, 38=>SITETIME+($bantotaltime*60), 39=>$bancause, 52=>SITETIME, 63=>$log, 64=>$uzdata[64]+$bancount, 73=>1));

echo 'Данные пользователя <b>'.$users.'</b> успешно изменены!<br />';
echo '<b><span style="color:#ff0000">Аккаунт заблокирован!</span></b><br /><br />'; 

echo '<a href="zaban.php?'.SID.'">Редактировать нового юзера</a><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Слишком короткая причина бана!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Максимальное время бана '.round($config['maxbantime']/1440).' суток!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не указали время бана!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Пользователя с таким логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимый логин пользователя!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="zaban.php?action=edit&amp;users='.$users.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                                    Разбан пользователя                                 ##
############################################################################################
if ($action=="razban"){

$uid = check($_GET['uid']);
$users = check($_GET['users']);

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9\-]+$|i',$users)){
if (file_exists(DATADIR."profil/$users.prof")){

$uzdata = reading_profil($users);
if ($uzdata[64]>0){$bancount = 1;} else {$bancount = 0;}
change_profil($users, array(37=>0, 38=>0, 64=>$uzdata[64]-$bancount, 73=>0));

echo 'Данные юзера <b>'.$users.'</b> успешно изменены!<br />';
echo '<b><span style="color:#00ff00">Аккаунт разблокирован!</span></b><br /><br />'; 

echo '<a href="zaban.php?'.SID.'">Редактировать нового юзера</a><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимый логин пользователя!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="zaban.php?action=edit&amp;users='.$users.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                                   Удаление пользователя                                ##
############################################################################################
if ($action=="deluser"){

$uid = check($_GET['uid']);
$users = check($_GET['users']);

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9\-]+$|i',$users)){
if (file_exists(DATADIR."profil/$users.prof")){

$uzdata = reading_profil($users);

if ($uzdata[64]>=5){
if ($uzdata[7]<101 || $uzdata[7]>105){

$mailstring = search_string(DATADIR."blackmail.dat", $uzdata[4], 1);
if (empty($mailstring)){
write_files(DATADIR."blackmail.dat", $log.'|'.$uzdata[4].'|'.SITETIME."|\r\n");
}

$loginstring = search_string(DATADIR."blacklogin.dat", $uzdata[0], 1);
if (empty($loginstring)){
write_files(DATADIR."blacklogin.dat", $log.'|'.$uzdata[0].'|'.SITETIME."|\r\n");
}

delete_users($users);

echo '<b>Профиль пользователя успешно удален!</b><br />';
echo 'Данные занесены в черный список!<br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! У вас недостаточно прав для удаления этого профиля</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! У пользователя менее 5 нарушений, удаление невозможно!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Недопустимый логин пользователя!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="zaban.php?'.SID.'">Вернуться</a>';
}


echo'<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>