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

if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['imja'])){$imja = '[b]'.safe_decode(check($_GET['imja'])).'[/b], ';} else {$imja = "";}

show_title('partners.gif', 'Мини-чат');

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="#form">Написать</a> / ';
echo '<a href="index.php?rand='.mt_rand(100,999).'">Обновить</a>';
if (is_admin(array(101,102,103,105))){echo ' / <a href="'.ADMINDIR.'chat.php?start='.$start.'">Управление</a>';}
echo '<hr />';

if (is_user()){
//--------------------------генерация анекдота------------------------------------------------//
if($config['shutnik']==1){

$anfi = file(BASEDIR."includes/chat_shut.php");
$an_rand  = array_rand($anfi);
$anshow = trim($anfi[$an_rand]);

$tifi = file(DATADIR."chat.dat");
$tidw = explode("|",end($tifi));

if(SITETIME > ($tidw[3] + 300) && empty($tidw[6])) {

$antext = no_br($anshow.'|Весельчак||'.SITETIME.'|Opera|127.0.0.2|1|'.$tidw[7].'|'.$tidw[8].'|');

write_files(DATADIR."chat.dat", "$antext\r\n");
}}


//------------------------------- Ответ на вопрос ----------------------------------//
if ($config['magnik']==1){

$mmagfi = file(DATADIR."chat.dat");
$mmagshow = explode("|",end($mmagfi));

if($mmagshow[8]!="" && SITETIME>$mmagshow[7]){

$magtext = no_br('На вопрос никто не ответил, правильный ответ был: [b]'.$mmagshow[8].'[/b]! Следующий вопрос через 1 минуту|Вундер-киндер||'.SITETIME.'|Opera|127.0.0.3|0|'.(SITETIME + 60).'||');

write_files(DATADIR."chat.dat", "$magtext\r\n");
}

//------------------------------  Новый вопрос  -------------------------------//
$magfi = file(BASEDIR."includes/chat_mag.php");
$mag_rand = array_rand($magfi);
$magshow = $magfi[$mag_rand];
$magstr = explode("|",$magshow);

if (empty($mmagshow[8]) && SITETIME>$mmagshow[7] && $magstr[0]!=""){

$strlent = utf_strlen($magstr[1]);

if ($strlent>1 && $strlent<5){$podskazka="$strlent буквы";} else {$podskazka="$strlent букв";}

$magtext = no_br('Вопрос всем: '.$magstr[0].' - ('.$podskazka.')|Вундер-киндер||'.SITETIME.'|Opera|127.0.0.3|0|'.(SITETIME + 600).'|'.$magstr[1].'|');

write_files(DATADIR."chat.dat", "$magtext\r\n");
}}

//----------------------------  Подключение бота  -----------------------------------------//
if($config['botnik']==1){
if(empty($_SESSION['botochat'])){

$hellobots = array('Приветик', 'Здравствуй', 'Хай', 'Добро пожаловать', 'Салют', 'Hello', 'Здарова');
$hellobots_rand = array_rand($hellobots);
$hellobots_well = $hellobots[$hellobots_rand];

$mmagfi = file(DATADIR."chat.dat");
$mmagshow = explode("|",end($mmagfi));

$weltext = no_br($hellobots_well.', '.nickname($log).'!|Настюха||'.SITETIME.'|SIE-S65|127.0.0.2|0|'.$mmagshow[7].'|'.$mmagshow[8].'|');

write_files(DATADIR."chat.dat", "$weltext\r\n");

$_SESSION['botochat']=1;
}}

$countstr = counter_string(DATADIR."chat.dat");
if ($countstr>=$config['maxpostchat']) {
delete_lines(DATADIR."chat.dat", array(0,1,2,3,4));
}
}

//---------------------------------------------------------------//
$file = file(DATADIR."chat.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['chatpost']){ $end = $total; }
else {$end = $start + $config['chatpost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$useronline = user_online($data[1]);
$useravatars = user_avatars($data[1]);

if ($data[1]=='Вундер-киндер'){$useravatars='<img src="../images/img/mag.gif" alt="image" /> '; $useronline='<span style="color:#00ff00">[On]</span>';}
if ($data[1]=='Настюха'){$useravatars='<img src="../images/img/bot.gif" alt="image" /> '; $useronline='<span style="color:#00ff00">[On]</span>';}
if ($data[1]=='Весельчак'){$useravatars='<img src="../images/img/shut.gif" alt="image" /> '; $useronline='<span style="color:#00ff00">[On]</span>';}

echo '<div class="b">';

echo $useravatars;

echo '<b><a href="index.php?imja='.safe_encode(nickname($data[1])).'#form">'.nickname($data[1]).'</a></b> '.user_title($data[1]).$useronline.' <small>('.date_fixed($data[3]).')</small></div>';
echo '<div>'.bb_code($data[0]).'<br />';
echo '<span class="data">('.$data[4].', '.$data[5].')</span></div>';
}

page_jumpnavigation('index.php?', $config['chatpost'], $start, $total);
page_strnavigation('index.php?', $config['chatpost'], $start, $total);

} else {show_error('Сообщений нет, будь первым!');}

if (is_user()){
echo '<br /><div class="form" id="form">';
echo '<form action="add.php" method="post">';
echo '<b>Сообщение:</b><br />';
echo '<textarea cols="20" rows="3" name="msg">'.$imja.'</textarea><br />';
echo '<input type="submit" value="Добавить" /></form></div>';

} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><a href="#up"><img src="../images/img/ups.gif" alt="image" /></a> ';
echo '<a href="../pages/pravila.php">Правила</a> / ';
echo '<a href="../pages/smiles.php">Смайлы</a> / ';
echo '<a href="../pages/tegi.php">Теги</a><br /><br />';

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
