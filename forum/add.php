<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

$msg = check($_POST['msg']);

$id = (int)$_GET['id'];
$check = mysql_fetch_array(mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."'"));
if (!empty($check)) {
if (is_user()) {
if (isset($_POST['add'])) {


if (strlen(trim($msg)) >= '3') {
if (strlen(trim($msg)) <= '5000') {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);

if (!trim($theme['status'])) {
$unders = mysql_query("SELECT id,name,forum FROM `under` WHERE `id` = '".$theme['under']."'");
$under = mysql_fetch_array($unders);
$forums = mysql_query("SELECT id,name FROM `forums` WHERE `id` = '".$under['forum']."'");
$forum = mysql_fetch_array($forums);
$compr = mysql_query("SELECT `msg` FROM `posts` WHERE `author` = '".$log."' ORDER BY `id` DESC");
$cpr = mysql_fetch_array($compr);

$af = mysql_query("SELECT * FROM `posts` WHERE `author`='".$log."' AND `time` >='".(SITETIME - $config['floodstime'])."';");
$af1 = mysql_num_rows($af);

if (empty($af1)) {
if (strcmp($cpr['msg'], $msg)) {

if (isset($_POST['cyt'])) {$cyt = check($_POST['cyt']);} else {$cyt = '';}

$msg = no_br($msg,'<br />');

////////////////////////////////////////////// Если все нормально то записываем в базу ////////////////////////////////////////////										
mysql_query ("INSERT INTO `posts` (forums,under,theme,msg,author,author_n,time,brow,ip,cyt,edit) VALUES 
('".$forum['id']."','".$under['id']."','".$id."','".$msg."','".$log."','".nickname($_SESSION['log'])."','".SITETIME."','".$brow."','".$ip."','".$cyt."','0')");
//////////////////////////////////////////////////// Записываем последнюю тему ////////////////////////////////////////////////////

mysql_query("UPDATE `forums` SET `last_theme`='".$id."' WHERE `id` = '" . $forum['id'] . "'");
mysql_query("UPDATE `forums` SET `last_theme_name`='".$theme['name']."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `forums` SET `last_time`='".SITETIME."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `forums` SET `last_login`='".nickname($_SESSION['log'])."' WHERE `id` = '".$forum['id']."'");

////////////////////////////////////////////////////  Оповещаем в приват //////////////////////////////////////////////////////
if (isset($_POST['priv'])) {
$uz = check($_GET['uz']);

if (preg_match('|^[a-z0-9_\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){

$filesize = filesize(DATADIR.'privat/'.$uz.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);
if ($pers < 100){

$ppus = mysql_query("SELECT * FROM `posts` WHERE `theme` = '$id' AND `author` = '$log' ORDER BY `time` DESC LIMIT 1");
$ppu = mysql_fetch_array($ppus);

$uzdata = reading_profil($uz);
change_profil($uz, array(10=>$uzdata[10]+1));

$text = no_br($log.'|Вам ответили на форуме! -=[b][url='.$config['home'].'/forum/post.php?id='.$id.'&amp;pid='.$ppu['id'].'] Просмотреть [/url][/b]=-|'.SITETIME.'|'); 

write_files(DATADIR.'privat/'.$uz.'.priv', "$text\r\n");
}}}
}

//////////////////////////////////////////////////// 	Считаем сообщения	 //////////////////////////////////////////////////////
$thms = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$id."'"), 0);
$udr = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `under` = '" . $under['id'] . "'"), 0);
$frm = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `forums` = '" . $forum['id'] . "'"), 0);
$pst = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts`"), 0);
$f = mysql_result(mysql_query("SELECT COUNT(*) FROM `forums`"), 0);
$u = mysql_result(mysql_query("SELECT COUNT(*) FROM `under`"), 0);
$t = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme`"), 0);
//////////////////////////////////////////////////// 	Обновляем счетчики	 //////////////////////////////////////////////////////
mysql_query("UPDATE `theme` SET `last`='".$log."' WHERE `id` = '$id'");
mysql_query("UPDATE `theme` SET `time`='".SITETIME."' WHERE `id` = '$id'");
mysql_query("UPDATE `theme` SET `posts`='".$thms."' WHERE `id` = '$id'");
mysql_query("UPDATE `forums` SET `last_posts`='".$thms."' WHERE `id` = '" . $forum['id'] . "'");
mysql_query("UPDATE `under` SET `posts`='".$udr."' WHERE `id` = '" . $under['id'] . "'");
mysql_query("UPDATE `forums` SET `posts`='".$frm."' WHERE `id` = '" . $forum['id'] . "'");
$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['0'] = $f;
$edata['1'] = $u;
$edata['2'] = $t;
$edata['3'] = $pst;

$etext = '';
for ($u = 0; $u < 4; $u++) {
$etext .= $edata[$u] . ':||:';} 
$efp = fopen(BASEDIR . "local/forum.dat", "a+");
flock($efp, LOCK_EX);
ftruncate($efp, '0');
fputs($efp, $etext);
fflush($efp);
flock($efp, LOCK_UN);
fclose($efp);
unset($etext);
///////////////////////////////////////////////Добовляем юзеру балы, посты и т.д/////////////////////////////////////////////////


change_profil($log, array(8=>$udata[8]+1, 14=>$ip, 36=>$udata[36]+1, 41=>$udata[41]+1));


//////////////////////////////////////////////////// Считаем страницы в теме /////////////////////////////////////////////////
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '$id'"), 0);
if ($filek != '0') { $filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
/////////////////////////////////////////////// Определяем куда перенаправить/////////////////////////////////////////////////
if (empty($_POST['file'])) {
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id."&start=".$start.""); exit;
} else {
header ("Location: ".$config['home']."/forum/?act=afile&id=".$id.""); exit; 
} 
///////////////////////////////////////////////////////// Выводим ошибки //////////////////////////////////////////////////////
} else {
  $themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
  $theme = mysql_fetch_array($themes);
  echo '<div class="b">Тема: '.$theme['name'].'</div>';
  echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ваше сообщение повторяет предыдущее!</div><br>';} 

} else {
  $themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
  $theme = mysql_fetch_array($themes);
  echo '<div class="b">Тема: '.$theme['name'].'</div>';
  echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Вы не можете так часто писать, порог '.$config['floodstime'].' секунд!</div><br>';} 
  
} else {
  $themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
  $theme = mysql_fetch_array($themes);
  echo '<div class="b">Тема: '.$theme['name'].'</div>';
  echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Данная тема закрыта для обсуждения!</div><br>';} 

} else {
  $themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
  $theme = mysql_fetch_array($themes);
  echo '<div class="b">Тема: '.$theme['name'].'</div>';
  echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком большое сообщение!</div><br>';} 

} else {
  $themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
  $theme = mysql_fetch_array($themes);
  echo '<div class="b">Тема: '.$theme['name'].'</div>';
  echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Сообщение должно состоять не меньше 3х символов!</div><br>';} 
}}} 


echo '<div><hr>';

$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$theme['id']."'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];

echo ': <a href="'.$config['home'].'/forum/posts/'.$theme['id'].'/'.$start.'">В тему</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>'; 
echo '::: <a href="'.$config['home'].'/">На главную</a><br>';
echo "</div>\n";

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>