<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

$id = (int)$_GET['id'];
$pid = (int)$_GET['pid'];
if($id){
$check = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE `id` = '$pid'"));
if (!empty($check)){
$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '$pid'");
$post = mysql_fetch_array($posts);
$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$post['theme']."'");
$thm = mysql_fetch_array($thms);
echo '<div class=b> '.$thm['name'].'</div>';
$balls = file(BASEDIR."local/profil/".$post['author'].".prof");
$balls = explode(":||:",$balls[0]);
$ava = file(BASEDIR."local/profil/".$post['author'].".prof");
$avv = explode(":||:",$ava[0]);
if($avv[43]!="" && $avv[43]!="noavatar.gif"){
echo "<div class=b><table><tr><td width='32'><img src='".$config['home']."/".$avv[43]."' alt=''> ";}else{
echo "<div class=b><table><tr><td width='32'><img src='".$config['home']."/images/avators/noavatar.gif' alt=''> "; }
echo "</td><td width='100%'>";
$filename = "".BASEDIR."local/profil/".$post['author'].".prof";
if (file_exists($filename)) {
echo " <a href='".$config['home']."/pages/anketa.php?uz=".$post['author']."&amp;".SID."'><b>";
if ($balls[65]) {echo "".$balls['65']."</b></a>";
}else{echo "".$post['author']."</b></a>";}
}else{echo "<b>".$post['author']."</b>";}
echo " ".user_title($post['author'])." ".user_online($post['author'])." (".date_fixed($post['time']).")<br>\n";
if ($post['author'] != $log){
if (is_user()) {
if ($thm['status'] != '1'){
echo '<a href="'.$config['home'].'/forum/say/'.$post['id'].'&amp;'.SID.'">[отв]</a>';
echo '<a href="'.$config['home'].'/forum/cyt/'.$post['id'].'&amp;'.SID.'">[цит]</a>';
echo '<a href="'.$config['home'].'/pages/privat.php?action=submit&amp;uz='.$post['author'].'&amp;'.SID.'">[лс]</a>';
}}}
echo "</td></tr></table></div>\n";
if($post['cyt'] != NULL){
echo "<div class=cyt>";
echo antimat(smiles(bb_code($post['cyt'])))."</div><br>\n";}
echo "<div>\n";
echo antimat(smiles(bb_code($post['msg'])))."<br>\n";

echo "</div>\n";
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$post['theme']."'"),0)-1;
$start = floor($filek/ $config['forumpost'])*$config['forumpost'];
echo "<div class=b>\n";

echo "<img src='".$config['home']."/images/img/reload.gif' alt=''> <a href='".$config['home']."/forum/?act=posts&amp;id=".$post['theme']."&amp;start=".$start."'>Вернуться в тему</a><br>\n";
echo "</div>\n";
}else{ echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''> Ошибка! Данного сообщения не существует!<br>\n";}
}else{ echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''> Ошибка! Данной темы не существует!<br>\n";}

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>