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

$uz = check($_GET['uz']);
$uid = check($_GET['uid']);
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

show_title('partners.gif', 'Изменение авторитета');

if (is_user()){

if ($action!=""){
if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9_\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){
if ($udata[48]<SITETIME){
if ($udata[36]>=150){
if ($log!=$uz){

$ratstr = search_string(DATADIR."dataraiting/$log.dat", $uz, 0);
if (empty($ratstr)){

$uz_prof = file_get_contents(DATADIR."profil/$uz.prof");
$uz_udata = explode(":||:",$uz_prof);
if ($uz_udata[36]>=150){

############################################################################################
##                                Увеличение авторитета                                   ##
############################################################################################
if($action=="plus"){

change_profil($log, array(48=>SITETIME + 10800));

write_files(DATADIR."dataraiting/$log.dat", "$uz|+|\r\n", 0, 0666);

$countstr = counter_string(DATADIR."dataraiting/$log.dat");
if ($countstr>=20) {
delete_lines(DATADIR."dataraiting/$log.dat",array(0,1));
}


$uzdata = reading_profil($uz);
change_profil($uz, array(49=>$uzdata[49]+1, 50=>$uzdata[50]+1));

//------------------------------Уведомление по привату------------------------//
if ($config['notificraiting']==1){

$filesize = filesize(DATADIR.'privat/'.$uz.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);
if ($pers < 100){

change_profil($uz, array(10=>$uzdata[10]+1));
$text = no_br($log.'|<img src="../images/img/plus.gif" alt="Плюс" /> Пользователь '.nickname($log).' поставил вам плюс|'.SITETIME.'|');

write_files(DATADIR.'privat/'.$uz.'.priv', "$text\r\n");
}}

$uzdata = reading_profil($uz);
echo 'Ваш положительный голос за пользователя '.nickname($uz).' успешно оставлен!<br />';
echo 'В данный момент его авторитет: '.(int)$uzdata[49].'<br />';
echo 'Всего положительных голосов: '.(int)$uzdata[50].'<br />';
echo 'Всего отрицательных голосов: '.(int)$uzdata[51].'<br /><br />';

echo 'От общего числа положительных и отрицательных голосов строится рейтинг самых авторитетных<br />';
echo 'Внимание, следующий голос вы сможете оставить не менее чем через 3 часа!<br />';
}

############################################################################################
##                                Уменьшение авторитета                                   ##
############################################################################################
if($action=="minus"){

change_profil($log, array(48=>SITETIME + 10800));

write_files(DATADIR."dataraiting/$log.dat", "$uz|-|\r\n", 0, 0666);

$countstr = counter_string(DATADIR."dataraiting/$log.dat");
if ($countstr>=20) {
delete_lines(DATADIR."dataraiting/$log.dat",array(0,1));
}

$uzdata = reading_profil($uz);
change_profil($uz, array(49=>$uzdata[49]-1, 51=>$uzdata[51]+1));

//------------------------------Уведомление по привату------------------------//
if ($config['notificraiting']==1){

$filesize = filesize(DATADIR.'privat/'.$uz.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);
if ($pers < 100){

change_profil($uz, array(10=>$uzdata[10]+1));
$text = no_br($log.'|<img src="../images/img/minus.gif" alt="Минус" /> Пользователь '.nickname($log).' поставил вам минус|'.SITETIME.'|');

write_files(DATADIR.'privat/'.$uz.'.priv', "$text\r\n");
}}

$uzdata = reading_profil($uz);
echo 'Ваш отрицательный голос за пользователя '.nickname($uz).' успешно оставлен!<br />';
echo 'В данный момент его авторитет: '.(int)$uzdata[49].'<br />';
echo 'Всего положительных голосов: '.(int)$uzdata[50].'<br />';
echo 'Всего отрицательных голосов: '.(int)$uzdata[51].'<br /><br />';

echo 'От общего числа положительных и отрицательных голосов строится рейтинг самых авторитетных<br />';
echo 'Внимание, следующий голос вы сможете оставить не менее чем через 3 часа!<br />';
}


} else {show_error('Ошибка, cтатус пользователя недостаточен для изменения авторитета!');}
} else {show_error('Ошибка, вы уже изменяли авторитет этому пользователю!');}
} else {show_error('Ошибка, нельзя изменять авторитет самому себе!');}
} else {show_error('Ошибка, ваш статус не позволяет вам изменять авторитет!');}
} else {show_error('Ошибка, разрешается изменять авторитет раз в 3 часа!');}
} else {show_error('Ошибка, данного пользователя не существует!');}
} else {show_error('Ошибка, недопустимый логин пользователя!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}
} else {show_error('Ошибка, вы не выбрали параметр изменения авторитета!');}

} else {show_login('Вы не авторизованы, чтобы изменять авторитет, необходимо');}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="anketa.php?uz='.$uz.'">Вернуться</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once"../themes/".$config['themes']."/foot.php";
?>
