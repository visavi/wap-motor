<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

echo "<img src='../images/img/partners.gif' alt=''> Топ популярных тем<br><br>\n"; 

function pages($start, $total, $page, $onpage){
if ($start != 0) echo '<a href="'.$page.'?start='.($start - $onpage).'">&lt;-Назад</a> ';
else echo '&lt;-Назад';
echo ' | ';
if ($total > $start + $onpage)
echo ' <a href="'.$page.'?start='.($start + $onpage).'">Далее-&gt;</a>';
else echo 'Далее-&gt;';
if($total>0){
$ba = ceil($total/$onpage);
$ba2 = $ba*$onpage-$onpage;
echo '<br>Страницы:';
$asd = $start-($onpage*3);
$asd2 = $start+($onpage*4);
if($asd<$total && $asd>0) echo ' <a href="'.$page.'?start=0">1</a> ... ';
for($i=$asd; $i<$asd2;){
if($i<$total && $i>=0){
$ii = floor(1+$i/$onpage);
if ($start==$i) echo ' <b>['.$ii.']</b>';
else echo ' <a href="'.$page.'?start='.$i.'">'.$ii.'</a>';}
$i=$i+$onpage;}
if($asd2<$total) echo ' ... <a href="'.$page.'?start='.$ba2.'">'.$ba.'</a>';
}}
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme`"),0);

$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;

$tops = mysql_query("SELECT * FROM `theme` ORDER BY `posts` DESC LIMIT $start, 10");
if(mysql_num_rows($tops) != '0'){
while($top = mysql_fetch_array($tops)){
$timedat = $top['time']+$config['timeclocks']*3600;
$timedat = date("d.m.Y / H:i",$timedat);

echo "<div class=b>";
if($top['locked'] == '1'){echo "<img src='img/zt.gif' alt=''> ";
}else{
if($top['status'] == '0'){echo "<img src='img/t.gif' alt=''> ";}
elseif($top['status'] == '1'){echo "<img src='img/bt.gif' alt=''> ";}}
echo "<a href='".$config['home']."/forum/posts/".$top['id']."'><b>".$top['name']."</b></a> [".$top['posts']."]";
echo "<a href='".$config['home']."/forum/posts/".$top['id']."/".strts($top['id'],$config['forumpost'])."'> <small>&gt;&gt;</small></a></div>\n";
$date = file(BASEDIR."local/profil/$top[author].prof"); 
$filename = "".BASEDIR."local/profil/$top[author].prof";
if (file_exists($filename)) {
$date = explode(":||:",$date[0]);
echo "Создал: <a href='../pages/anketa.php?uz=".$top['author']."'>";
if ($date[65]) {echo "".$date['65']."</a><br>";
}else{echo "".$top['author']."</a><br>";}
}else{echo "Создал: ".$top['author']."<br>";}
echo "Кратко: ".$top['description']." <br>\n";
echo "Последний: "; 
$ldate = file(BASEDIR."local/profil/".$top['last'].".prof"); 
$ldate = explode(":||:",$ldate[0]);
if ($ldate[65]) {echo "".$ldate['65']." ";
}else{echo "".$top['last']." ";}
echo "($timedat)<br>\n";
}}else{ echo "<br> <img src='../images/img/close.gif' alt=''> Темы еще не созданны!<br>\n";}
echo "<hr>\n";
pages($start, $total, 'top.php', 10);
echo "<hr>\n";
echo "<img src='../images/img/reload.gif' alt=''> <a href='index.php'>К форумам</a><br>"; 
echo "<img src='../images/img/homepage.gif' alt=''> <a href='../index.php?".SID."'>На главную</a><br>"; 

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>