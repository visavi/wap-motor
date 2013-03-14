<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (is_user()){

echo "<img src='".$config['home']."/images/img/partners.gif' alt=''>Мои сообщения<br><br>\n";

function pages($start, $total, $onpage, $home){
if ($start != 0) echo '<a href="'.$home.'/forum/mypost/'.($start - $onpage).'">&lt;-Назад</a> ';
else echo '&lt;-Назад';
echo ' | ';
if ($total > $start + $onpage)
echo ' <a href="'.$home.'/forum/mypost/'.($start + $onpage).'">Далее-&gt;</a>';
else echo 'Далее-&gt;';
if($total>0){
$ba = ceil($total/$onpage);
$ba2 = $ba*$onpage-$onpage;
echo '<br/>Страницы:';
$asd = $start-($onpage*3);
$asd2 = $start+($onpage*4);
if($asd<$total && $asd>0) echo ' <a href="'.$home.'/forum/mypost/0">1</a> ... ';
for($i=$asd; $i<$asd2;){
if($i<$total && $i>=0){
$ii = floor(1+$i/$onpage);
if ($start==$i) echo ' <b>['.$ii.']</b>';
else echo ' <a href="'.$home.'/forum/mypost/'.$i.'">'.$ii.'</a>';}
$i=$i+$onpage;}
if($asd2<$total) echo ' ... <a href="'.$home.'/forum/mypost/'.$ba2.'">'.$ba.'</a>';}}

$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `author` = '$log'"),0);

$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;

$tops = mysql_query("SELECT * FROM `posts` WHERE `author` = '$log' ORDER BY `id` DESC LIMIT $start, 10");
if(mysql_num_rows($tops) != '0'){
while($top = mysql_fetch_array($tops)){
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$top['theme']."'");
$theme = mysql_fetch_array($themes);

echo "<div><img src='".$config['home']."/forum/img/t.gif' alt=''> <a href='".$config['home']."/forum/posts/".$theme['id']."'><b>".$theme['name']." </b></a><br>";
echo antimat(bb_code(check($top['msg'])))."<br>\n";
echo "Написал: ".$top['author']." (".date_fixed($top['time']).")<br>\n";
echo "<small><font color=#CC00CC>(".$top['brow'].", ".$top['ip'].")</font></small>\n";
echo '<hr></div>';
}}else{ echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''> Сообщений еще нет!<br><br><hr>\n";}

if ($total > 10){pages($start, $total, 10, $config['home']); echo'<hr>';}

echo ": <a href='".$config['home']."/forum/'>К форумам</a><br>"; 
echo ":: <a href='".$config['home']."'>На главную</a><br>"; 
} else {header ("Location: ".$config['home']."/forum/");} 

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>