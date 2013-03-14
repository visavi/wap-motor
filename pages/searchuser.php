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

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo'<img src="../images/img/profiles.gif" alt="image" /> <b>Поиск пользователей</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action=="") {

echo '<form method="post" action="searchuser.php?action=search&amp;'.SID.'">';
echo 'Логин или ник юзера:<br /><input name="uz" /><br />';
echo 'Искать:<br />';
echo '<input name="ftype" type="radio" value="1" checked="checked" /> По логину<br />';
echo '<input name="ftype" type="radio" value="2" /> По нику<br />';
echo '<input name="ftype" type="radio" value="3" /> По ICQ<br />';
echo '<input name="ftype" type="radio" value="4" /> По IP-адресу<br /><br />';
echo '<input value="Поиск" type="submit" /></form><hr />';

echo '<br />Если результат поиска ничего не дал, тогда можно поискать по первым символам логина или ника<br />';
echo 'В этом случае будет выдан результат похожий на введенный вами запрос<br />';
}


############################################################################################
##                                    Поиск пользователя                                  ##
############################################################################################
if($action=="search"){

$uz=check($_POST['uz']);
$ftype=(int)$_POST['ftype'];

if($uz!=""){
if($ftype!=""){
//------------------------------ НОВАЯ ФУНКЦИЯ КЕШИРОВАНИЯ ------------------------------//
$filtime = filemtime(DATADIR."datatmp/searchuser.dat");
$user_count = counter_string(DATADIR."datatmp/searchuser.dat");

$filtime=$filtime+(3600*$config['usersearchcache']);

if(SITETIME>$filtime || $user_count<50){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$array_users[] = basename($filename);
}

sort($array_users);

$dat_top = array();

foreach($array_users as $k=>$v){
$tex = file_get_contents(DATADIR."profil/$v");
$data = explode(":||:",$tex);

$data[19] = preg_replace('|[^0-9]|', '', $data[19]);

$dat_top[] = '|'.$data[0].'|'.$data[65].'|'.$data[19].'|'.$data[14].'|';	
}

$dat_top=implode("\r\n",$dat_top);

if($dat_top!=""){
write_files(DATADIR."datatmp/searchuser.dat", "$dat_top\r\n", 1, 0666);
}
}
//--------------------------------------------------------------------//

$uzlog = array();
$uznick = array();
$uzicq = array();
$uzip = array();

$userfile=file(DATADIR."datatmp/searchuser.dat");
foreach($userfile as $k=>$v){
$data = explode("|",$v);

$uzlog[]=$data[1];
$uznick[]=$data[2];
$uzicq[]=$data[3];
$uzip[]=$data[4];
}

//----------------------------- Поиск по логину --------------------------------------//
if($ftype==1){

$string = search_string(DATADIR."datatmp/searchuser.dat", $uz, 1);
if ($string){

echo 'Пользователь с логином <b>'.$uz.'</b> найден!<br /><br />';
echo '<img src="../images/img/chel.gif" alt="image" /> <a href="anketa.php?uz='.$uz.'&amp;'.SID.'">Перейти к анкете</a><br />';

echo '<img src="../images/img/chat.gif" alt="image" /> <a href="kontakt.php?action=add&amp;uz='.$uz.'&amp;'.SID.'">Добавить в контакт</a><br />';
echo '<img src="../images/img/ignor.gif" alt="image" /> <a href="ignor.php?action=add&amp;uz='.$uz.'&amp;'.SID.'">Добавить в игнор</a><br />';
echo '<img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;uz='.$uz.'&amp;'.SID.'">Приватное сообщение</a><br />';
echo '<img src="../images/img/many.gif" alt="image" /> <a href="../games/perevod.php?uz='.$uz.'&amp;'.SID.'">Перечислить денег</a><br />';

} else {

echo 'Пользователь с логином <b>'.$uz.'</b> не найден!<br /><br />';

foreach($uzlog as $v){
if (stristr($v, $uz)){
echo 'Возможно вы искали пользователя <b><a href="anketa.php?uz='.$v.'&amp;'.SID.'">'.$v.'</a></b><br />'; 
break;
}}
echo 'Попробуйте также поискать по нику<br />';
}
}


//----------------------------- Поиск по нику -----------------------------------//
if($ftype==2){

$string = search_string(DATADIR."datatmp/searchuser.dat", $uz, 2);
if ($string){

echo 'Пользователь с ником <b>'.$uz.' ('.$string[1].')</b> найден!<br /><br />';
echo '<img src="../images/img/chel.gif" alt="image" /> <a href="anketa.php?uz='.$string[1].'&amp;'.SID.'">Перейти к анкете</a><br />';

echo '<img src="../images/img/chat.gif" alt="image" /> <a href="kontakt.php?action=add&amp;uz='.$string[1].'&amp;'.SID.'">Добавить в контакт</a><br />';
echo '<img src="../images/img/ignor.gif" alt="image" /> <a href="ignor.php?action=add&amp;uz='.$string[1].'&amp;'.SID.'">Добавить в игнор</a><br />';
echo '<img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;uz='.$string[1].'&amp;'.SID.'">Приватное сообщение</a><br />';
echo '<img src="../images/img/many.gif" alt="image" /> <a href="../games/perevod.php?uz='.$string[1].'&amp;'.SID.'">Перечислить денег</a><br />';

} else {

echo 'Пользователь с ником <b>'.$uz.'</b> не найден!<br /><br />';

foreach($uznick as $k=>$v){
if (strstr($v, $uz)){
echo 'Возможно вы искали пользователя <b><a href="anketa.php?uz='.$uzlog[$k].'&amp;'.SID.'">'.$v.'</a></b><br />'; 
break;
}}
echo 'Попробуйте также поискать по логину<br />';
}
}

//----------------------------- Поиск по ICQ -----------------------------------//
if($ftype==3){

$uz = preg_replace('|[^0-9]|', '', $uz);

$string = search_string(DATADIR."datatmp/searchuser.dat", $uz, 3);
if ($string){

echo 'Пользователь с ICQ <b>'.$uz.' ('.$string[1].')</b> найден!<br /><br />';
echo '<img src="../images/img/chel.gif" alt="image" /> <a href="anketa.php?uz='.$string[1].'&amp;'.SID.'">Перейти к анкете</a><br />';

echo '<img src="../images/img/chat.gif" alt="image" /> <a href="kontakt.php?action=add&amp;uz='.$string[1].'&amp;'.SID.'">Добавить в контакт</a><br />';
echo '<img src="../images/img/ignor.gif" alt="image" /> <a href="ignor.php?action=add&amp;uz='.$string[1].'&amp;'.SID.'">Добавить в игнор</a><br />';
echo '<img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;uz='.$string[1].'&amp;'.SID.'">Приватное сообщение</a><br />';
echo '<img src="../images/img/many.gif" alt="image" /> <a href="../games/perevod.php?uz='.$string[1].'&amp;'.SID.'">Перечислить денег</a><br />';

} else {
echo 'Пользователь с ICQ <b>'.$uz.'</b> не найден!<br />';
}
}

//----------------------------- Поиск по IP -----------------------------------//
if($ftype==4){

$string = search_string(DATADIR."datatmp/searchuser.dat", $uz, 4);
if ($string){

echo 'Пользователь с IP <b>'.$uz.' ('.$string[1].')</b> найден!<br /><br />';
echo '<img src="../images/img/chel.gif" alt="image" /> <a href="anketa.php?uz='.$string[1].'&amp;'.SID.'">Перейти к анкете</a><br />';

echo '<img src="../images/img/chat.gif" alt="image" /> <a href="kontakt.php?action=add&amp;uz='.$string[1].'&amp;'.SID.'">Добавить в контакт</a><br />';
echo '<img src="../images/img/ignor.gif" alt="image" /> <a href="ignor.php?action=add&amp;uz='.$string[1].'&amp;'.SID.'">Добавить в игнор</a><br />';
echo '<img src="../images/img/mail.gif" alt="image" /> <a href="privat.php?action=submit&amp;uz='.$string[1].'&amp;'.SID.'">Приватное сообщение</a><br />';
echo '<img src="../images/img/many.gif" alt="image" /> <a href="../games/perevod.php?uz='.$string[1].'&amp;'.SID.'">Перечислить денег</a><br />';

} else {
echo 'Пользователь с IP <b>'.$uz.'</b> не найден!<br />';
}
}

} else {echo '<b>Ошибка! Вы не выбрали параметр поиска!</b><br />';}
} else {echo '<b>Ошибка! Вы не ввели логин или ник пользователя!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="searchuser.php?'.SID.'">Вернуться</a>';
}

echo'<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';
include_once"../themes/".$config['themes']."/foot.php";
?>