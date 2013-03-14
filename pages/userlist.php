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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Список пользователей</b><br /><br />';

############################################################################################
##                                       Запись в кэш                                     ##
############################################################################################
$filtime = filemtime(DATADIR."datatmp/userlist.dat");
$user_count = counter_string(DATADIR."datatmp/userlist.dat");

$filtime=$filtime+(3600*$config['userlistcache']);

if (SITETIME>$filtime || $user_count<100){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$array_users[] = basename($filename);
}

if (count($array_users)>0){

$dat_komm = array();
$dat_chat = array();
$dat_vhod = array();
$dat_guest = array();
$dat_forum = array();
$dat_reg = array();
$dat_log = array();
$dat_ball = array();

foreach ($array_users as $userval){
$tex = file_get_contents(DATADIR."profil/$userval");
$data = explode(":||:",$tex);

$dat_komm[] = (int)$data[33];
$dat_chat[] = (int)$data[12];
$dat_vhod[] = (int)$data[11];
$dat_guest[] = (int)$data[9];
$dat_forum[] = (int)$data[8];
$dat_reg[] = (string)$data[6];
$dat_log[] = (string)$data[0];
$dat_ball[] = (int)$data[36];
}

arsort($dat_ball);
$dat_top = array();
$gg = 0;

foreach($dat_ball as $k=>$v){ $gg++;
$dat_top[] = '|'.$gg.'|'.$dat_log[$k].'|'.$dat_ball[$k].'|'.$dat_forum[$k].'|'.$dat_guest[$k].'|'.$dat_chat[$k].'|'.$dat_komm[$k].'|'.$dat_vhod[$k].'|'.$dat_reg[$k].'|';	
}

$text = implode("\r\n",$dat_top);

write_files(DATADIR."datatmp/userlist.dat", "$text\r\n", 1, 0666);
}}

############################################################################################
##                                      Вывод из кэша                                     ##
############################################################################################
if (file_exists(DATADIR."datatmp/userlist.dat")){
$file = file(DATADIR."datatmp/userlist.dat");
$total = count($file);

if ($total>0){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['userlist']){ $end = $total; }
else {$end = $start + $config['userlist'];}
for ($i = $start; $i < $end; $i++){
	
$data = explode("|",$file[$i]);

echo '<div class="b">'.(int)$data[1].'. <img src="../images/img/chel.gif" alt="image" /> ';

if ($uz==$data[2]){
echo '<b><big><a href="../pages/anketa.php?uz='.$data[2].'&amp;'.SID.'"><span style="color:#ff0000">'.nickname($data[2]).'</span></a></big></b> (Баллов: <b>'.$data[3].'</b>)</div>';
} else {	
echo '<b><a href="../pages/anketa.php?uz='.$data[2].'&amp;'.SID.'">'.nickname($data[2]).'</a></b> (Баллов: <b>'.$data[3].'</b>)</div>';
}

echo '<div>';
echo 'Оставленных сообщений<br /> Форум: '.$data[4].' | Гостевая: '.$data[5].' | Чат: '.$data[6].' | Коммент: '.$data[7].'<br />';
echo 'Посещений: '.$data[8].'<br />';
echo 'Дата регистрации: '.date_fixed($data[9],'j F Y').'</div>';
}

page_jumpnavigation('userlist.php?', $config['userlist'], $start, $total);
page_strnavigation('userlist.php?', $config['userlist'], $start, $total);

############################################################################################
##                                 Поиск пользователя                                     ##
############################################################################################
if (empty($uz)){
echo '<hr /><b>Поиск пользователя:</b><br />';

echo '<form action="userlist.php?start='.$start.'&amp;'.SID.'" method="post">';
echo '<input name="uz" value="'.$log.'" />';
echo '<input type="submit" value="Искать" /></form><hr />';

} else {

$string = search_string(DATADIR."datatmp/userlist.dat", $uz, 2);
if ($string) {

$stranica = floor(($string[1] - 1) / $config['userlist']) * $config['userlist'];

if ($start!=$stranica){ 
header ("Location: userlist.php?start=$stranica&uz=$uz&".SID); exit;
}

echo '<hr /><span style="color:#00ff00">Позиция в рейтинге:</span> <b>'.(int)$string[1].'</b><br />';

} else { echo '<hr /><b><span style="color:#ff0000">Пользователь с таким логином не найден!</span></b><br />';}

echo '<br /><a href="userlist.php?start='.$start.'&amp;'.SID.'">Искать еще</a><br />'; 

}

echo '<br />Всего юзеров: <b>'.(int)$total.'</b><br /><br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Пользователей еще нет!</b><br />';}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>