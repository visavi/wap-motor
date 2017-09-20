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

if (isset($_GET['list'])) {$list = check($_GET['list']);} else {$list = "";}
if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}

echo'<img src="../images/img/banners.gif" alt="image" /> <b>Кто в онлайне</b><br /><br />';

$lines=file(DATADIR."online.dat");
$lines = array_reverse($lines);

$fullar = array();
$regar = array();

foreach($lines as $value){
$data = explode("|",$value);

$fullar[]='|'.$data[0].'|'.$data[1].'|'.$data[2].'|'.$data[3].'|';

if($data[2]!=""){
$regar[]='|'.$data[0].'|'.$data[1].'|'.$data[2].'|'.$data[3].'|';
}
}

$total=count($fullar);
$totalreg=count($regar);

echo 'Всего на сайте: <b>'.(int)$total.'</b><br />';
echo 'Зарегистрированных:  <b>'.(int)$totalreg.'</b><br />';

//-------------------------------------------------------------//
if($list=="full"){

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['onlinelist']){ $end = $total; }
else {$end = $start + $config['onlinelist']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$fullar[$i]);
$usertime=date_fixed($data[1],'H:i:s');

if($data[3]==""){

echo '<hr /><img src="../images/img/chel.gif" alt="image" /> <b>'.$config['guestsuser'].'</b> (Время: '.$usertime.')<br />';
echo '<small><span style="color:#cc00cc">('.$data[4].', '.$data[2].')</span></small>';

}else{

echo '<hr /><img src="../images/img/chel.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$data[3].'">'.nickname($data[3]).'</a></b> (Время: '.$usertime.')<br />';
echo '<small><span style="color:#cc00cc">('.$data[4].', '.$data[2].')</span></small>';

}
}

} else {

//-------------------------------------------------------------//
$total = $totalreg;

if($total<1){echo'<img src="../images/img/reload.gif" alt="image" /> <b>Зарегистрированных нет!</b><br /><br />';}

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['onlinelist']){ $end = $total; }
else {$end = $start + $config['onlinelist']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$regar[$i]);
$usertime=date_fixed($data[1],'H:i:s');

echo '<hr /><img src="../images/img/chel.gif" alt="image" /> <b><a href="../pages/anketa.php?uz='.$data[3].'">'.nickname($data[3]).'</a></b> (Время: '.$usertime.')<br />';
echo '<small><span style="color:#cc00cc">('.$data[4].', '.$data[2].')</span></small>';

}
}

page_jumpnavigation('online.php?list='.$list.'&amp;', $config['onlinelist'], $start, $total);
page_strnavigation('online.php?list='.$list.'&amp;', $config['onlinelist'], $start, $total);


if ($list!='full'){
echo'<br /><br /><img src="../images/img/chat.gif" alt="image" /> <a href="online.php?list=full">Показать гостей</a><br />';
} else {
echo'<br /><br /><img src="../images/img/chat.gif" alt="image" /> <a href="online.php">Cкрыть гостей</a><br />';
}

echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';
include_once "../themes/".$config['themes']."/foot.php";
?>
