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

$hour = date("G",SITETIME);
$hday = date("j",SITETIME)-1;

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

############################################################################################
##                                   Вывод статистики                                     ##
############################################################################################
if ($action=="") {

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Количество посещений</b><br /><br />';

$onlinefile = file_get_contents(DATADIR."online.dat");
$substr_count = substr_count($onlinefile,'||');

$counter_online = counter_string(DATADIR."online.dat");
$counter_reg = $counter_online - $substr_count;

$counter_host = 0;
$counter_all = 0;
$counter_hits = 0;
$counter_allhits = 0;
$counter_hourhost = 0;
$counter_hourhits = 0;
$allhost24 = 0;
$allhits24 = 0;
$allhost31 = 0;
$allhits31 = 0;

if (file_exists(DATADIR."datacounter/host.dat")){
$countfile = file_get_contents(DATADIR."datacounter/host.dat");
$countarr = explode("|",$countfile);
$counter_host = $countarr[1];
$counter_all = $countarr[2];
$counter_hourhost = $countarr[4];
}

if (file_exists(DATADIR."datacounter/hits.dat")){
$hcount = file_get_contents(DATADIR."datacounter/hits.dat");
$hcount = explode("|",$hcount);
$counter_hits = $hcount[1];
$counter_allhits = $hcount[2];
$counter_hourhits = $hcount[4];
}


if (file_exists(DATADIR."datacounter/24_host.dat")){
$p24_host = file(DATADIR."datacounter/24_host.dat");

foreach($p24_host as $val){
$p24_host  = explode("|",$val);
if(isset($p24_host[0])){ $allhost24+=$p24_host[0]; }
}}

if (file_exists(DATADIR."datacounter/24_hits.dat")){
$p24_hits = file(DATADIR."datacounter/24_hits.dat");

foreach($p24_hits as $val){
$p24_data = explode("|",$val);
$allhits24+=$p24_data[0];
}}

if (file_exists(DATADIR."datacounter/31_host.dat")){
$p31_host = file(DATADIR."datacounter/31_host.dat");

foreach($p31_host as $val){
$p31_host = explode("|",$val);
$allhost31+=$p31_host[0];
}}

if (file_exists(DATADIR."datacounter/31_hits.dat")){
$p31_hits = file(DATADIR."datacounter/31_hits.dat");

foreach($p31_hits as $val){
$p31_data = explode("|",$val);
$allhits31+=$p31_data[0];
}}

echo 'Всего посетителей на сайте: <b>'.(int)$counter_online.'</b><br />';
echo 'Всего авторизованных: <b>'.(int)$counter_reg.'</b><br />';
echo 'Всего гостей: <b>'.(int)$substr_count.'</b><br /><br />';

echo 'Хостов сегодня: <b>'.(int)$counter_host.'</b><br />';
echo 'Хитов сегодня: <b>'.(int)$counter_hits.'</b><br />';
echo 'Всего хостов: <b>'.(int)$counter_all.'</b><br />';
echo 'Всего хитов: <b>'.(int)$counter_allhits.'</b><br /><br />';

echo 'Хостов за текущий час: <b>'.(int)$counter_hourhost.'</b><br />';
echo 'Хитов за текущий час: <b>'.(int)$counter_hourhits.'</b><br /><br />';

echo 'Хостов за 24 часа: <b>'.(int)($allhost24 + $counter_hourhost).'</b><br />';
echo 'Хитов за 24 часа: <b>'.(int)($allhits24 + $counter_hourhits).'</b><br /><br />';

echo 'Хостов за месяц: <b>'.(int)($allhost31 + $counter_host).'</b><br />';
echo 'Хитов за месяц: <b>'.(int)($allhits31 + $counter_hits).'</b><br /><br />';

echo 'Динамика за сутки<br />';
echo '<img src="'.BASEDIR.'gallery/count24.php" alt="image" /><br /><br />';

echo 'Динамика за месяц<br />';
echo '<img src="'.BASEDIR.'gallery/count31.php" alt="image" /><br /><br />';

echo '<a href="counter.php?action=count24">Статистика по часам</a><br />';
echo '<a href="counter.php?action=count31">Статистика по дням </a><br />';
}

