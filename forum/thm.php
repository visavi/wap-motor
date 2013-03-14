<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

$id = (int)$_GET['id'];
$check = mysql_fetch_array(mysql_query("SELECT * FROM `theme` WHERE `id` = '$id'"));
if (trim($check)){
$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '$id'");
$thm = mysql_fetch_array($thms);
echo '<div class=b> '.$thm['name'].'</div>';
$balls = file(BASEDIR."local/profil/$thm[author].prof");
$balls = explode(":||:",$balls[0]);
$ava = file(BASEDIR."local/profil/$thm[author].prof");
$avv = explode(":||:",$ava[0]);
if($avv[43]!="" && $avv[43]!="noavatar.gif"){
echo "<div class=b><table><tr><td width='32'><img src='../".$avv[43]."' alt=''> ";}else{
echo "<div class=b><table><tr><td width='32'><img src='../images/avators/noavatar.gif' alt=''> "; }
echo "</td><td width='100%'>";
$filename = "".BASEDIR."local/profil/$post[author].prof";
if (file_exists($filename)) {
echo " <a href='../pages/anketa.php?uz=".$thm['author']."'><b>";
if ($balls[65]) {echo "".$balls['65']."</b></a>";
}else{echo "".$thm['author']."</b></a>";}
}else{echo "<b>".$thm['author']."</b>";}
echo " ".user_title($thm[author])." ".user_online($thm[author])." (".date_fixed($thm[time]).")<br>\n";
if ($post[author] != $log){
if ($post[author] == $log){
$ssim = $sitetime-60*10;
if ($post[time] > $ssim){echo "<a href='index.php?act=edit&pid=".$thm['id']."&id=$id'>[Редактировать]</a> \n";}}
if ($dostup==101 || $dostup==102 || $dostup==103 || $dostup==105){
if ($_SESSION['mufbc']){echo "<a href='index.php?act=delpost&pid=".$thm['id']."&tid=$id'>[DEL]</a> \n";}}
echo "</td></tr></table></div>\n";

echo "<div>".antimat(smiles(bb_code(check2($thm['msg']))))."<br><br></div>\n";

$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$thm['theme']."'"),0);
if ($filek !='0'){$filek = $filek-1;}
$start = floor($filek/$config_forumpost)*$config_forumpost;

echo "<div class=b>\n";
echo "<img src='../images/img/reload.gif' alt=''> <a href='index.php?act=posts&start=$start&id=$id'>Вернуться в тему</a><br>\n";
echo "</div>\n";}
}else{ echo "<br> <img src='../images/img/close.gif' alt=''> Ошибка! Данной темы не существует!<br>\n";}

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>