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

echo '<img src="../images/img/site.png" alt="image" /> <b>Список админов и модеров</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

if (file_exists(DATADIR."datatmp/adminlist.dat")){
$userfile=file(DATADIR."datatmp/adminlist.dat");
$total = count($userfile);

if ($total>0){

foreach($userfile as $value){
$userdata = explode("|",$value);

echo '<img src="../images/img/user.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$userdata[1].'">'.nickname($userdata[1]).'</a></b>  ('.user_status($userdata[2]).') '.user_online($userdata[1]).'<br />';

if (is_admin(array(101))){
echo '<img src="../images/img/edit.gif" alt="image" /> <a href="users.php?action=edit&amp;users='.$userdata[1].'">Изменить</a><hr />';
}
}

echo 'Всего в администрации: <b>'.(int)$total.'</b><br />';

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}
}

############################################################################################
##                                     Обновление                                         ##
############################################################################################
if ($action=="reload"){

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
$dat_user[] = $data[0];
$dat_status[] = $data[7];
}}

asort($dat_status);
$admin_top = array();

foreach ($dat_status as $k=>$v){
$admin_top[] = '|'.$dat_user[$k].'|'.$dat_status[$k].'|';
}

$text = implode("\r\n",$admin_top);

write_files(DATADIR."datatmp/adminlist.dat", $text, 1, 0666);
}

header ("Location: adminlist.php?isset=reload"); exit;
}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="adminlist.php?action=reload">Пересчитать</a><br />';
echo '<img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
