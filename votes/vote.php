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

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Результат голосования</b><br /><br />';

############################################################################################
##                                   Главная страница                                     ##
############################################################################################
if($action=="") {

if (file_exists(DATADIR."datavotes/votes.dat")){
$vfiles = file_get_contents(DATADIR."datavotes/votes.dat");

$vdata = explode("|", $vfiles);
$vcount = count($vdata);

$vresult = file_get_contents(DATADIR."datavotes/result.dat");
$vres = explode("|", $vresult);

$sum = array_sum($vres);
$max = max($vres);

if (empty($sum)){$sum = 1;}
if (empty($max)){$max = 1;}

for($i=1; $i<$vcount; $i++){

if($vdata[$i]!=""){
$proc = round($vres[$i] * 100 / $sum);
$maxproc = round($vres[$i] * 150 / $max);

echo '<b>'.$vdata[$i].'</b> (Голосов: '.(int)$vres[$i].')<br />';
echo '<img src="'.BASEDIR.'gallery/level.php?rat='.$maxproc.'&amp;in='.$proc.'" alt="image" /><br /><br />';
}
}

echo '<b>Всего проголосовавших: '.(int)$sum.'</b><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Голосование еще не создано!</b><br />';}

}

############################################################################################
##                                     Голосование                                        ##
############################################################################################
if ($action=="vote"){
if (is_user()){

if (isset($_POST['golos'])) {$golos = (int)$_POST['golos'];} elseif (isset($_GET['golos'])) {$golos = (int)$_GET['golos'];} else {$golos = "";}

if (file_exists(DATADIR."datavotes/votes.dat")){
$vfiles = file_get_contents(DATADIR."datavotes/votes.dat");
$vv = explode("|", $vfiles);

$string = search_string(DATADIR."datavotes/users.dat", $log, 1);

if (empty($string)){
if ($golos>0 && $vv[$golos]!==""){

$vresult = file_get_contents(DATADIR."datavotes/result.dat");
$vu = explode("|",$vresult);
$vu[$golos]++;
$vt='|'.$vu[1].'|'.$vu[2].'|'.$vu[3].'|'.$vu[4].'|'.$vu[5].'|'.$vu[6].'|'.$vu[7].'|'.$vu[8].'|'.$vu[9].'|'.$vu[10].'|';

write_files(DATADIR."datavotes/result.dat", $vt, 1, 0666);

write_files(DATADIR."datavotes/users.dat", '|'.$log.'|'.SITETIME."|\r\n", 0, 0666);

header ("Location: vote.php?isset=yesvotes"); exit;

} else {echo '<b>Ошибка! Неверно указан вариант голосования!</b><br />';}
} else {echo '<b>Ошибка! Вы уже проголосовали в этом опросе!</b><br />';}
} else {echo '<b>Ошибка! Голосование еще не создано!</b><br />'; }

} else {show_login('Вы не авторизованы, чтобы голосовать, необходимо');}
}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php">К голосованию</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
