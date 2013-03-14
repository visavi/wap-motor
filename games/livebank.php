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
if (isset($_GET['uz'])) {$uz=check($_GET['uz']);} elseif (isset($_POST['uz'])) {$uz=check($_POST['uz']);} else {$uz="";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Статистика вкладчиков</b><br /><br />';

############################################################################################
##                                       Запись в кэш                                     ##
############################################################################################
$filtime = filemtime(DATADIR."datatmp/vkladlist.dat");
$user_count = counter_string(DATADIR."datatmp/vkladlist.dat");

$filtime = $filtime+(3600*$config['vkladlistcache']);

if(SITETIME>$filtime || $user_count<100){

$array_users = array();
$vklad_user = array();
$vklad_operacia = array();

$bankfile = file(DATADIR."bank.dat");

foreach($bankfile as $bankval){
$data = explode("|", $bankval);

$array_users[] = $data[1];
$vklad_user[] = $data[2];
$vklad_operacia[] = trim($data[3]);
}

if (count($array_users)>0){

arsort($vklad_user);
$dat_top = array();
$gg = 0;

foreach($vklad_user as $key=>$value){ $gg++;
$dat_top[]='|'.$gg.'|'.$array_users[$key].'|'.$vklad_user[$key].'|'.$vklad_operacia[$key].'|';
}

$text = implode("\r\n",$dat_top);

write_files(DATADIR."datatmp/vkladlist.dat", "$text\r\n", 1, 0666);
}}

############################################################################################
##                                      Вывод из кэша                                     ##
############################################################################################
if (file_exists(DATADIR."datatmp/vkladlist.dat")){
$file = file(DATADIR."datatmp/vkladlist.dat");
$total = count($file);  

if ($total>0){

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['vkladlist']){ $end = $total; }
else {$end = $start + $config['vkladlist']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b">'.$data[1].'. <img src="../images/img/chel.gif" alt="image" /> ';

if ($uz==$data[2]){
echo '<b><big><a href="../pages/anketa.php?uz='.$data[2].'&amp;'.SID.'"><span style="color:#ff0000">'.nickname($data[2]).'</span></a></big></b> ('.moneys($data[3]).')</div>';
} else {
echo '<b><a href="../pages/anketa.php?uz='.$data[2].'&amp;'.SID.'">'.nickname($data[2]).'</a></b> ('.moneys($data[3]).')</div>';
}

echo '<div>Посл. операция: '.date_fixed($data[4]).'</div>';
}

page_jumpnavigation('livebank.php?', $config['vkladlist'], $start, $total);
page_strnavigation('livebank.php?', $config['vkladlist'], $start, $total);

############################################################################################
##                                 Поиск пользователя                                     ##
############################################################################################
if ($uz==""){
echo '<hr /><b>Поиск пользователя:</b><br />';

echo '<form action="livebank.php?start='.$start.'&amp;'.SID.'" method="post">';
echo'<input name="uz" value="'.$log.'" />';
echo '<input type="submit" value="Искать" /></form><hr />';

} else {

$string = search_string(DATADIR."datatmp/vkladlist.dat", $uz, 2);
if ($string) {

$stranica = floor(($string[1] - 1) / $config['vkladlist']) * $config['vkladlist'];

if ($start!=$stranica){ 
header ("Location: livebank.php?start=$stranica&uz=$uz&".SID); exit;
}

echo '<hr /><span style="color:#00ff00">Позиция в рейтинге:</span> <b>'.(int)$string[1].'</b><br />';

} else { echo '<hr /><b><span style="color:#ff0000">Пользователь с таким логином не найден!</span></b><br />';}

echo '<br /><a href="livebank.php?start='.$start.'&amp;'.SID.'">Искать еще</a><br />';

}
  
echo '<br />Всего вкладчиков: <b>'.(int)$total.'</b><br />';

} else {show_error('Пользователей еще нет!');}
} else {show_error('Пользователей еще нет!');}

echo '<br /><img src="../images/img/many.gif" alt="image" /> <a href="bank.php?'.SID.'">В банк</a><br />';
echo '<img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada&amp;'.SID.'">Развлечения</a><br />'; 
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>