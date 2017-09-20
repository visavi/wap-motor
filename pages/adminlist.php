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
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");

echo '<img src="../images/img/user.gif" alt="image" /> <b>Администрация сайта</b><br /><br />';

############################################################################################
##                                       Запись в кэш                                     ##
############################################################################################
$filtime = filemtime(DATADIR."datatmp/adminlist.dat");

$filtime = $filtime+(3600*$config['adminlistcache']);

if(SITETIME>$filtime){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$array_users[] = basename($filename);
}

if (count($array_users)>0){

$dat_user = array();
$dat_status = array();

foreach($array_users as $value){
$tex = file_get_contents(DATADIR."profil/$value");
$data = explode(":||:",$tex);

if ($data[7]>=101 && $data[7]<=105){
$dat_user[]=$data[0];
$dat_status[]=$data[7];
}}

asort($dat_status);
$admin_top = array();

foreach ($dat_status as $k=>$v){
$admin_top[] = '|'.$dat_user[$k].'|'.$dat_status[$k].'|';
}

$text = implode("\r\n",$admin_top);

write_files(DATADIR."datatmp/adminlist.dat", "$text\r\n", 1, 0666);
}}

############################################################################################
##                                      Вывод из кэша                                     ##
############################################################################################
if (file_exists(DATADIR."datatmp/adminlist.dat")){
$userfile = file(DATADIR."datatmp/adminlist.dat");
$total = count($userfile);

if ($total>0){

foreach($userfile as $value){
$userdata = explode("|",$value);

echo '<img src="../images/img/chel.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$userdata[1].'">'.nickname($userdata[1]).'</a></b>  ('.user_status($userdata[2]).') '.user_online($userdata[1]).'<br />';
}

echo '<br />Всего в администрации: <b>'.(int)$total.'</b><br />';

############################################################################################
##                                     Быстрая почта                                      ##
############################################################################################
if (is_user()){

echo '<hr /><big><b>Быстрая почта</b></big><br /><br />';

echo '<form method="post" action="privat.php?action=send&amp;uid='.$_SESSION['token'].'">';

echo 'Выберите адресат:<br /><select name="uz">';

foreach($userfile as $value){
$userdata = explode("|",$value);

echo '<option value="'.$userdata[1].'"> '.nickname($userdata[1]).' </option>';
}
echo '</select><br />';
echo 'Сообщение:<br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input value="Отправить" type="submit" /></form><hr />';
}

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

include_once"../themes/".$config['themes']."/foot.php";
?>
