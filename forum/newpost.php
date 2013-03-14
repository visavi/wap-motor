<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

echo "<img src='".$config['home']."/images/img/partners.gif' alt=''>Новые сообщения<br><br>\n";
$flt = SITETIME-60*60*24*7;
$tops = mysql_query("SELECT * FROM `posts` WHERE `time` >= '$flt' ORDER BY `id` DESC LIMIT 10");
if(mysql_num_rows($tops) != '0'){
while($top = mysql_fetch_array($tops)){
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '$top[theme]'");
$theme = mysql_fetch_array($themes);
echo "<div>\n";
echo "<img src='".$config['home']."/forum/img/t.gif' alt=''> <a href='".$config['home']."/forum/posts/".$theme['id']."'><b>".$theme['name']." </b></a><br>";
echo antimat(bb_code(check($top['msg'])))."<br>\n";
echo "Написал: ".$top['author']." (".date_fixed($top['time']).")<br>\n";
echo '<span style="color:#CC00CC; font-size: 9px;">('.$top['brow'].', '.$top['ip'].')</span>';
echo "</div><hr>\n";
}}else{ echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''>Сообщений еще нет!<br>\n";}

echo ": <a href='".$config['home']."/forum/'>К форумам</a><br>"; 
echo ":: <a href='".$config['home']."'>На главную</a><br>"; 

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>