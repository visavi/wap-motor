<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");


if ($_REQUEST['chto'] != NULL || $_REQUEST['who'] !=NULL || $_REQUEST['wh'] != NULL){
if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}
$total = 0;


function pages($start, $total, $onpage, $home){
if ($start != 0) 
echo '<a href="'.$home.'/forum/search.php?start='.($start - $onpage).'">&lt;-Назад</a> ';
else echo '&lt;-Назад';
echo ' | ';
if ($total > $start + $onpage)
echo ' <a href="'.$home.'/forum/search.php?start='.($start + $onpage).'">Далее-&gt;</a>';
else echo 'Далее-&gt;';
if ($total > 0) {
$ba = ceil($total / $onpage);
$ba2 = $ba * $onpage - $onpage;
echo '<br/>Страницы:';
$asd = $start - ($onpage * 3);
$asd2 = $start + ($onpage * 4);
if ($asd < $total && $asd > 0) 
echo ' <a href="'.$home.'/forum/search.php?start=0">1</a> ... ';
for($i = $asd; $i < $asd2;) {
if ($i < $total && $i >= 0) {
$ii = floor(1 + $i / $onpage);
if ($start == $i) echo ' <b>[' . $ii . ']</b>';
else echo ' <a href="'.$home.'/forum/search.php?start='.$i.'&amp;'.SID.'">' . $ii . '</a>';} 
$i = $i + $onpage;} 
if ($asd2 < $total) echo ' ... <a href="'.$home.'/forum/?act=themes&amp;id='.$id.'&amp;start='.$ba2.'&amp;'.SID.'">' . $ba . '</a>';}} 



$chto = check($_REQUEST['chto']);
$whos = check($_REQUEST['who']);
$wh = (int)$_REQUEST['wh'];}
$who = substr($whos, 2);
$substrw = $whos{0}; 

if (strlen($chto) < '3'){echo '<br><div><img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>Слишком маленький запрос!</small></div><br><hr><div>';
echo ': <a href="'.$config['home'].'/forum/index.php?act=search&amp;'.SID.'">Поиск</a><br>';
echo ':: <a href="'.$config['home'].'/forum/index.php?'.SID.'">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/index.php?'.SID.'">На главную</a>';
echo '</div><div style="margin: 0px 0px -5px 0px"><img src="'.$config['home'].'/forum/img/byforum.gif" alt=""></div>';
include_once ("../themes/".$config['themes']."/foot.php"); exit;}

if (strlen($chto) > '32'){echo '<br><div><img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>Слишком большой запрос!</small></div><br><hr><div>';
echo ': <a href="'.$config['home'].'/forum/index.php?act=search&amp;'.SID.'">Поиск</a><br>';
echo ':: <a href="'.$config['home'].'/forum/index.php?'.SID.'">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/index.php?'.SID.'">На главную</a>';
echo '</div><div style="margin: 0px 0px -5px 0px"><img src="'.$config['home'].'/forum/img/byforum.gif" alt=""></div>';
include_once ("../themes/".$config['themes']."/foot.php"); exit;}

echo '<div class="b"> Поиск по форуму</div>';


if ($wh == '0'){

if ($who !='0'){
if ($substrw =='f'){
$sqlresult = "SELECT * FROM `theme` WHERE `name` LIKE '%".$chto."%' AND `forums` LIKE '".$who."' LIMIT $start, 10";
}else{
$sqlresult = "SELECT * FROM `theme` WHERE `name` LIKE '%".$chto."%' AND `under` LIKE '".$who."' LIMIT $start, 10";}
}else{$sqlresult = "SELECT * FROM `theme` WHERE `name` LIKE '%".$chto."%' LIMIT $start, 10";}


$sar = mysql_query($sqlresult);
if (mysql_num_rows($sar)) {


if ($who !='0'){
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `name` LIKE '%".$chto."%' AND `under` LIKE '%".$who."%'"),0);
}else{
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `name` LIKE '%".$chto."%' "),0);}
$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if ($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;


while ($src = mysql_fetch_array($sar)) {
echo '<div><img src="'.$config['home'].'/forum/img/t.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/posts/'.$src['id'].'"><b>'.$src['name'].'</b></a><br>';

echo '<small>Создал: '.nickname($src['author']).' <br>';
if($src['description']){echo 'Кратко: '.$src['description'].' <br>';}
echo 'Последний: '.nickname($src['last']).' <br>';
echo '</small><hr></div>';}
}else{ echo '<br><div><img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>По вашему запросу ничего не найдено!</small></div><br><hr>';}}

elseif ($wh=='1'){

if ($who != '0'){

if ($substrw =='f'){
$sqlresult = "SELECT * FROM `posts` WHERE `forums` = '".$who."' AND `msg` LIKE '%".$chto."%'  LIMIT $start, 10";
}else{
$sqlresult = "SELECT * FROM `posts` WHERE `under` = '".$who."' AND `msg` LIKE '%".$chto."%' LIMIT $start, 10";}


}else{$sqlresult = "SELECT * FROM `posts` WHERE `msg` LIKE '%".$chto."%' LIMIT $start, 10";}

$sar = mysql_query($sqlresult);
if (mysql_num_rows($sar)) {


if ($who !='0'){
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `msg` LIKE '%".$chto."%' AND `under` LIKE '%".$who."%'"),0);
}else{
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `msg` LIKE '%".$chto."%' "),0);}

$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if ($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;


while ($src = mysql_fetch_array($sar)) {
$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$src['theme']."' ");
$thm = mysql_fetch_array($thms);
echo '<div><img src="'.$config['home'].'/forum/img/t.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=posts&amp;id='.$thm['id'].'"><b>'.$thm['name'].'</b></a><br>';



if (strlen($src['msg']) > '1000') {
echo 'Сообщение: '.antimat(bb_code(check(utf_substr($src['msg'])))).' <br>';
echo '<a href="'.$config['home'].'/forum/?act=poste&amp;id='.$src['theme'].'&amp;pid='.$src['id'].'">Читать все >></a><br>';
}else{
echo 'Сообщение: '.antimat(bb_code(check($src['msg']))).' <br>';
}

echo '<small>Написал: ';
if (!empty($post['author_n'])){
echo '<b>'.$src['author_n'].'</b>';
}else{
echo '<b>'.$src['author'].'</b>';}
echo ' ('.date_fixed($src['time']).')</small><hr></div>';}
}else{ echo '<br><div><img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>По вашему запросу ничего не найдено!</small></div><br>';}}






echo '<div>';
if ($total > '10'){ pages($start, $total, 10, $config['home']); echo '<hr>';}

echo ': <a href="'.$config['home'].'/forum/index.php?act=search&amp;'.SID.'">Поиск</a><br>';
echo ':: <a href="'.$config['home'].'/forum/index.php?'.SID.'">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/index.php?'.SID.'">На главную</a></div>';

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>