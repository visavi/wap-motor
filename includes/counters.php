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
if (!defined('BASEDIR')) { header("Location:../index.php"); exit; }

$maxonline = 250; // Cколько онлайн записей хранить

$count_online = counter_string(DATADIR."online.dat");
if ($count_online>=$maxonline) {
delete_lines(DATADIR."online.dat",array(0,1));
}

$oftime = SITETIME - 600;
$den = date("d",SITETIME);
$hour = date("H",SITETIME);

$found = 0;
$user = array();
$arrtimehour = mktime(date("H",SITETIME), 0, 0, date("m",SITETIME), date("d",SITETIME), date("Y",SITETIME));
$arrtimeday = mktime(0, 0, 0, date("m",SITETIME), date("d",SITETIME), date("Y",SITETIME));

$f = fopen(DATADIR."online.dat","r+");
if ($f){
flock($f,LOCK_EX);
while (!feof($f)){
$user[] = fgets($f,65536);
}

fseek($f,0,SEEK_SET);
ftruncate($f,0);

foreach($user as $val) {

$savesdata = explode("|",$val);

if (isset($savesdata[1]) && $ip==$savesdata[1] && $savesdata[0]>$oftime){$found = 1;}
if (isset($savesdata[2]) && $savesdata[2]==$log && $savesdata[2]!=""){$savesdata[1] = $ip;}

if ($savesdata[0]>$oftime && $ip!=$savesdata[1] && $savesdata[1]!=""){
fputs($f,$savesdata[0].'|'.$savesdata[1].'|'.$savesdata[2].'|'.$savesdata[3]."|\r\n");
}
}

fputs($f,SITETIME.'|'.$ip.'|'.$log.'|'.$brow."|\r\n");
	
fflush($f);
flock($f,LOCK_UN);
fclose ($f);
}

############################################################################################
##                                      Запись хитов                                      ##
############################################################################################
$arcounts = array();
$fp = fopen(DATADIR."datacounter/hits.dat","a+");
if ($fp){
flock($fp,LOCK_EX);
while (!feof($fp)){
$arcounts[] = fgets($fp,100);
}
$counts = explode("|",$arcounts[0]);

//----------------------- Статистика за 24 часа (хиты) ----------------------------//
if(isset($counts[3]) && isset($counts[4]) && $counts[3]!=$hour){

$filehits24 = file(DATADIR."datacounter/24_hits.dat"); 
$datahits24 = explode("|",end($filehits24));

if ($arrtimehour>$datahits24[1]){
write_files(DATADIR."datacounter/24_hits.dat", $counts[4]."|".$arrtimehour."|\r\n", 0, 0666);
$counts[3] = $hour; $counts[4] = 0;
}

if (count($filehits24)>24) {
delete_lines(DATADIR."datacounter/24_hits.dat", 0);
}}

//------------------------ Статистика за 31 день (хиты) ---------------------------//
if (isset($counts[0]) && isset($counts[1]) && $counts[0]!=$den){

$filehits31 = file(DATADIR."datacounter/31_hits.dat"); 
$dathits31 = explode("|",end($filehits31));

if ($arrtimeday>$dathits31[1]){
write_files(DATADIR."datacounter/31_hits.dat", $counts[1]."|".$arrtimeday."|\r\n", 0, 0666);
$counts[0] = $den; $counts[1] = 0; $found = 0;
}

if (count($filehits31)>31) {
delete_lines(DATADIR."datacounter/31_hits.dat", 0);
}}

//----------------------- Каждое посещение ----------------------------//
$counts[1]++; $counts[2]++; $counts[4]++;
$zapis = $counts[0].'|'.$counts[1].'|'.$counts[2].'|'.$counts[3].'|'.$counts[4].'|';

ftruncate($fp,0);
fputs($fp,$zapis);
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);
@chmod (DATADIR."datacounter/hits.dat", 0666); 
}


