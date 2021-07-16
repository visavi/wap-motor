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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Популярные скины</b><br /><br />';

if (is_user()){
echo 'Вы используете скин: <b>'.check($udata[20]).'</b><br /><br />';
}

//------------------------------ НОВАЯ ФУНКЦИЯ КЕШИРОВАНИЯ ------------------------------//
$filtime=@filemtime(DATADIR."datatmp/themes.dat");
$filtime=$filtime+(3600*$config['themescache']);

if(SITETIME>=$filtime){
$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$array_users[] = basename($filename);
}

$dat_skins =  array();
foreach($array_users as $keyusers){
$tex = file_get_contents(DATADIR."profil/$keyusers");
$data = explode(":||:",$tex);
$dat_skins[] = $data[20];
}

$newskin_array=array_count_values($dat_skins);

$dat_themes = array();
$globthemes = glob(BASEDIR."themes/*", GLOB_ONLYDIR);
foreach ($globthemes as $dirname) {
$dat_themes[] = basename($dirname);
}

$data_themes = array();
$data_values = array();

foreach($dat_themes as $key_themes){
$data_themes[] = check($key_themes);
if (isset($newskin_array[$key_themes])) {
$data_values[] = (int)$newskin_array[$key_themes];
} else {
$data_values[] = 0;
}}

arsort($data_values);
$dat_top = array();

foreach($data_values as $k=>$v){
$dat_top[] = '|'.$data_themes[$k].'|'.$v.'|';
}

$dat_top=implode("\r\n",$dat_top);

if($dat_top!=""){
$fp = fopen(DATADIR."datatmp/themes.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fputs ($fp,"$dat_top\r\n");
fflush($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod (DATADIR."datatmp/themes.dat", 0666);
}
}


//------------------------------ ВЫВОД ИЗ КЕША ------------------------------//
$file = file(DATADIR."datatmp/themes.dat");
$total = count($file);

foreach($file as $tval){
$data = explode("|",$tval);
echo '<img src="../images/img/act.gif" alt="image" /> <b><a href="../pages/skin.php?skins='.$data[1].'">'.$data[1].'</a></b> - <b>'.(int)$data[2].'</b> чел.<br />';
}


$bestskin = explode("|",$file[0]);
$worstskin = explode("|",end($file));

echo '<br />Всего скинов: <b>'.(int)$total.'</b><br /><br />';
echo 'Наиболее популярный скин: <b>'.$bestskin[1].'</b> (Используют <b>'.$bestskin[2].'</b> чел.)<br />';
echo 'Наименее популярный скин: <b>'.$worstskin[1].'</b> (Используют <b>'.$worstskin[2].'</b> чел.)<br />';


echo'<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once"../themes/".$config['themes']."/foot.php";
?>

