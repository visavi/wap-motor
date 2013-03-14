<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (is_user()){
echo "<img src='".$config['home']."/images/img/partners.gif' alt=''>Мои темы<br><br>\n"; 

function pages($start, $total, $onpage, $home){
if ($start != 0) echo '<a href="'.$home.'/forum/mythem/'.($start - $onpage).'">&lt;-Назад</a> ';
else echo '&lt;-Назад';
echo ' | ';
if ($total > $start + $onpage)
echo ' <a href="'.$home.'/forum/mythem/'.($start + $onpage).'">Далее-&gt;</a>';
else echo 'Далее-&gt;';
if($total>0){
$ba = ceil($total/$onpage);
$ba2 = $ba*$onpage-$onpage;
echo '<br/>Страницы:';
$asd = $start-($onpage*3);
$asd2 = $start+($onpage*4);
if($asd<$total && $asd>0) echo ' <a href="'.$home.'/forum/mythem/0">1</a> ... ';
for($i=$asd; $i<$asd2;){
if($i<$total && $i>=0){
$ii = floor(1+$i/$onpage);
if ($start==$i) echo ' <b>['.$ii.']</b>';
else echo ' <a href="'.$home.'/forum/mythem/'.$i.'">'.$ii.'</a>';}
$i=$i+$onpage;}
if($asd2<$total) echo ' ... <a href="'.$home.'/forum/mythem/'.$ba2.'">'.$ba.'</a>';
}}
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `author` = '$log'"),0);

$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;

$tops = mysql_query("SELECT * FROM `theme` WHERE `author` = '".$log."' ORDER BY `id` DESC LIMIT $start, 10");
if(mysql_num_rows($tops) != '0'){
while($top = mysql_fetch_array($tops)){

echo "<div>";
if($top['locked'] == '1'){echo "<img src='".$config['home']."/forum/img/zt.gif' alt=''> ";
}else{
if($top['status'] == '0'){echo "<img src='".$config['home']."/forum/img/t.gif' alt=''> ";}
elseif($top['status'] == '1'){echo "<img src='".$config['home']."/forum/img/bt.gif' alt=''> ";}}
echo "<a href='".$config['home']."/forum/posts/".$top['id']."'><b>".$top['name']."</b></a> ";
echo "[".mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$top['id']."'"),0)."]";


echo "<a href='".$config['home']."/forum/posts/".$top['id']."/".strts($top['id'],$config['forumpost'])."'> <small>&gt;&gt;</small></a><br>\n";

echo "Кратко: ".$top['description']." <br>\n";
echo "Последний: "; 
$ldate = file('../local/profil/'.$top['last'].'.prof'); 
$ldate = explode(":||:",$ldate['0']);
if ($ldate[65]) {echo "".$ldate['65']." ";
}else{echo "".$top['last']." ";}
echo ' ('.date_fixed($top['time']).')<hr></div>';
}}else{ echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''> Темы еще не созданны!<br><br><hr>\n";}

if ($total > 10){pages($start, $total, 10, $config['home']); echo'<hr>';}

echo ": <a href='".$config['home']."/forum/'>К форумам</a><br>"; 
echo ":: <a href='".$config['home']."'>На главную</a><br>"; 
} else {header ("Location: ".$config['home']."/forum/");} 


echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>