############################################################################################
##                                      Запись хостов                                     ##
############################################################################################
if ($found==0){
$arcounts = array();
$fp = fopen(DATADIR."datacounter/host.dat","a+");
if ($fp){
flock($fp,LOCK_EX);
while (!feof($fp)){
$arcounts[] = fgets($fp,100);
}
$counts = explode("|",$arcounts[0]);

//----------------------- Статистика за 24 часа (хосты) ----------------------------//
if(isset($counts[3]) && isset($counts[4]) && $counts[3]!=$hour){

$filehost24 = file(DATADIR."datacounter/24_host.dat"); 
$datahost24 = explode("|",end($filehost24));

if ($arrtimehour>$datahost24[1]){
write_files(DATADIR."datacounter/24_host.dat", $counts[4]."|".$arrtimehour."|\r\n", 0, 0666);
$counts[3] = $hour; $counts[4] = 0;
}

if (count($filehost24)>24) {
delete_lines(DATADIR."datacounter/24_host.dat", 0);
}}

//------------------------ Статистика за 31 день (хосты) ---------------------------//
if (isset($counts[0]) && isset($counts[1]) && $counts[0]!=$den){

$filehost31 = file(DATADIR."datacounter/31_host.dat"); 
$dathost31 = explode("|",end($filehost31));

if ($arrtimeday>$dathost31[1]){
write_files(DATADIR."datacounter/31_host.dat", $counts[1]."|".$arrtimeday."|\r\n", 0, 0666);
$counts[0] = $den; $counts[1] = 0;
}

if (count($filehost31)>31) {
delete_lines(DATADIR."datacounter/31_host.dat", 0);
}}

//----------------------- Каждое посещение ----------------------------//
$counts[1]++; $counts[2]++; $counts[4]++;
$zapis = $counts[0].'|'.$counts[1].'|'.$counts[2].'|'.$counts[3].'|'.$counts[4].'|';

ftruncate($fp,0);
fputs($fp,$zapis);
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);
@chmod (DATADIR."datacounter/host.dat", 0666); 
}
}

//-------------------------- Онлайн ------------------------------//
if ($config['onlines']==1){

$onlinefile = file_get_contents(DATADIR."online.dat");
$substr_count = substr_count($onlinefile,'||');

$counter_online = counter_string(DATADIR."online.dat");
$counter_reg = $counter_online - $substr_count;

echo '<a href="'.BASEDIR.'pages/online.php?'.SID.'">На сайте: '.$counter_reg.'/'.$counter_online.'</a><br />';
}

//----------------------- Статистика ----------------------------//
if ($config['incount']>0){ 

$counter_host = 0;
$counter_all = 0;
$counter_hits = 0;
$counter_allhits = 0;

if (file_exists(DATADIR."datacounter/host.dat")){
$countfile = file_get_contents(DATADIR."datacounter/host.dat");
$countarr = explode("|",$countfile);
$counter_host = $countarr[1];
$counter_all = $countarr[2];
}

if (file_exists(DATADIR."datacounter/hits.dat")){
$hcount = file_get_contents(DATADIR."datacounter/hits.dat");
$hcount = explode("|",$hcount);
$counter_hits = $hcount[1];
$counter_allhits = $hcount[2];
}

if ($config['incount']==1){ echo '<a href="'.BASEDIR.'pages/counter.php?'.SID.'">'.$counter_host.' | '.$counter_all.'</a><br />';}
if ($config['incount']==2){ echo '<a href="'.BASEDIR.'pages/counter.php?'.SID.'">'.$counter_hits.' | '.$counter_allhits.'</a><br />';}
if ($config['incount']==3){ echo '<a href="'.BASEDIR.'pages/counter.php?'.SID.'">'.$counter_host.' | '.$counter_hits.'</a><br />';}
if ($config['incount']==4){ echo '<a href="'.BASEDIR.'pages/counter.php?'.SID.'">'.$counter_all.' | '.$counter_allhits.'</a><br />';}
if ($config['incount']==5){ echo '<a href="'.BASEDIR.'pages/counter.php?'.SID.'"><img src="'.BASEDIR.'gallery/count.php" alt="image" /></a><br />';}
}
?>