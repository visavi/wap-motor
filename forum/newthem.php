<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

echo "<img src='".$config['home']."/images/img/partners.gif' alt=''>Новые темы<br><br>\n"; 
$flt = SITETIME-60*60*24*7;


$tops = mysql_query("SELECT * FROM `theme` WHERE `time` >= '$flt' ORDER BY `id` DESC LIMIT 10");
if(mysql_num_rows($tops) != '0'){
while($top = mysql_fetch_array($tops)){
echo "<div>\n";
if($top['locked'] == '1'){echo "<img src='".$config['home']."/forum/img/zt.gif' alt=''> ";
}else{
if($top['status'] == '0'){echo "<img src='".$config['home']."/forum/img/t.gif' alt=''> ";}
elseif($top['status'] == '1'){echo "<img src='".$config['home']."/forum/img/bt.gif' alt=''> ";}}

echo "<a href='".$config['home']."/forum/?act=posts&amp;id=".$top['id']."&amp;".SID."'><b>".$top['name']."</b></a><br>";

if (file_exists(BASEDIR."local/profil/".$top['author'].".prof")) {
$date = file(BASEDIR."local/profil/$top[author].prof"); 
$date = explode(":||:",$date[0]);
echo "Создал: <a href='../pages/anketa.php?uz=".$top['author']."&amp;".SID."'>";
if ($date[65]) {echo "".$date['65']."</a><br>";
}else{echo "".$top['author']."</a><br>";}
}else{echo "Создал: ".$top['author']."<br>";}
echo "Кратко: ".$top['description']." <br>\n";
echo "Последний: "; 
$ldate = file(BASEDIR."local/profil/".$top['last'].".prof"); 
$ldate = explode(":||:",$ldate[0]);
if ($ldate[65]) {echo "".$ldate['65']." ";
}else{echo "".$top['last']." ";}
echo "(".date_fixed($top['time']).")<hr></div>\n";
}}else{ echo "<br> <img src='../images/img/close.gif' alt=''> Темы еще не созданны!<br><hr>\n";}

echo ": <a href='".$config['home']."/forum/'>К форумам</a><br>"; 
echo ":: <a href='".$config['home']."'>На главную</a><br>"; 

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>