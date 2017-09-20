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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['uz'])) {$uz = check($_GET['uz']);} elseif (isset($_POST['uz'])) {$uz = check($_POST['uz']);} else {$uz = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Рейтинг толстосумов</b><br /><br />';

############################################################################################
##                                       Запись в кэш                                     ##
############################################################################################
$filtime = filemtime(DATADIR."datatmp/raitinglist.dat");
$user_count = counter_string(DATADIR."datatmp/raitinglist.dat");

$filtime = $filtime+(3600*$config['raitinglistcache']);

if(SITETIME>$filtime || $user_count<100){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$array_users[] = basename($filename);
}

if (count($array_users)>0){

$dat_log = array();
$dat_gold = array();
$dat_bank = array();
$dat_all = array();

foreach ($array_users as $userval){
$userfile = file_get_contents(DATADIR."profil/$userval");
$data = explode(":||:",$userfile);

$bankmany = user_bankmany($data[0]);

$dat_log[] = $data[0];
$dat_gold[] = $data[41];
$dat_bank[] = $bankmany;
$dat_all[] = $data[41] + $bankmany;
}

arsort($dat_all);
$dat_top = array();
$gg = 0;

foreach($dat_all as $key=>$value){ $gg++;
$dat_top[] = '|'.$gg.'|'.$dat_log[$key].'|'.$dat_all[$key].'|'.$dat_gold[$key].'|'.$dat_bank[$key].'|';
}

$text = implode("\r\n",$dat_top);

write_files(DATADIR."datatmp/raitinglist.dat", "$text\r\n", 1, 0666);
}}

############################################################################################
##                                      Вывод из кэша                                     ##
############################################################################################
if (file_exists(DATADIR."datatmp/raitinglist.dat")){
$file = file(DATADIR."datatmp/raitinglist.dat");
$total = count($file);

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['userlist']){ $end = $total; }
else {$end = $start + $config['userlist']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b">'.$data[1].'. <img src="../images/img/chel.gif" alt="image" /> ';

if ($uz==$data[2]){
echo '<b><big><a href="../pages/anketa.php?uz='.$data[2].'"><span style="color:#ff0000">'.nickname($data[2]).'</span></a></big></b> ('.moneys($data[3]).')</div>';
} else {
echo '<b><a href="../pages/anketa.php?uz='.$data[2].'">'.nickname($data[2]).'</a></b> ('.moneys($data[3]).')</div>';
}

echo '<div>';
echo 'На руках: '.(int)$data[4].'<br />';
echo 'В банке: '.(int)$data[5].'</div>';
}

page_jumpnavigation('raitinglist.php?', $config['userlist'], $start, $total);
page_strnavigation('raitinglist.php?', $config['userlist'], $start, $total);

############################################################################################
##                                 Поиск пользователя                                     ##
############################################################################################
if (empty($uz)){
echo '<hr /><b>Поиск пользователя:</b><br />';

echo '<form action="raitinglist.php?start='.$start.'" method="post">';
echo '<input name="uz" value="'.$log.'" />';
echo '<input type="submit" value="Искать" /></form><hr />';

} else {

$string = search_string(DATADIR."datatmp/raitinglist.dat", $uz, 2);
if ($string) {

$stranica = floor(($string[1] - 1) / $config['userlist']) * $config['userlist'];

if ($start!=$stranica){
header ("Location: raitinglist.php?start=$stranica&uz=$uz");  exit;
}

echo '<hr /><span style="color:#00ff00">Позиция в рейтинге:</span> <b>'.(int)$string[1].'</b><br />';

} else { echo '<hr /><b><span style="color:#ff0000">Пользователь с таким логином не найден!</span></b><br />';}

echo '<br /><a href="raitinglist.php?start='.$start.'">Искать еще</a><br />';

}

echo '<br />Всего юзеров: <b>'.(int)$total.'</b><br /><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
