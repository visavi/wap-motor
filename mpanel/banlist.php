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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102,103))){

echo '<img src="../images/img/site.png" alt="image" /> <b>Список забаненых</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

if (file_exists(DATADIR."datatmp/banlist.dat")){
$file = file(DATADIR."datatmp/banlist.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['banlist']){ $end = $total; }
else {$end = $start + $config['banlist'];}
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);


echo '<div class="b"><img src="../images/img/user.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$data[1].'">'.nickname($data[1]).'</a></b> ';
echo '(Забанен: '.date_fixed($data[4]).')</div>';
echo '<div>';

if (($data[2]-SITETIME)>0){
echo 'До окончания бана осталось '.formattime($data[2]-SITETIME).'<br />';
} else {
echo '<b>Срок бана уже истек</b><br />';
}
echo 'Забанил: <b>'.nickname($data[5]).'</b><br />';
echo 'Причина: '.$data[3].'<br />';
echo '<img src="../images/img/edit.gif" alt="image" /> <a href="zaban.php?action=edit&amp;users='.$data[1].'">Разбанить</a></div>';
}

page_jumpnavigation('banlist.php?', $config['banlist'], $start, $total);
page_strnavigation('banlist.php?', $config['banlist'], $start, $total);

echo '<br /><br />Всего забанено: <b>'.(int)$total.'</b><br />';

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
$dat_time = array();
$dat_cause = array();
$dat_date = array();
$dat_who = array();

foreach($array_users as $value){
$tex = file_get_contents(DATADIR."profil/$value");
$data = explode(":||:",$tex);

if($data[37]>0 && $data[38]>SITETIME){
$dat_user[] = $data[0];
$dat_time[] = $data[38];
$dat_cause[] = $data[39];
$dat_date[] = $data[52];
$dat_who[] = $data[63];
}}

asort($dat_date);
$admin_top = array();

foreach ($dat_date as $k=>$v){
$admin_top[] = '|'.$dat_user[$k].'|'.$dat_time[$k].'|'.$dat_cause[$k].'|'.$dat_date[$k].'|'.$dat_who[$k].'|';
}

$text = implode("\r\n",$admin_top);

write_files(DATADIR."datatmp/banlist.dat", $text, 1, 0666);
}

header ("Location: banlist.php?isset=reload"); exit;
}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="banlist.php?action=reload">Пересчитать</a><br />';
echo '<img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
