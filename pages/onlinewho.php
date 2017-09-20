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

$daytime=date("d",SITETIME);
$montime=date("d.m",SITETIME);

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Онлайн пользователей</b><br /><br />';

$array_users = array();
$forum_shet = 0;
$chat_shet = 0;
$news_shet = 0;
$down_shet = 0;
$book_shet = 0;
$games_shet = 0;
$library_shet = 0;
$gallery_shet = 0;
$index_shet = 0;
$online_shet = 0;

$wholfile = file(DATADIR."who.dat");
foreach($wholfile as $value){
$who_file = explode("|",$value);

if((SITETIME - $who_file[3]) < 600){
$array_users[] = $who_file[0];

if (strstr($who_file[1],"forum")){$forum_shet++;}
if (strstr($who_file[1],"chat")){$chat_shet++;}
if (strstr($who_file[1],"news")){$news_shet++;}
if (strstr($who_file[1],"download")){$down_shet++;}
if (strstr($who_file[1],"book")){$book_shet++;}
if (strstr($who_file[1],"games")){$games_shet++;}
if (strstr($who_file[1],"library")){$library_shet++;}
if (strstr($who_file[1],"gallery")){$gallery_shet++;}

if ($who_file[1]=="index.php"){$index_shet++;}

$online_shet++;
}}
echo 'Всего на сайте: <b>'.(int)$online_shet.'</b><br />';

echo '<a href="'.BASEDIR.'index.php">На главной:</a>  '.(int)$index_shet.'<br />';
echo '<a href="'.BASEDIR.'forum/">В форуме:</a> '.(int)$forum_shet.'<br />';
echo '<a href="'.BASEDIR.'chat/">В мини-чате:</a> '.(int)$chat_shet.'<br />';
echo '<a href="'.BASEDIR.'book/">В гостевой:</a> '.(int)$book_shet.'<br />';
echo '<a href="'.BASEDIR.'news/">В новостях:</a> '.(int)$news_shet.'<br />';
echo '<a href="'.BASEDIR.'download/">В загрузках:</a> '.(int)$down_shet.'<br />';
echo '<a href="'.BASEDIR.'index.php?action=arkada">В развлечениях:</a>  '.(int)$games_shet.'<br />';
echo '<a href="'.BASEDIR.'library/">В библиотеке:</a> '.(int)$library_shet.'<br />';
echo '<a href="'.BASEDIR.'gallery/">В галерее:</a> '.(int)$gallery_shet.'<br />';

echo '<br /><b>Пользователи на сайте:</b><br />';

foreach($array_users as $key=>$value){
if($key==0){
echo '<b><a href="../pages/anketa.php?uz='.$value.'">'.nickname($value).'</a></b>';
}else{
echo ', <b><a href="../pages/anketa.php?uz='.$value.'">'.nickname($value).'</a></b>';
}
}

//----------------------Функция вычисляет у кого сегодня Д.Р.--------------------------//
$filtime=filemtime(DATADIR."datatmp/happyday.dat");
$filtimeday=date("d",$filtime);

if($daytime!=$filtimeday){

$array_users = array();
$globusers = glob(DATADIR."profil/*.prof");
foreach ($globusers as $filename) {
$array_users[] = basename($filename);
}

$user_happy = "";
foreach($array_users as $value){

$tex = file_get_contents(DATADIR."profil/$value");
$data = explode(":||:",$tex);

$happytime = substr($data[18],0,5);

if($montime==$happytime){
$user_happy.=$data[0].'|';
}}

write_files(DATADIR."datatmp/happyday.dat", $user_happy, 1, 0666);
}


echo '<br /><hr /><b>Сегодняшние именинники:</b><br />';

$happyuser = file_get_contents(DATADIR."datatmp/happyday.dat");
$arr_happy = explode("|",$happyuser);

$counthappy = count($arr_happy)-1;

if ($counthappy>0){
echo 'Сегодня отмечают свой день рождения '.(int)$counthappy.' чел.<br />';

foreach($arr_happy as $key=>$value){
if ($value!==""){
if ($key==0){
echo '<b><a href="../pages/anketa.php?uz='.$value.'"><span style="color:#ff0000">'.nickname($value).'</span></a></b>';
} else {
echo ', <b><a href="../pages/anketa.php?uz='.$value.'"><span style="color:#ff0000">'.nickname($value).'</span></a></b>';
}}}

} else {echo '<b>Именинников нет!</b><br />';}

//---------------------------------------------------------------------------------//
echo '<hr /><b>Приветствуем новичков:</b><br />';
$filtime=filemtime(DATADIR."datatmp/newuserday.dat");
$filtimeday=date("d",$filtime);

if ($daytime!=$filtimeday){
write_files(DATADIR."datatmp/newuserday.dat", "", 1, 0666);
}

$newuser = file_get_contents(DATADIR."datatmp/newuserday.dat");
$arr_newuser= explode("|",$newuser);

$countnewuser=count($arr_newuser)-1;

if($countnewuser>0){
echo 'Сегодня зарегистрировались на сайте '.(int)$countnewuser.' чел.<br />';

foreach($arr_newuser as $key=>$value){
if ($value!=""){
if ($key==0){
echo '<b><a href="../pages/anketa.php?uz='.check($value).'"><span style="color:#ff0000">'.check(nickname($value)).'</span></a></b>';
} else {
echo ', <b><a href="../pages/anketa.php?uz='.check($value).'"><span style="color:#ff0000">'.check(nickname($value)).'</span></a></b>';
}}}
} else {echo '<b>Новичков нет!</b>';}


echo '<br /><br /><img src="../images/img/chat.gif" alt="image" /> <a href="who.php">Kто-где?</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a> ';
include_once "../themes/".$config['themes']."/foot.php";
?>
