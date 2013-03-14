<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (isset($_GET['act'])) {$act = check($_GET['act']);} else {$act = "";}
switch ($act) {
default:
//////////////////////////////////////////////////////Подключение админки  /////////////////////////////////////////////
if (isset($_GET['m']) && $_GET['m'] == 1) {
if (is_admin(array(101,102,103,105))){
$_SESSION['mufbc']=1;  header ("Location: index.php?".SID);  exit;}} 

if (isset($_GET['m']) && $_GET['m'] == 2) {
if (is_admin(array(101,102,103,105))){
$_SESSION['mufbc'] = '';  header ("Location: index.php?".SID);  exit;}}

////////////////////////////////////////////////////// очищаем таблицу who  /////////////////////////////////////////////
if (is_user()){mysql_query("DELETE FROM `who` WHERE `user` = '$log'");} 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (is_user()){
echo '<div class="b"> Мои: ';
echo ' <a href="'.$config['home'].'/forum/mythem.php?'.SID.'">темы</a>, ';
echo ' <a href="'.$config['home'].'/forum/mypost.php?'.SID.'">сообщения</a></div>';
} 
		
echo '<div><small><a href="#down">Вниз</a> | Новые: ';
echo ' <a href="'.$config['home'].'/forum/newthem.php?'.SID.'">темы</a>, ';
echo ' <a href="'.$config['home'].'/forum/newpost.php?'.SID.'">сообщения</a> ';
echo '</small></div>';
		
////////////////////////////////////////////////////// Выводим разделы  /////////////////////////////////////////////
		
$forums = mysql_query('SELECT * FROM `forums` ORDER BY `position` ASC');
if (mysql_num_rows($forums)) {
while ($forum = mysql_fetch_array($forums)) {
echo '<div class="b"><img src="'.$config['home'].'/forum/img/rd.gif" alt=""> <b>'.$forum['name'].'</b> ';
echo '('.$forum['under'].'/'.$forum['theme'].'/'.$forum['posts'].')';

////////////////////////////////////////////////////// Функции админа /////////////////////////////////////////////
if (is_admin(array(101,102))){
if (!empty($_SESSION['mufbc'])) {
echo '<small>';
echo '<a href="'.$config['home'].'/forum/index.php?act=delfm&amp;id='.$forum['id'].'&amp;'.SID.'">Удал</a>|';
echo '<a href="'.$config['home'].'/forum/index.php?edfm=1&amp;id='.$forum['id'].'&amp;'.SID.'">Изм</a>|';
echo '<a href="'.$config['home'].'/forum/index.php?act=dowfm&amp;id='.$forum['id'].'&amp;'.SID.'">Вниз</a>|';
echo '<a href="'.$config['home'].'/forum/index.php?act=upfm&amp;id='.$forum['id'].'&amp;'.SID.'">Вверх</a>|';
echo '<a href="update.php?id='.$forum['id'].'&amp;'.SID.'">Обнов</a>';
echo '</small>';}}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '</div><div>';
if (is_admin(array(101,102))){
if (!empty($_SESSION['mufbc']) && $forum['under'] > '0') {
echo '<div align="right"><a href="moders.php?id='.$forum['id'].'&amp;'.SID.'">Назначить управляющих</a></div>';}}	
			
////////////////////////////////////////////////////// Выводим подфорумы  /////////////////////////////////////////////	
	
$unders = mysql_query("SELECT * FROM `under` WHERE `forum` = '" . $forum['id'] . "' ORDER BY `position` DESC");
if (mysql_num_rows($unders)) {
while ($under = mysql_fetch_array($unders)) {
echo '<img src="img/pfr.png" alt=""> <b><a href="'.$config['home'].'/forum/index.php?act=themes&amp;id='.$under['id'].'&amp;'.SID.'">'.$under['name'].'</a></b>';
echo " (" . $under['theme'] . "/" . $under['posts'] . ")";

////////////////////////////////////////////////////// Функции админа /////////////////////////////////////////////

if (is_admin(array(101,102))){
if (!empty($_SESSION['mufbc'])) {
echo '<small>';
echo '<a href="'.$config['home'].'/forum/?act=delund&amp;id='.$under['id'].'&amp;'.SID.'">Удал</a>|';
echo '<a href="index.php?edund=1&amp;id='.$under['id'].'&amp;'.SID.'">Изм</a>|';
echo '<a href="move.php?act=undown&amp;id='.$under['id'].'&amp;'.SID.'">Вниз</a>|';
echo '<a href="move.php?act=unup&amp;id='.$under['id'].'&amp;'.SID.'">Вверх</a>|';
echo '<a href="update.php?act=under&amp;id='.$under['id'].'&amp;'.SID.'">Обнов</a>';
echo '</small>';}} echo '<br>';} 

////////////////////////////////////////////////////// Вывод последней темы /////////////////////////////////////////////		

if ($conf_forum_ppfor == '1') {
if ($forum['last_theme']!='0' || $forum['theme']!='0') {

if ($forum['last_posts'] > '10') {
echo '<small>Тема: <a href="'.$config['home'].'/forum/index.php?act=posts&amp;id='.$forum['last_theme'].'&amp;&start='.strts($forum['last_theme'], $config['forumpost']).'&amp;'.SID.'">'.$forum['last_theme_name'].'</a><br>';
} else {echo'<small>Тема: <a href="'.$config['home'].'/forum/index.php?act=posts&amp;id='.$forum['last_theme'].'&amp;'.SID.'">'.$forum['last_theme_name'].'</a><br>';
}
echo 'Сообщение: '.$forum['last_login'].' ('.date_fixed($forum['last_time']).')</small>';
}else{ echo '<img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>Темы еще не созданны!</small><br>';}}
}else{ echo '<img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>Подфорумы еще не созданны!</small><br>';}
echo '</div>';
}

//////////////////////////////////////////////////////Конец вывода подфорумов/////////////////////////////////////////////	

}else{ echo '<div><br><img src="'.$config['home'].'/forum/img/err.gif" alt=""><small>Разделы еще не созданны!</small></div><br>';} 
if (isset($_GET['edfm']) && $_GET['edfm'] == 1) {
if (is_admin(array(101,102))){ echo '<hr>';

$id = (int)$_GET['id'];
if (isset($id)){

$check = mysql_fetch_array(mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'"));

if (!empty($check)) {
if (isset($_POST['name'])) {

$name = check($_POST['name']);
if (strlen($name) >= '3') {
if (strlen($name) <= '50') {

mysql_query("UPDATE `forums` SET `name`='$name' WHERE `id` = '".$id."'");
header ("Location: index.php?".SID);  exit;

}else{echo '<div align="center"><font color="red"><b>Название должно состоять не больше 50 символов!</b></font></div><br>';} 
}else{echo '<div align="center"><font color="red"><b>Название должно состоять не меньше 3х символов!</b></font></div><br>';}} 

$thms = mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'");
$thm = mysql_fetch_array($thms);

echo '<form action="index.php?edfm=1&amp;id='.$id.'" method="post">';
echo 'Название раздела:<br><input type="text" name="name" value="'.$thm['name'].'" maxlength="50"><br>';
echo '<input type="submit" value="Изменить"></form>';

}
}
}
}

        
		
if (isset($_GET['edund']) && $_GET['edund'] == 1) {
if (is_admin(array(101,102))){
echo '<hr>';
$id = (int)$_GET['id'];
if (isset($_POST['undname'])) {$undname = check($_POST['undname']);}
if (isset($_POST['fums'])) {$fums = (int)$_POST['fums'];} else {$fums = 0;}
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'"));

if (!empty($check)) {
if (isset($undname)) {
$undname = check($_POST['undname']);
if (strlen($undname) >= '3') {
if (strlen($undname) <= '50') {

mysql_query("UPDATE `under` SET `name`='".$undname."' WHERE `id` = '".$id."'");
if (!empty($fums)) {mysql_query("UPDATE `under` SET `forum`='".$fums."' WHERE `id` = '".$id."'");
} 

header ("Location: index.php?".SID);  exit;

}else{echo "<div align=center><font color=red><b>Название должно состоять не больше 50 символов!</b></font></div><br>\n";} 
}else{echo "<div align=center><font color=red><b>Название должно состоять не меньше 3х символов!</b></font></div><br>\n";}
}
}
                        
$thms = mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'");
$thm = mysql_fetch_array($thms);

echo '<form action="index.php?edund=1&amp;id='.$id.'" method="post">';
echo 'Раздел: <br><select name="fums">';

$frms = mysql_query("SELECT * FROM `forums`");
if (mysql_num_rows($frms)) {
echo '<option selected="selected">Выбирите раздел </option>';

while ($frm = mysql_fetch_array($frms)) {
echo '<option value="'.$frm['id'].'">'.$frm['name'].'</option>';} 
}else{ echo '<option selected="selected">Разделов нет </option>';} 
echo '</select><br>';
echo 'Название раздела:<br><input type="text" name="undname" value="'.$thm['name'].'" maxlength="50"><br>';
echo '<input type="submit" value="Изменить"></form>';
}
}
}



if (isset($_GET['addf']) && $_GET['addf'] == 1) {
if (is_admin(array(101,102))){
echo '<hr>';
if (isset($_POST['name'])) {$name = check($_POST['name']);} else {$name = '';}
if ($name) {
if (strlen($name) >= '3') {
if (strlen($name) <= '50') {

$fmrnu = mysql_result(mysql_query("SELECT COUNT(*) FROM `forums`"), 0);
mysql_query ("INSERT INTO `forums` (name,position) VALUES ('".$name."','".$fmrnu."')");
$frm = mysql_result(mysql_query("SELECT COUNT(*) FROM `forums`"), 0);
mysql_query("UPDATE `stat` SET `forum`='".$frm."'");

$efile = file(BASEDIR."local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['0'] = $frm;

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

header ("Location: index.php?addf=1".SID); exit;

} else { echo '<div align="center"><font color="red"><b>Название должно состоять не больше 50 символов!</b></font></div><br>';} 
} else { echo '<div align="center"><font color="red"><b>Название должно состоять не меньше 3х символов!</b></font></div><br>';}
} 
                    
echo '<form action="index.php?addf=1" method="post">';
echo 'Название раздела:<br><input type="text" name="name" maxlength="50"><br>';
echo '<input type="submit" value="Создать"></form>';
}
} 

if (isset($_GET['addr']) && $_GET['addr'] == 1) {
if (is_admin(array(101,102))){
echo "<hr>\n";
if (isset($_POST['undername'])) {$undername = check($_POST['undername']);} else {$undername = '';}
if (isset($_POST['forumsid'])) {$forumsid = (int)$_POST['forumsid'];} else {$forumsid = 0;}
if ($undername) {
if ($forumsid) {
if (strlen($undername) >= '3') {
if (strlen($undername) <= '50') {

$undername = stripcslashes(htmlspecialchars($undername));
$psn = mysql_result(mysql_query("SELECT COUNT(*) FROM `under`"), 0) + 1;

mysql_query("INSERT INTO `under` (name,forum,position,theme,posts) VALUES ('".$undername."','".$forumsid."','".$psn."',0,0)");

$und = mysql_result(mysql_query("SELECT COUNT(*) FROM `under`"), 0);
$frm = mysql_result(mysql_query("SELECT COUNT(*) FROM `under` WHERE `forum` = '".$forumsid."'"), 0);
mysql_query("UPDATE `stat` SET `under`='".($und+1)."'");
mysql_query("UPDATE `forums` SET `under`='".($frm+1)."' WHERE `id`='".$forumsid."'");
                                    
$efile = file(BASEDIR."local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['1'] = $und;

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

header ("Location: index.php".SID); exit;

} else { echo '<div align="center"><font color="red"><b>Название должно состоять не больше 50 символов!</b></font></div><br>';} 
} else { echo '<div align="center"><font color="red"><b>Название должно состоять не меньше 3х символов!</b></font></div><br>';} 
} else { echo '<div align="center"><font color="red"><b>Не выбранн раздел!</b></font></div><br>';} 
} 

echo '<form action="index.php?addr=1" method="post">';
echo 'Раздел: <br><select name="forumsid">';

$frms = mysql_query("SELECT * FROM `forums`");
if (mysql_num_rows($frms)) {
echo '<option value="0" selected="selected">Выбирите раздел </option>';
while ($frm = mysql_fetch_array($frms)) {
echo '<option value="'.$frm['id'].'">'.$frm['name'].'</option>';} 
} else { echo '<option selected="selected">Разделов нет </option>';} 
echo '</select><br>';
echo 'Название раздела:<br><input type="text" name="undername" maxlength="50"><br>';
echo '<input type="submit" value="Создать"></form>';}} 

echo '<hr><div><small>';
echo '<a href="#up">Вверх</a> | ';
echo '<a href="'.$config['home'].'/forum/?act=search&amp;'.SID.'">Поиск</a> | ';
echo '<a href="'.$config['home'].'/forum/top.php?'.SID.'">Топ тем</a> | ';
echo '<a href="'.$config['home'].'/forum/?act=where&amp;'.SID.'">Кто в форуме</a></small>';

if (is_admin(array(101,102))){
if (!empty($_SESSION['mufbc']) && $_SESSION['mufbc']) {
echo '<div class="b">Создать: ';
echo '<a href="index.php?addf=1&amp;'.SID.'">Раздел</a>, ';
echo '<a href="index.php?addr=1&amp;'.SID.'">Подфорум</a>';
echo '| <a href="index.php?m=2&amp;'.SID.'">Выход</a>';
echo '</div>';
}else{ echo '<small> | <a href="?m=1&amp;'.SID.'">Адм</a></small>';
}
}

echo "</div>"; break;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////   Подфорумы   ////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		


case('themes'):
$id = (int)$_GET['id'];
if (!empty($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'"));
if (!empty($check)) {

$unders = mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."' ");
$under = mysql_fetch_array($unders);
$forums = mysql_query("SELECT id,name FROM `forums` WHERE `id` = '".$under['forum']."'");
$forum = mysql_fetch_array($forums);
$uposts = $under['theme'];

////////////////////////////////////////////////////// Записываем место нахождение юзера////////////////////////////////////////	

if (is_user()) {
mysql_query("DELETE FROM `who` WHERE `user` = '".$log."'");
mysql_query("DELETE FROM `who` WHERE `time` < '".(SITETIME-120)."'");
mysql_query("INSERT INTO `who` (theme,under,user,time) values(0,'".$id."','".$log."','".SITETIME."')");} 

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="b"><a href="'.$config['home'].'/forum/index.php?'.SID.'">Форум</a> | '.$forum['name'].' | <b>'.$under['name'].'</b></div>';
echo '<div><small><a href="#down">Вниз</a> | ';

if (is_user()) {
echo '<a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Создать тему</a> | ';} 
echo '<a href="'.$config['home'].''.$_SERVER['REQUEST_URI'].'">Обновить</a></small></div>';

///////////////////////////////////////////////////// Навигация /////////////////////////////////////////////////////

$total = $uposts;
$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if ($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$themes = mysql_query("SELECT * FROM `theme` WHERE `under` = '".$id."' ORDER BY `locked` DESC, `time` DESC LIMIT $start, 10");
if (mysql_num_rows($themes)) {
while ($theme = mysql_fetch_array($themes)) {

////////////////////////////////////////////////  Выводим темы ////////////////////////////////////////////////////////////////
echo "<div class=b>";
if (!empty($theme['locked'])) {
if (!empty($theme['status'])){echo '<img src="'.$config['home'].'/forum/img/zt2.gif" alt=""> '; }
elseif(empty($theme['status'])){echo '<img src="'.$config['home'].'/forum/img/zt.gif" alt=""> ';}}
if (empty($theme['locked'])) {
if (!empty($theme['status'])){echo '<img src="'.$config['home'].'/forum/img/bt.gif" alt=""> '; }
elseif(empty($theme['status'])){echo '<img src="'.$config['home'].'/forum/img/t.gif" alt=""> ';}}
if (!empty($theme['vote'])){echo '<img src="'.$config['home'].'/forum/img/v.gif" alt=""> '; }

echo '<a href="'.$config['home'].'/forum/?act=posts&amp;id='.$theme['id'].'&amp;'.SID.'"><b>'.$theme['name'].'</b></a> ['.$theme['posts'].']';
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '" . $theme['id'] . "'"), 0);
if(!empty($filek)){
if (!empty($filek)) { $filek = $filek-1; } 
$page = floor($filek / $config['forumpost']) * $config['forumpost'];

echo '<a href="'.$config['home'].'/forum/?act=posts&amp;id='.$theme['id'].'&amp;start='.$page.'&amp;'.SID.'"> <small>&gt;&gt;</small></a> ';}
echo "</div><div>\n";
echo 'Создал: '.nickname($theme['author']).'<br>';
if ($theme['description']){ echo 'Кратко: '.$theme['description'].'<br>';}
if (!empty($theme['files'])) { echo 'Вложений: '.$theme['files'].'<br>';} 
echo 'Последний: <small>'.nickname($theme['last']).' ('.date_fixed($theme['time']).')</small>';
if (!empty($_SESSION['mufbc'])) {echo '<hr>[<a href="'.$config['home'].'/forum/thmedit.php?id='.$theme['id'].'&amp;'.SID.'">Редактировать</a>]<br>';} 
echo '</div>';} 
}else{echo '<br><br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Темы еще не созданны! </div>'; } 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		

echo '<br><div class="b">Всего тем: '.$under['theme'].'</div>';

////////////////////////////////////////     Вывод управляющих   //////////////////////////////////////////////////////////////

$mdt = mysql_result(mysql_query("SELECT COUNT(*) FROM `moders`  WHERE `under` = '".$id."'"),0);
$mdes = mysql_query("SELECT * FROM `moders` WHERE `under` = '".$id."' ORDER BY `id`");
if (mysql_num_rows($mdes)) {
echo '<div><b>Управляющие:</b> '; $nmm=0;
while ($mds = mysql_fetch_array($mdes)) { $nmm++;
if($nmm == $mdt){echo ''.nickname($mds['login']).' ';	}else{  echo ''.nickname($mds['login']).', ';	}}
echo '</div><hr>';}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
if ($total > '10'){fnc_navig($start, $total, 10, $config['home'].'/forum/index.php?act=themes&amp;id='.$id);}

echo '<div><small>';
echo '<a href="#up">Вверх</a> | ';
if (is_user()) { echo '<a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Создать тему</a> | ';} 
echo '<a href="'.$config['home'].'/forum/top.php&amp;'.SID.'">Топ тем</a> | ';
echo '<a href="'.$config['home'].'/forum/?act=who&amp;id='.$id.'&amp;'.SID.'">Кто тут?('.mysql_result(mysql_query("SELECT COUNT(*) FROM `who` WHERE `under`='".$id."'"), 0).')</a>';
echo '</small></div>';

}else{ echo '<br> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Данного раздела не существует!<br><br>';} 
}else{ echo '<br> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Данного раздела не существует!<br><br>';} 
break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////  Создание темы    /////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
case('theme'):
$id = (int)$_GET['id'];
if (is_user()) {
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'"));
if (!empty($check)) {

$unders = mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'");
$under = mysql_fetch_array($unders);
$forums = mysql_query("SELECT id,name FROM `forums` WHERE `id` = '".$under['forum']."'");
$forum = mysql_fetch_array($forums);

echo '<div class="b"> <a href="'.$config['home'].'/forum">Форум</a> | '.$forum['name'].' | <b>'.$under['name'].'</b></div><div>';
echo '<form action="'.$config['home'].'/forum/?act=themeadd&amp;id='.$id.'&amp;'.SID.'" method="post">';
echo 'Название (Max-50):<br><input type="text" name="theme" maxlength="50"><br>';
echo 'Описание (Max-100):<br><input type="text" name="description" maxlength="100"><br>';
echo 'Сообщение (Max-5000):<br><textarea cols="25" rows="3" name="msg" maxlength="50000"></textarea><br>';
echo '<input type="submit" value="Создать"></form></div>';

}else{echo'<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Данного раздела не существует!</div><br>';} 
}else{echo'<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Данного раздела не существует!</div><br>';} 
}
break;
		
		


case('themeadd'):
$id = (int)$_GET['id'];
if (is_user()) {
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'"));
if (!empty($check)) {

$unders = mysql_query("SELECT id,name,forum FROM `under` WHERE `id` = '".$id."'");
$under = mysql_fetch_array($unders);
$forums = mysql_query("SELECT id,name FROM `forums` WHERE `id` = '".$under['forum']."'");
$forum = mysql_fetch_array($forums);


$time = SITETIME - $config_floodstime_thm;
$af = mysql_query("SELECT * FROM `theme` WHERE `author`='".$log."' AND `time` >='".$time."'");
$af1 = mysql_num_rows($af); if ($af1 > '0') {

echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Нельзя так часто создавать темы! лимит '.$config_floodstime_thm.' cекунд</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 

$msg = check($_POST['msg']);
$theme = check($_POST['theme']);
$description = check($_POST['description']);

$compr = mysql_query("SELECT `name` FROM `theme` WHERE `author` = '".$log."' ORDER BY `id` DESC");
$cpr = mysql_fetch_array($compr);

if (!strcmp($cpr['name'], $theme)) {
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Тема идентична предыдущей!</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 
 
if (strlen($theme) < '5') {
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком маленько название!</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 

if (strlen($msg) < '5'){
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком маленько сообщение!</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 

if (strlen($theme) > '50') {
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком большое название!</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 

if (strlen($description) > '100') { 
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком большое описание!</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 

if (strlen($msg) > '5000') {
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком большое сообщение!</div><br>';
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=theme&amp;id='.$id.'&amp;'.SID.'">Назад</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 
                    
				
mysql_query ("INSERT INTO `theme` (forums,under,name,description,author,created,last,time,status,locked,brow,ip) VALUES 
('".$forum['id']."','".$under['id']."','".$theme."','".$description."','".$log."','".SITETIME."','".$log."','".SITETIME."','0','0','".$brow."','".$ip."')");

$lstth = mysql_query("SELECT id FROM `theme` WHERE `author` = '".$log."' ORDER BY `id` DESC LIMIT 1");
$lst = mysql_fetch_array($lstth);

mysql_query ("INSERT INTO `posts` (forums,under,theme,msg,author,author_n,time,brow,ip,edit) VALUES 
('".$forum['id']."','".$under['id']."','".$lst['id']."','".$msg."','".$log."','".nickname($_SESSION['log'])."','".SITETIME."','$brow','$ip','0')");

mysql_query("UPDATE `theme` SET `posts`='1' WHERE `id` = '".$lst['id']."'");
mysql_query("UPDATE `theme` SET `first`='".$lst['id']."' WHERE `id` = '".$lst['id']."'");


mysql_query("UPDATE `forums` SET `last_theme`='".$lst['id']."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `forums` SET `last_theme_name`='".$theme."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `forums` SET `last_time`='".SITETIME."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `forums` SET `last_posts`='0' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `forums` SET `last_login`='".nickname($_SESSION['log'])."' WHERE `id` = '".$forum['id']."'");
$frm = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `forums` = '".$forum['id']."'"), 0);
$udr = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `under` = '".$under['id']."'"), 0);
$thm = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme`"), 0);
mysql_query("UPDATE `forums` SET `theme`='".($frm+1)."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `under` SET `theme`='".($udr+1)."' WHERE `id` = '".$under['id']."'");

$frm2 = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `forums` = '".$forum['id']."'"), 0);
$udr2 = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `under` = '".$under['id']."'"), 0);
mysql_query("UPDATE `forums` SET `posts`='".$frm2."' WHERE `id` = '".$forum['id']."'");
mysql_query("UPDATE `under` SET `posts`='".$udr2."' WHERE `id` = '".$under['id']."'");

$etext = '';
$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$thm2 = $thm + 1;
$edata['2'] = $thm2;

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

header ("Location: ".$config['home']."/forum/?act=themes&id=".$id."&".SID);exit; 


}else{ echo "<br> <img src='../images/img/close.gif' alt=''> Ошибка! Данного раздела не существует!<br>\n"; } 
}else{echo "<br> <img src='../images/img/close.gif' alt=''> Ошибка! Данного раздела не существует!<br>\n"; }} 
break;


case('posts'):
$id = (int)$_GET['id'];
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."'"));
if (!empty($check)) {$n = 0;
////////////////////////////////////////////////////// Записываем место нахождения/////////////////////////////////////////////

if (is_user()) {
if (isset($log))mysql_query("DELETE FROM `who` WHERE `user` = '".$log."'");
mysql_query("DELETE FROM `who` WHERE `time` < '" . (SITETIME-120) . "'");
if (isset($log))mysql_query("INSERT INTO `who` (theme,under,user,time) values('".$id."','0','".$log."','".SITETIME."')");} 

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
               
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);
$uposts = $theme['posts'];
$unders = mysql_query("SELECT * FROM `under` WHERE `id` = '".$theme['under']."'");
$under = mysql_fetch_array($unders);
$forums = mysql_query("SELECT id,name FROM `forums` WHERE `id` = '".$under['forum']."'");
$forum = mysql_fetch_array($forums);

////////////////////////////////////////////////////// Управление темой  /////////////////////////////////////////////

$total = $theme['posts'];
$start = isset($_GET['start']) ? abs((int)$_GET['start']) : 0;
if ($start > $total){ $start = 0;}
if ($total < $start + $config['forumpost']){ $end = $total;
}else{ $end = $start + $config['forumpost'];}
$n = $start + $n;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="b"><small>';
echo '<a href="'.$config['home'].'/forum/index.php?'.SID.'">Форум</a> | '.$forum['name'].' | ';
echo '<a href="'.$config['home'].'/forum/?act=themes&amp;id='.$under['id'].'&amp;'.SID.'">'.$under['name'].'</a><br>';
echo 'Тема:</small> '.$theme['name'].'<br>';
echo '<small>Автор: '.nickname($theme['author']).'</small></div>';



echo '<div><small><a href="#down">Вниз</a> | ';

echo '<a href="'.$config['home'].'/forum/?act=posts&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Обновить</a> ';

if ($theme['author'] == $log && $udata['36'] > 500) {
if ($theme['status'] != '1') { echo '| <a href="'.$config['home'].'/forum/?act=sts&amp;id='.$id.'">Закрыть</a> '; }} 


echo '</small></div>';

if (is_user()) {
$checks = mysql_fetch_array(mysql_query("SELECT * FROM `moders` WHERE `login` = '".$log."' AND `under` = '".$under['id']."' "));
if (!empty($checks)) {
echo '<div>';
if ($theme['status'] != "1") {
echo '<hr><img src="'.$config['home'].'/images/img/close.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=status&amp;id='.$id.'">Закрыть</a>';
} else {
echo '<hr><img src="'.$config['home'].'/images/img/open.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=status&amp;id='.$id.'">Открыть</a>';} 
echo '</div>';}}

if (!empty($_SESSION['mufbc'])) {
if (is_admin(array(101,102,103,105))) {
echo '<div><hr>';
if ($theme['status'] != "1") {
echo '<img src="'.$config['home'].'/images/img/close.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=status&amp;id='.$id.'">Закрыть</a>';
} else {
echo '<img src="'.$config['home'].'/images/img/open.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=status&amp;id='.$id.'">Открыть</a>';} 
if ($theme['locked'] != "1") {
echo ' <img src="'.$config['home'].'/images/img/open.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=locked&amp;id='.$id.'">Закрепить</a>';
}else{
echo ' <img src="'.$config['home'].'/images/img/close.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=locked&amp;id='.$id.'">Открепить</a>';} 
echo ' <img src="'.$config['home'].'/images/img/close.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/?act=del&amp;id='.$id.'">Удалить</a>';
echo ' <img src="'.$config['home'].'/images/img/panel.gif" alt=""> ';
echo '<a href="'.$config['home'].'/forum/thmedit.php?id='.$id.'">Редактировать</a><br>';
echo '</div>';}} 

//////////////////////////////////////////////////// Конец навигации/////////////////////////////////////////////////////				
$posts = mysql_query("SELECT * FROM `posts` WHERE `theme` = '".$id."' ORDER BY `id` ASC LIMIT $start, ".$config['forumpost']."");
while ($post = mysql_fetch_array($posts)) { $n++;


echo '<div class="b"><table><tr><td width="32"> '.user_avatars($post['author']);

echo '</td><td width="100%">'.$n.'.';
						
$filename = ''.BASEDIR .'local/profil/'.$post['author'].'.prof';
if (file_exists($filename)) {
						
if ($post['author_n'] != NULL){echo '<a href="'.$config['home'].'/pages/anketa.php?uz='.$post['author'].'&amp;'.SID.'"><b>'.$post['author_n'].'</b></a>';
}else{echo '<a href="'.$config['home'].'/pages/anketa.php?uz='.$post['author'].'&amp;'.SID.'"><b>'.$post['author'].'</b></a>';}
						
} else {

if ($post['author_n'] != NULL){echo '<del><b>'.$post['author_n'].' </b></del>';
}else{echo '<del><b>'.$post['author'].' </b></del>';}
} 

echo '<small>('.date_fixed($post['time']).')</small><br>';

if ($config_strtsz) {echo strtsz($post['author']);}
echo user_online($post['author']).'<br>';

						
$ssim = SITETIME-60*10;						
if ($post['author'] != $log && $theme['status'] != "1") {
if (is_user()) {
echo '<a href="'.$config['home'].'/forum/?act=say&amp;id='.$post['id'].'&amp;'.SID.'">[отв]</a>';
echo '<a href="'.$config['home'].'/forum/?act=cyt&amp;id='.$post['id'].'&amp;'.SID.'">[цит]</a>';
echo '<a href="'.$config['home'].'/pages/privat.php?action=submit&uz='.$post['author'].'&amp;'.SID.'">[лс]</a>';}
}else if($post['author'] == $log  && $theme['status'] != "1" && $post['time'] > $ssim){
echo '<a href="'.$config['home'].'/forum/?act=edite&amp;id='.$post['id'].'&amp;'.SID.'">[Редактировать]</a>';} 
						
						
						
if (is_admin(array(101,102,103,105))) {
if (!empty($_SESSION['mufbc'])) {
echo '<a href="'.$config['home'].'/forum/?act=delpost&amp;id='.$post['id'].'&amp;'.SID.'">[DEL]</a>';
echo '<a href="'.$config['home'].'/forum/edit.php?id='.$post['id'].'&amp;'.SID.'">[EDIT]</a>';}

$checks = mysql_fetch_array(mysql_query("SELECT * FROM `moders` WHERE `login` = '".$log."' AND `under` = '".$under['id']."' "));
if (!empty($checks)) {echo '<a href="'.$config['home'].'/forum/?act=delpost&amp;id='.$post['id'].'&amp;'.SID.'">[DEL]</a>';}
}			
echo "</td></tr></table></div><div>\n";
				

////////////////////////////////////////////////// Конец///////////////////////////////////////////////////////	

if ($post['cyt'] != NULL) {
echo '<div style="margin:1px0px-5px4px;color:#878787;border-left:3px solid silver;border-bottom:1px solid silver;
"> <small>'.antimat(smiles(bb_code($post['cyt']))).'</small></div><br>';} 
					
if (strlen($post['msg']) > '1000') {
echo antimat(bb_code(smiles(utf_substr($post['msg'],0,500)))) . '<br>';
echo '<a href="'.$config['home'].'/forum/post.php?id='.$id.'&amp;pid='.$post['id'].'&amp;'.SID.'">Читать все >></a><br>';
}else{
echo antimat(bb_code(smiles($post['msg']))).'<br>';
} 


if ($post['file'] != NULL) {
if(file_exists('files/'.$post['file'].'')){
$ufile = 'files/'.$post['file'].'';
$ufilez = round(filesize($ufile) / 1024, 1);
echo '<br><img src="'.$config['home'].'/forum/img/d.gif" alt=""> ';
echo '<small><a href="'.$config['home'].'/forum/?act=down&amp;id='.$post['id'].'&amp;'.SID.'">'.$post['file'].'</a> ';
echo '['.$post['down'].'] ['.$ufilez.'kb]</small>';



	
}else{
echo '<br><small><img src="'.$config['home'].'/forum/img/err.gif" alt=""> <small>Файл удален!</small><br>';}} 


if ($post['edit'] != '0') {
echo '<small><img src="'.$config['home'].'/forum/img/e.gif" alt=""> Изм. ' . nickname($post['edit_author']) . ' (' . date_fixed($post['time']) . ') [' . $post['edit'] . ']</small><br>';} 

echo '<br><span style="color:#CC00CC; font-size: 9px;">('.$post['brow'].', '.$post['ip'].')</span></div>';
} 
				
				
echo '<br><hr><div>';

if (is_user()) {
if ($theme['status'] != '1') {

echo '<form action="'.$config['home'].'/forum/add.php?id='.$id.'" method="post">';
echo 'Сообщение: <br><textarea cols="25" rows="3" name="msg"></textarea><br>';
echo '<input name="file" type="checkbox" value="1"> Добавить файл<br>';
echo '<input type="submit" name="add" value="Написать"></form>';

}else{echo '<br> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Данная тема закрыта для обсуждения!<br><br>';} 

}else{
echo '<br>Вы не авторизованы, чтобы добавить сообщение необходимо<br>';
echo '<b><a href="'.$config['home'].'/pages/vhod.php?'.SID.'">Авторизоваться</a></b> или в начале ';
echo '<b><a href="'.$config['home'].'/pages/registration.php?'.SID.'">Зарегистрироваться</a></b><br><br>';
} 

echo '</div><div class="b"> Всего сообщений: '.$theme['posts'].' ';
if ($theme['files'] != '0') {echo '/ Вложений: '.$theme['files'].'';} 
				
echo '</div><div>';
if ($theme['posts'] >= $config['forumpost']) {
fnc_navig($start, $total, $config['forumpost'], ''.$config['home'].'/forum/?act=posts&amp;id='.$id.'');

echo '<form action="'.$config['home'].'/forum/go.php?id='.$id.'" method="post">';
echo '<input type="text" name="start" size="2">';
echo '<input type="submit" value="К странице &gt;&gt;"></form><hr>';} 

echo '<small><a href="#up">Вверх</a> | ';
echo '<a href="'.$config['home'].'/pages/smiles.php?'.SID.'">Смайлы</a> | ';
echo '<a href="'.$config['home'].'/pages/tegi.php?'.SID.'">Теги</a> | ';
echo '<a href="'.$config['home'].'/forum/?act=posts&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Обновить</a> | ';



echo '<a href="'.$config['home'].'/forum/?act=who&amp;id='.$id.'&amp;'.SID.'">Кто тут?('.mysql_result(mysql_query("SELECT COUNT(*) FROM `who` WHERE `theme`='".$id."'"), 0).')</a></small>';

if (is_admin(array(101,102,103,105))) {
if (!empty($_SESSION['mufbc'])) {echo '<div class="b"><a href="'.$config['home'].'/forum/index.php?m=2&amp;'.SID.'">Выход</a></div>';
} else {echo ' | <small><a href="'.$config['home'].'/forum/index.php?m=1&amp;'.SID.'">Адм</a></small>'; }}
echo '<br></div>';


}else{echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Такой темы не существует, возможно она была удалена модератором!<br><br></div>';} 
}else{echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Такой темы не существует, возможно она была удалена модератором!<br><br></div>';} 
break;
	
		
case('who'):
$id = (int)$_GET['id'];
if (isset($id)) {
$whs = mysql_query("SELECT * FROM `who` WHERE `under` = '".$id."' ");
$wh = mysql_fetch_array($whs);

if ($wh['under'] != NULL) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'"));
} else {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."'"));} 
            
if (!empty($check)) {
if ($wh['under'] != NULL) {
$unders = mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."' ");
$under = mysql_fetch_array($unders);
echo "<div class=b> Кто в разделе &quot;" . $under['name'] . ".&quot; </div><br>\n";
$whos = mysql_query("SELECT * FROM `who` WHERE `under` = '".$id."' ORDER BY `id` ASC");
} else {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);
echo "<div class=b> Кто в теме &quot;" . $theme['name'] . ".&quot; </div><br>\n";
$whos = mysql_query("SELECT * FROM `who` WHERE `theme` = '".$id."' ORDER BY `id` ASC");} 
               
echo '<div>';
if (mysql_num_rows($whos)) {
while ($who = mysql_fetch_array($whos)) {
echo "<a href='".$config['home']."/pages/anketa.php?uz=" . $who['user'] . "&'>".nickname($who['user'])."</a>, ";
}} else {echo "Тут никого нет!";} 
echo '</div>';
if ($wh['under'] != null) {
echo "<br><div class=b>Всего: (" . mysql_result(mysql_query("SELECT COUNT(*) FROM `who` WHERE `under`='".$id."'"), 0) . ") </div>\n";
} else {
echo "<br><div class=b>Всего: (" . mysql_result(mysql_query("SELECT COUNT(*) FROM `who` WHERE `theme`='".$id."'"), 0) . ") </div>\n";}
} else {echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''> Ошибка! Данного раздела не существует!<br>\n";} 
} else {echo "<br> <img src='".$config['home']."/images/img/close.gif' alt=''> Ошибка! Данного раздела не существует!<br>\n";} 
break;
		
		
case('where'):
if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}
      
$whs = mysql_query("SELECT * FROM `who` ORDER BY `time` DESC LIMIT $start, 10");
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `who`"), 0);

if ($start > $total) $start = 0;
if ($total < $start + 10) $end = $total;
else $end = $start + 10;

if (mysql_num_rows($whs)) {
while ($wh = mysql_fetch_array($whs)) {
echo '<div class="b"> <img src="'.$config['home'].'/images/img/chel.gif" alt=""> <a href="'.$config['home'].'/pages/anketa.php?uz='.$wh['user'].'&amp;'.SID.'">';
$date = file(BASEDIR . "local/profil/".$wh['user'].".prof");
$filename = "" . BASEDIR . "local/profil/".$wh['user'].".prof";

if (file_exists($filename)) {
$date = explode(":||:", $date[0]);
if ($date[65]) {echo "" . $date['65'] . "</a> ";
} else {echo "" . $wh['user'] . "</a> ";} 
} else { echo "" . $wh['user'] . "</a> ";} 

echo " " . user_online($wh['user']) . "</div>\n";
if ($wh['theme'] > '0') {
if ($wh['user'] != $log) {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '" . $wh['theme'] . "' ");
$thm = mysql_fetch_array($themes);
echo '<div>В теме: <a href="'.$config['home'].'/forum/?act=posts&amp;id='.$wh['theme'].'">'.$thm['name'].'</a></div>';
} else {echo '<div>Тут в списке!</div>';} 
} else { if ($wh['user'] != $log) {
$unders = mysql_query("SELECT * FROM `under` WHERE `id` = '" . $wh['under'] . "' ");
$under = mysql_fetch_array($unders);
echo '<div>В разделе: <a href="'.$config['home'].'/forum/?act=themes&amp;id='.$wh['under'].'">'.$under['name'].'</a></div>';
} else { echo "<div>Тут в списке!</div>\n";}}} 
} else {echo '<div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Никого нет на форуме!</div><br>';} 
if ($start != '0') {echo '<hr>'; fnc_navig($start, $total, 10, ''.$config['home'].'/forum/?act=where');} 
break;
		
		
case('status'):
$id = (int)$_GET['id'];
if (isset($id)) {
if (is_admin(array(101,102,103,105))) {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);
if ($theme['status']) {
mysql_query("UPDATE `theme` SET `status`='0' WHERE `id` = '".$id."'");
} else {
mysql_query("UPDATE `theme` SET `status`='1' WHERE `id` = '".$id."'");} 
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id.""); exit;}

if (is_user()){
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);

$check_mod = mysql_fetch_array(mysql_query("SELECT * FROM `moders` WHERE `login` = '".$log."' AND `under` = '".$theme['under']."'"));
if ($check_mod != 0) {
		

if ($theme['status']) {
mysql_query("UPDATE `theme` SET `status`='0' WHERE `id` = '".$id."'");
} else {
mysql_query("UPDATE `theme` SET `status`='1' WHERE `id` = '".$id."'");} 
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id.""); exit;
}
}
}

break;




case('sts'):
$id = (int)$_GET['id'];
if (is_user()) {
if (isset($id)) {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);
if ($theme['author'] == $log){
if ($theme['status'] == '0') {mysql_query("UPDATE `theme` SET `status`='1' WHERE `id` = '".$id."'");}
}else{header ("Location: ".$config['home']."/forum/?act=posts&id=".$id.""); exit;}
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id.""); exit;}} 
break;


case('locked'):
$id = (int)$_GET['id'];
if (is_admin(array(101,102,103,105))) {
if (isset($id)) {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."'");
$theme = mysql_fetch_array($themes);
if ($theme[locked] == '1') {
mysql_query("UPDATE `theme` SET `locked`='0' WHERE `id` = '".$id."'");
} else {
mysql_query("UPDATE `theme` SET `locked`='1' WHERE `id` = '".$id."'");} 
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$id."'"), 0);
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id.""); exit;}}
break;



case('del'):
$id = (int)$_GET['id'];
if (is_admin(array(101,102,103,105))) {
if (isset($id)) {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);
$unders = mysql_query("SELECT * FROM `under` WHERE `id` = '" . $theme['under'] . "'");
$under = mysql_fetch_array($unders);
$forums = mysql_query("SELECT * FROM `forums` WHERE `id` = '" . $under['forum'] . "'");
$forum = mysql_fetch_array($forums);
mysql_query("DELETE FROM `theme` WHERE `id` = '".$id."'");
mysql_query("DELETE FROM `posts` WHERE `theme` = '".$id."'");
mysql_query("DELETE FROM `vote` WHERE `theme` = '".$id."'");
mysql_query("DELETE FROM `voter` WHERE `theme` = '".$id."'");
mysql_query("DELETE FROM `itemvote` WHERE `theme` = '".$id."'");
mysql_query("DELETE FROM `bookmark` WHERE `theme` = '".$id."'");

$thms = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme`"), 0);
mysql_query("UPDATE `stat` SET `theme`='$thms'");
$udrs = mysql_result(mysql_query("SELECT COUNT(*) FROM `under`"), 0);
mysql_query("UPDATE `stat` SET `under`='$udrs'");
$psts = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts`"), 0);
mysql_query("UPDATE `stat` SET `post`='$psts'");
$frms = mysql_result(mysql_query("SELECT COUNT(*) FROM `forums`"), 0);
mysql_query("UPDATE `stat` SET `forum`='$frms'");
$udr = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `under` = '" . $under['id'] . "'"), 0);
mysql_query("UPDATE `under` SET `posts`='$udr+1' WHERE `id` = '" . $under['id'] . "'");
$frm = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `forums` = '" . $forum['id'] . "'"), 0);
mysql_query("UPDATE `forums` SET `posts`='$frm+1' WHERE `id` = '" . $forum['id'] . "'");
$thm = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `under` = '" . $under['id'] . "'"), 0);
mysql_query("UPDATE `under` SET `theme`='$thm+1' WHERE `id` = '" . $under['id'] . "'");
$thm2 = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `forums` = '" . $forum['id'] . "'"), 0);
mysql_query("UPDATE `forums` SET `theme`='$thm2+1' WHERE `id` = '" . $forum['id'] . "'");

$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['0'] = $frms;
$edata['1'] = $udrs;
$edata['2'] = $thms;
$edata['3'] = $psts;

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

header ("Location: ".$config['home']."/forum/?act=themes&id=".$theme['under'].""); exit;}}
break;
		


case('cyt'):
$id = (int)$_GET['id'];
if (isset($id)) { if (is_user()) {
$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'");
$post = mysql_fetch_array($posts);
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$post['theme']."' ");
$theme = mysql_fetch_array($themes);

if ($theme['status'] != '1') {
if ($post['author_n'] != NULL){

$post['msg'] = str_replace("<br />","\r\n",$post['msg']);

$cyt = "".$post['author_n']." (" . date_fixed($post['time']) . ") \n" . $post['msg'] . "";
}else{
$cyt = "".$post['author']." (" . date_fixed($post['time']) . ") \n" . $post['msg'] . "";}

echo '<div class="b">Тема: ' . $theme['name'] . '</div><div><br>';
echo '<form action="'.$config['home'].'/forum/add.php?id='.$theme['id'].'&amp;uz='.$post['author'].'" method="post">';
echo 'Цитата:<br><textarea cols="25" rows="3" name="cyt">'.$cyt.'</textarea><br>';
echo 'Допустимо макс. 200 символов. <br>Весь лишний текст обрезается.<hr><br>';

echo 'Сообщение:<br><textarea cols="25" rows="3" name="msg"></textarea><br>';
echo '<input name="priv" type="checkbox" value="1"> Оповестить по привату<br>';
echo '<input name="file" type="checkbox" value="1"> Добавить файл<br>';
echo '<input type="submit" name="add" value="Написать"></form></div>';
}else{echo '<br><img src="../images/img/close.gif" alt=""> Данная тема закрыта для обсуждения!<br><br>';}
}else{echo '<br><img src="../images/img/close.gif" alt=""> Данная тема закрыта для обсуждения!<br><br>';}}
break;
		
		

case('say'):
$id = (int)$_GET['id'];
if (isset($id)) {
if (is_user()) {

$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'");
$post = mysql_fetch_array($posts);
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$post['theme']."' ");
$theme = mysql_fetch_array($themes);
if ($theme['status'] != '1') {

if ($post['author_n'] != NULL){$autr = $post['author_n'];
}else{$autr = $post['author'];}

echo '<div class=b>Тема: '.$theme['name'].'</div><div><br>';
echo '<form action="'.$config['home'].'/forum/add.php?id='.$theme['id'].'&amp;uz='.$post['author'].'" method="post">';

echo 'Сообщение:<br><textarea cols="25" rows="3" name="msg">[b]'.$autr.'[/b], </textarea><br>';
echo '<input name="priv" type="checkbox" value="1"> Оповестить по привату<br>';
echo '<input name="file" type="checkbox" value="1"> Добавить файл<br>';
echo '<input type="submit" name="add" value="Написать"></form></div>';
}else{ echo '<br><img src="../images/img/close.gif" alt=""> Данная тема закрыта для обсуждения!<br><br>';}}} 
break;
		

case('edite'):
$id = (int)$_GET['id'];
if (isset($id)) {
if (is_user()) {

$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'");
$post = mysql_fetch_array($posts);
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$post['theme']."' ");
$theme = mysql_fetch_array($themes);

if ($post['author'] == $log) {
$ssim = SITETIME-60*10;
if ($post['time'] > $ssim) {

echo '<div class="b">Тема: '.$theme['name'].'</div>';
echo '<div>';

$post['msg'] = str_replace("<br />","\r\n",$post['msg']);

echo '<form action="'.$config['home'].'/forum/?act=edites&id='.$id.'" method="post">';
echo 'Сообщение:<br><textarea cols="25" rows="3" name="msg">'.$post['msg'].'</textarea><br>';
echo '<input type="submit" name="add" value="Изменить"></form></div>';

} else {echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Время для изменения сообщения вышло!</div><br>';} 
} else {echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Вы не автор данного сообщения!</div><br>';} 
} else {echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> Данная тема закрыта для обсуждения!</div><br>';}}
break;
		
		

case('edites'):
$id = (int)$_GET['id'];
if (isset($id)) {
if ($_POST['msg']) {
if (is_user()) {

$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'");
$post = mysql_fetch_array($posts);
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$post['theme']."' ");
$theme = mysql_fetch_array($themes);

if ($post[author] == $log) {
$ssim = SITETIME-60*10;
if ($post['time'] > $ssim) {

$msg = check($_POST['msg']);
$msg = no_br($msg,'<br />');

mysql_query("UPDATE `posts` SET `msg`='$msg' WHERE `id` = '".$id."'");
mysql_query("UPDATE `posts` SET `edit`=edit+1 WHERE `id` = '".$id."'");
mysql_query("UPDATE `posts` SET `edit_time`='".SITETIME."' WHERE `id` = '".$id."'");
mysql_query("UPDATE `posts` SET `edit_author`='$log' WHERE `id` = '".$id."'");
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$theme['id']."'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];



header ("Location: ".$config['home']."/forum/?act=posts&id=".$theme['id']."&start=".$start."".SID); exit;
									
} else {echo '<br> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Время для изменения сообщения вышло!<br>';} 
} else { echo '<br> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Ошибка! Вы не автор данного сообщения!<br>';}}
}
}
break;
		

case('afile'):
$id = (int)$_GET['id'];
if (isset($id)) {
if (is_user()) {
$themes = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."' ");
$theme = mysql_fetch_array($themes);
$posts = mysql_query("SELECT * FROM `posts` WHERE `theme` = '".$id."' AND `author` = '$log' ORDER BY `time` DESC LIMIT 1");
$post = mysql_fetch_array($posts);
echo '<div class="b">Тема: '.$theme['name'].'</div>';
if ($post['fil'] != '1'){
echo '<div>';
echo '<form action="'.$config['home'].'/forum/?act=load&amp;id='.$id.'" method="POST" enctype="multipart/form-data"><br>';
echo 'Файл:<br> <input type="file" name="t_item"> <br>';
echo '<input type="submit" name="file" value="Добавить"></form>';
echo 'Макс. размер: 2000kb<br>';
echo '</div>';
}else{echo '<br><div><img src="'.$config['home'].'/images/img/close.gif" alt=""> К данному посту уже прикреплен файл!</div><br>';}}} 
break;
		
		

case('load'):
$id = (int)$_GET['id'];
if (is_user()) {
if (isset($id)) {
$posts = mysql_query("SELECT * FROM `posts` WHERE `theme` = '".$id."' AND `author` = '$log' ORDER BY `time` DESC LIMIT 1");
$post = mysql_fetch_array($posts);
if ($post['fil'] != '1'){

if (is_uploaded_file($_FILES['t_item']['tmp_name'])){

/* 
if ($conf_forum_files == '1') {old('files', $conf_forum_files_time);}  
*/

$rand_file = rand(1000, 99999999);
$file_format = $_FILES['t_item']['name'];
$ext = strtolower(substr($file_format, 1 + strrpos($file_format, ".")));
$ext2 = array("asp", "aspx", "shtml", "htd", "php", "php3", "php4", "php5", "phtml", "htt", "cfm", "tpl", "dtd", "hta", "pl", "js", "jsp", "rtf","htaccess");
if (in_array($ext, $ext2)) {
echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Запрещенный тип файла!</div><br>';
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$post['theme']."'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
echo '<div><hr>: <a href="'.$config['home'].'/forum/?act=posts&amp;id='.$post['theme'].'/'.$start.'">В тему</a><br>';
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a></div>';
include_once ("../themes/".$config['themes']."/foot.php");
exit;} 

if ($_FILES["filename"]["size"] < 1024 * 2 * 1024) {
$file_light_name = "$rand_file.$ext";
$upfiledir = "files/";
$upfile = $upfiledir . basename($file_light_name);
if (move_uploaded_file($_FILES['t_item']['tmp_name'], $upfile)) {
$flsbl = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme`='".$post['theme']."' AND `fil`='1'"), 0)+1;						
						
mysql_query("UPDATE `theme` SET `files`='".$flsbl."' WHERE `id` = '".$post['theme']."'");
mysql_query("UPDATE `posts` SET `file`='$rand_file.$ext' WHERE `id` = '".$post['id']."'");
mysql_query("UPDATE `posts` SET `fil`='1' WHERE `id` = '".$post['id']."'");
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$id."'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id."&start=".$start."".SID); exit;}
}else{echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> Слишком большой файл!</div><br>';}} 
}else{echo '<br><div> <img src="'.$config['home'].'/images/img/close.gif" alt=""> К данному посту уже прикреплен файл!</div><br>';}
} 
}break;
		
		
case('search'): 
echo '<div class="b"> Поиск по форуму </div><div>';
echo '<form action="'.$config['home'].'/forum/search.php?start=0&amp;'.SID.'" method="post">';
echo 'Что ищем:<br> <input type="text" name="chto" maxlength="32"><br>';

echo 'Где ищем:<br> <select name="who">';
echo '<option value="0" selected="selected">Не имеет значения</option>';

$frms = mysql_query("SELECT * FROM `forums` ORDER BY `position`");
while ($frm = mysql_fetch_array($frms)) {
echo '<option value="f_'.$frm['id'].'">--'.$frm['name'].'</option>';
$und = mysql_query("SELECT * FROM `under` WHERE `forum` = '".$frm['id']."' ORDER BY `position`");
while ($un = mysql_fetch_array($und)) { 
echo '<option value="u_'.$un['id'].'">'.$un['name'].'</option>';}} 
echo '</select><br>';

echo '<input name="wh" type="radio" value="0" checked="checked"> В темах <br>';
echo '<input name="wh" type="radio" value="1"> В сообщениях <br>';


echo '<input type="submit" value="Искать">';
echo '</form></div>';
break;

case('down'):
$id = (int)$_GET['id'];
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'"));
if (!empty($check)) {
$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'");
$post = mysql_fetch_array($posts);
mysql_query("UPDATE `posts` SET `down`=down+1 WHERE `id` = '".$id."'");
header ("Location: ".$config['home']."/forum/files/".$post['file'].""); exit;}} 
break;




case('delfm'):
if (is_admin(array(101,102))) {
$id = (int)$_GET['id'];
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'"));
if (!empty($check)) {
mysql_query("DELETE FROM `forums` WHERE `id`='".$id."'");
mysql_query("DELETE FROM `under` WHERE `forum`='".$id."'");
mysql_query("DELETE FROM `theme` WHERE `forums`='".$id."'");
mysql_query("DELETE FROM `posts` WHERE `forums`='".$id."'");
mysql_query("DELETE FROM `vote` WHERE `forum` = '".$id."'");
mysql_query("DELETE FROM `voter` WHERE `forum` = '".$id."'");
mysql_query("DELETE FROM `itemvote` WHERE `forum` = '".$id."'");

$f = mysql_result(mysql_query("SELECT COUNT(*) FROM `forums`"), 0);
mysql_query("UPDATE `stat` SET `forum`='".$f."'");
$u = mysql_result(mysql_query("SELECT COUNT(*) FROM `under`"), 0);
mysql_query("UPDATE `stat` SET `under`='".$u."'");
$t = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme`"), 0);
mysql_query("UPDATE `stat` SET `theme`='".$t."'");
$p = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts`"), 0);
mysql_query("UPDATE `stat` SET `post`='".$p."'");
$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['0'] = $f;
$edata['1'] = $u;
$edata['2'] = $t;
$edata['3'] = $p;

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
header ("Location: index.php?".SID);  exit;} 
} } 
break;


case('dowfm'):
if (is_admin(array(101,102))) {
$id = (int)$_GET['id'];
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'"));
if (!empty($check)) {
$req = mysql_query("SELECT `position` FROM `forums` WHERE `id` = '".$id."'");
if (mysql_num_rows($req) > 0) {
$res = mysql_fetch_array($req);
$position = $res['position'];
$req = mysql_query("SELECT * FROM `forums` WHERE `position` > '".$position."' ORDER BY `position` ASC");
if (mysql_num_rows($req) > 0) {
$res = mysql_fetch_array($req);
$id2 = $res['id'];
$position2 = $res['position'];
mysql_query("UPDATE `forums` SET `position` = '".$position2."' WHERE `id` = '".$id."'");
mysql_query("UPDATE `forums` SET `position` = '".$position."' WHERE `id` = '".$id2."'");}} 
header ("Location: index.php?".SID);  exit;}}}
break;


case('upfm'):
if (is_admin(array(101,102))) {
$id = (int)$_GET['id'];
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'"));
if (!empty($check)) {
$req = mysql_query("SELECT `position` FROM `forums` WHERE `id` = '".$id."'");
if (mysql_num_rows($req) > 0) {
$res = mysql_fetch_array($req);
$position = $res['position'];
$req = mysql_query("SELECT * FROM `forums` WHERE `position` < '$position' ORDER BY `position` DESC");
if (mysql_num_rows($req) >= 0) {
$res = mysql_fetch_array($req);
$id2 = $res['id'];
$position2 = $res['position'];
mysql_query("UPDATE `forums` SET `position` = '" . $position2 . "' WHERE `id` = '" . $id . "'");
mysql_query("UPDATE `forums` SET `position` = '" . $position . "' WHERE `id` = '" . $id2 . "'");}} 
header ("Location: index.php?".SID);  exit;}}} 
break;


case('delund'):
if (is_admin(array(101,102))) {
$id = (int)$_GET['id'];
if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'"));
if (!empty($check)) {
$req = mysql_query("SELECT * FROM `under` WHERE `id` = '".$id."'");
$res = mysql_fetch_array($req);

mysql_query("DELETE FROM `under` WHERE `id`='".$id."'");
mysql_query("DELETE FROM `theme` WHERE `under`='".$id."'");
mysql_query("DELETE FROM `posts` WHERE `under`='".$id."'");

mysql_query("DELETE FROM `vote` WHERE `under` = '".$id."'");
mysql_query("DELETE FROM `voter` WHERE `under` = '".$id."'");
mysql_query("DELETE FROM `itemvote` WHERE `under` = '".$id."'");

$f = mysql_result(mysql_query("SELECT COUNT(*) FROM `forums`"), 0);
$u = mysql_result(mysql_query("SELECT COUNT(*) FROM `under`"), 0);
$t = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme`"), 0);
$p = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts`"), 0);

mysql_query("UPDATE `forums` SET `under` = '0' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `theme` = '0' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `posts` = '0' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `last_theme` = '0' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `last_theme_name` = '' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `last_time` = '0' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `last_posts` = '0' WHERE `id` = '".$res['forum']."'");
mysql_query("UPDATE `forums` SET `last_login` = '' WHERE `id` = '".$res['forum']."'");


$etext = '';
$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['0'] = $f;
$edata['1'] = $u;
$edata['2'] = $t;
$edata['3'] = $p;

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
header ("Location: index.php?".SID); exit;}}}
break;



case('delpost'):
$id = (int)$_GET['id'];
if (is_admin(array(101,102,103,105))) {

$psts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."' ");
$pst = mysql_fetch_array($psts);
$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$pst['theme']."' ");
$thm = mysql_fetch_array($thms);
$p = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts`"), 0);

mysql_query("DELETE FROM `posts` WHERE `id`='".$pst['id']."'");
mysql_query("UPDATE `theme` SET `posts`=posts-1 WHERE `id` = '".$thm['id']."'");
mysql_query("UPDATE `under` SET `posts`=posts-1 WHERE `id` = '".$thm['under']."'");
mysql_query("UPDATE `forums` SET `posts`=posts-1 WHERE `id` = '".$thm['forums']."'");
mysql_query("UPDATE `forums` SET `last_posts`=last_posts-1 WHERE `id` = '".$thm['forums']."'");
mysql_query("UPDATE `stat` SET `post`=post-1");
mysql_query("UPDATE `stat` SET `posts`='".$p."'");

$etext= '';			
$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['3'] = $p;
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
header ("Location: index.php?act=posts&id=".$pst['theme']."".SID); exit;
} else{
$psts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."' ");
$pst = mysql_fetch_array($psts);
$checks = mysql_fetch_array(mysql_query("SELECT * FROM `moders` WHERE `login` = '".$log."' AND `under` = '".$pst['under']."' "));
if (!empty($checks)) {			
$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$pst['theme']."' ");
$thm = mysql_fetch_array($thms);
$p = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts`"), 0);
mysql_query("DELETE FROM `posts` WHERE `id`='".$pst['id']."'");
mysql_query("UPDATE `theme` SET `posts`=posts-1 WHERE `id` = '".$thm['id']."'");
mysql_query("UPDATE `under` SET `posts`=posts-1 WHERE `id` = '".$thm['under']."'");
mysql_query("UPDATE `forums` SET `posts`=posts-1 WHERE `id` = '".$thm['forums']."'");
mysql_query("UPDATE `forums` SET `last_posts`=last_posts-1 WHERE `id` = '".$thm['forums']."'");
mysql_query("UPDATE `stat` SET `post`=post-1");
mysql_query("UPDATE `stat` SET `posts`='".$p."'");

$etext = '';			
$efile = file(BASEDIR . "local/forum.dat");
$edata = explode(":||:", $efile['0']);
$edata['3'] = $p;
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
header ("Location: index.php?act=posts&id=".$pst['theme']."".SID); exit;}}
break;
		
} 

echo '<div><hr>';
if ($act == 'say' || $act == 'cyt' || $act == 'edite' || $act == 'afile'){
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '" . (int)$_GET['id'] . "'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
echo ': <a href="'.$config['home'].'/forum/?act=posts&id='.$post['theme'].'&amp;start='.$start.'&amp;'.SID.'">В тему</a><br>';}

if ($act == 'load'){
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$post['theme']."'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
echo ': <a href="'.$config['home'].'/forum/?act=posts&id='.$post['theme'].'&amp;start='.$start.'&amp;'.SID.'">В тему</a><br>';}
 

 
 
if ($act == 'theme') {
echo ': <a href="'.$config['home'].'/forum/?act=themes&amp;id='.(int)$_GET['id'].'">Назад</a><br>';} 
if ($act) {echo ':: <a href="'.$config['home'].'/forum/?'.SID.'">В форум</a><br>';} 
echo '::: <a href="'.$config['home'].'/?'.SID.'">На главную</a></div>';

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>