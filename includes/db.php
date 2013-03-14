<?php
$db['host']='localhost';
$db['db']=''; // Имя базы данных
$db['user']=''; // Логин пользователя
$db['pass']=''; // Пароль

@mysql_connect($db['host'],$db['user'],$db['pass']) or die('Нет соединения с БД');
@mysql_select_db($db['db']) or die('Ошибка БД!');
mysql_query('SET NAMES utf8');


/////////////////////////////////////////////////////Небольшие настройки///////////////////////////////////////////////////////////
$config_msg_pr_nikname = "SYSTEM"; /// От кого приходят оповещения в приват!
/* 
$conf_forum_files = "1"; /// Удалять файлы по истичению времени (0- нет / 1-да)
$conf_forum_files_time = "30"; /// Сколько суток хранить файлы на сайте 
*/
$conf_forum_ppfor = "1"; /// Выводить последнюю тему под подфорумом (0- нет / 1-да)
$config_floodstime_thm = "0"; /// Антифлуд на создание тем(В секундах)
$config_strtsz = "1"; /// Выводить рейтинг юзера под ником (0- нет / 1-да)
//////////////////////////////////////////////////// 
//////// Статусы! для бетки сделал такие :)
//////// для демки взято из джона
//////////////////////////////////////////////////////
function strtsz($login){ 

if (file_exists(DATADIR."profil/$login.prof")){

$text = file_get_contents(DATADIR."profil/$login.prof"); 
$date = explode(":||:",$text);

if ($date['36'] < '100'){$status = '<span style="color:#ff0000;"> [Шнырь] </span>';}
if ($date['36'] >= '100') {$status = '<span style="color:#ff0000;"> [Юзер] </span>';}
if ($date['36'] >= '300') {$status = '<span style="color:#00ff00;"> [Чатер] </span>';}
if ($date['36'] >= '500') {$status = '<span style="color:#00ff00;"> [Клубер] </span>';}
if ($date['36'] >= '700') {$status = '<span style="color:#ff0000;"> [Свой человек] </span>';}
if ($date['36'] >= '1000') {$status = '<span style="color:#ff0000;"> [Мужиг] </span>';}
if ($date['36'] >= '1500') {$status = '<span style="color:#ff0000;"> [Супер мужиг] </span>';}
if ($date['36'] >= '2000') {$status = '<span style="color:#ff0000;"> [Мего мужиг] </span>';}
} else {
$status = '[Мертвец]';
}

return $status;
}

//////////////////////////////////////////////////// Считаеем кол-во страниц/////////////////////////////////////////////
function strts($id, $config_forumpost){
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$id."'"), 0);
if (!empty($filek)) { $filek = $filek-1;} 
$page = floor($filek / $config_forumpost) * $config_forumpost;
return $page;
}
//////////////////////////////////////////////////// Навигация/////////////////////////////////////////////
function fnc_navig($start, $total, $onpage, $page){

if ($start != 0){
echo '<a href="'.$page.'&amp;start='.($start - $onpage).'&amp;'.SID.'">&lt;-Назад</a> ';
}else{ echo '&lt;-Назад'; }
echo ' | ';
if ($total > $start + $onpage){
echo ' <a href="'.$page.'&amp;start='.($start + $onpage).'&amp;'.SID.'">Далее-&gt;</a>';
}else{ echo 'Далее-&gt;'; }

if ($total > 0) {
$ba = ceil($total / $onpage);
$ba2 = $ba * $onpage - $onpage;

echo '<br/>Страницы:';
$asd = $start - ($onpage * 3);
$asd2 = $start + ($onpage * 4);

if ($asd < $total && $asd > 0) {
echo ' <a href="'.$page.'/">1</a> ... ';}
for($i = $asd; $i < $asd2;) {
if ($i < $total && $i >= 0) {
$ii = floor(1 + $i / $onpage);
if ($start == $i){ echo ' <b>[' . $ii . ']</b>';
}else{ echo ' <a href="'.$page.'&amp;start='.$i.'&amp;'.SID.'">' . $ii . '</a>';}
} 
$i = $i + $onpage;
} 
if ($asd2 < $total){ echo ' ... <a href="'.$page.'&amp;start='.$ba2.'&amp;'.SID.'">' . $ba . '</a>';}
}
} 

?>