//------------------------ Статистика за 24 часа --------------------------------//
if ($action=="count24") {

echo'<img src="../images/img/partners.gif" alt="image" /> <b>Статистика по часам</b><br /><br />';

echo 'Динамика за сутки<br />';
echo '<img src="'.BASEDIR.'gallery/count24.php" alt="image" /><br /><br />';

if ($hour>0){
$arrtimehour = mktime(date("H",SITETIME), 0, 0, date("m",SITETIME), date("d",SITETIME), date("Y",SITETIME));

//-------------------- Хиты -----------------------//
if (file_exists(DATADIR."datacounter/24_hits.dat")){
$p24_hits = file(DATADIR."datacounter/24_hits.dat");

$hits24 = array();
$hits_data = array();

foreach($p24_hits as $val){
$hits = explode("|",$val);

$hits24[$hits[1]] = $hits[0];
}

echo '<b>Хиты</b><br />';
for ($i=0, $tekhours=$arrtimehour; $i<$hour; $tekhours-=3600, $i++){

if (isset($hits24[$tekhours])){
$hits_data[] = date_fixed($tekhours-3600, 'H:i').' - '.date_fixed($tekhours, 'H:i').' — <b>'.$hits24[$tekhours].'</b> хитов';
} else {
$hits_data[] = date_fixed($tekhours-3600, 'H:i').' - '.date_fixed($tekhours, 'H:i').' — <b>0</b> хитов';
}}

$hits_data = array_reverse($hits_data);

foreach ($hits_data as $val){
echo $val.'<br />';
}}

//-------------------- Хосты -----------------------//
if (file_exists(DATADIR."datacounter/24_host.dat")){
$p24_host = file(DATADIR."datacounter/24_host.dat");

$host24 = array();
$host_data = array();

foreach($p24_host as $val){
$host = explode("|",$val);

$host24[$host[1]] = $host[0];
}

echo '<br /><b>Хосты</b><br />';
for ($i=0, $tekhours=$arrtimehour; $i<$hour; $tekhours-=3600, $i++){

if (isset($host24[$tekhours])){
$host_data[] = date_fixed($tekhours-3600, 'H:i').' - '.date_fixed($tekhours, 'H:i').' — <b>'.$host24[$tekhours].'</b> хостов';
} else {
$host_data[] = date_fixed($tekhours-3600, 'H:i').' - '.date_fixed($tekhours, 'H:i').' — <b>0</b> хостов';
}}

$host_data = array_reverse($host_data);

foreach ($host_data as $val){
echo $val.'<br />';
}}


} else {echo '<b>Статистика за текущие сутки еще не обновилась</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="counter.php">Вернуться</a>';
}


//------------------------ Статистика за месяц --------------------------------//
if ($action=="count31") {

echo'<img src="../images/img/partners.gif" alt="image" /> <b>Статистика по дням</b><br /><br />';

echo 'Динамика за месяц<br />';
echo '<img src="'.BASEDIR.'gallery/count31.php" alt="image" /><br /><br />';

if ($hday>0){
$arrtimeday = mktime(0, 0, 0, date("m",SITETIME), date("d",SITETIME), date("Y",SITETIME));

//-------------------- Хиты -----------------------//
if (file_exists(DATADIR."datacounter/31_hits.dat")){
$p31_hits = file(DATADIR."datacounter/31_hits.dat");

$hits31 = array();
$hits_data = array();

foreach($p31_hits as $val){
$hits = explode("|",$val);

$hits31[$hits[1]] = $hits[0];
}

echo '<b>Хиты</b><br />';
for ($i=0, $tekhours=$arrtimeday; $i<$hday; $tekhours-=86400, $i++){

if (isset($hits31[$tekhours])){
$hits_data[] = date_fixed($tekhours-86400, 'd.m').' - '.date_fixed($tekhours, 'd.m').' — <b>'.$hits31[$tekhours].'</b> хитов';
} else {
$hits_data[] = date_fixed($tekhours-86400, 'd.m').' - '.date_fixed($tekhours, 'd.m').' — <b>0</b> хитов';
}}

$hits_data = array_reverse($hits_data);

foreach ($hits_data as $val){
echo $val.'<br />';
}}

//-------------------- Хосты -----------------------//
if (file_exists(DATADIR."datacounter/31_host.dat")){
$p31_host = file(DATADIR."datacounter/31_host.dat");

$host31 = array();
$host_data = array();

foreach($p31_host as $val){
$host = explode("|",$val);

$host31[$host[1]] = $host[0];
}

echo '<br /><b>Хосты</b><br />';
for ($i=0, $tekhours=$arrtimeday; $i<$hday; $tekhours-=86400, $i++){

if (isset($host31[$tekhours])){
$host_data[] = date_fixed($tekhours-86400, 'd.m').' - '.date_fixed($tekhours, 'd.m').' — <b>'.$host31[$tekhours].'</b> хостов';
} else {
$host_data[] = date_fixed($tekhours-86400, 'd.m').' - '.date_fixed($tekhours, 'd.m').' — <b>0</b> хостов';
}}

$host_data = array_reverse($host_data);

foreach ($host_data as $val){
echo $val.'<br />';
}}

} else {echo '<b>Статистика за текущий месяц еще не обновилась</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="counter.php">Вернуться</a>';
}



echo'<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';
include_once"../themes/".$config['themes']."/foot.php";
?>
