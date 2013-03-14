<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (is_admin(array(101,102))){

$id = (int)$_GET['id'];
if ($id){
$check = mysql_fetch_array(mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'"));
if (!empty($check)) {
$i=0;


if (@$_POST['assign']!=NULL && @$_POST['und_id']!= NULL && @$_POST['login']!= NULL){
$und_id = (int)$_POST['und_id'];
$login = check($_POST['login']);
$checks2 = mysql_fetch_array(mysql_query("SELECT * FROM `moders` WHERE `under` = '".$und_id."' AND `login` = '".$login."'"));
if (empty($checks2)) {
if(file_exists("../local/profil/".$login.".prof")){
$date = file(BASEDIR . "local/profil/".$login.".prof");
$date = explode(":||:", $date[0]);
if ($date['7'] == '107') {
mysql_query ("INSERT INTO `moders` (under,login) VALUES ('".$und_id."','".$login."')");
header ("Location: moders.php?id=".$id."&isset=yes"); exit;
}else{ header ("Location: moders.php?id=".$id."&isset=moder"); exit;}
}else{ header ("Location: moders.php?id=".$id."&isset=nouser"); exit;}
}else{ header ("Location: moders.php?id=".$id."&isset=yet"); exit;}}

if (isset($_GET['del']) && $_GET['del']=='1'){
$delid = (int)$_GET['delid'];
mysql_query("DELETE FROM `moders` WHERE `id`='".$delid."'");
header ("Location: moders.php?id=".$id."&isset=delmoder"); exit;
}

$frms = mysql_query("SELECT * FROM `forums` WHERE `id` = '".$id."'");
$frm = mysql_fetch_array($frms);
echo '<div class="b"> '.$frm['name'].'</div><div><br>';
if (isset ($_GET['isset'])) {$isset = check($_GET['isset']);} else {$isset = '';}
if ($isset == "nouser") {echo "<div align=center><font color=red><b>Такого юзера не существует!</b></font></div><br>\n";} 
if ($isset == "yes") {echo "<div align=center><font color=red><b>Управляющий успешно добавлен!</b></font></div><br>\n";} 
if ($isset == "yet") {echo "<div align=center><font color=red><b>Юзер уже управляет этим разделом!</b></font></div><br>\n";}
if ($isset == "moder") {echo "<div align=center><font color=red><b>Юзер и так модератор, зачем ему столько званий?</b></font></div><br>\n";} 
if ($isset == "delmoder") {echo "<div align=center><font color=red><b>Управляющий успешно удален!</b></font></div><br>\n";} 
 
echo '<form action="moders.php?id='.$id.'" method="post">';
echo 'Подфорум: <br><select name="und_id">';
$under = mysql_query("SELECT * FROM `under` WHERE `forum` = '".$id."' ORDER BY `position` DESC");
while ($unr = mysql_fetch_array($under)) {
$i++;
if($i == '0'){echo '<option value="'.$unr['id'].'" selected="selected">'.$unr['name'].'</option>';}
else{ echo '<option value="'.$unr['id'].'">'.$unr['name'].'</option>';}}

echo '</select><br>';
echo 'Логин:<br><input type="text" name="login" maxlength="50"><br>';
echo '<input type="submit" name="assign" value="Назначить"></form>';
echo '</div>';

$unds = mysql_query("SELECT * FROM `under` ORDER BY `forum` ");
while ($und = mysql_fetch_array($unds)) {
echo '<div class="b"><img src="img/ts.gif" alt=""> '.$und['name'].' </div>';
$mdes = mysql_query("SELECT * FROM `moders` WHERE `under` = '".$und['id']."' ORDER BY `id`");
if (mysql_num_rows($mdes)) {
while ($mde = mysql_fetch_array($mdes)) {
echo ' <div><img src="../images/img/chel.gif" alt=""> '.$mde['login'].' |'; 
echo ' <a href="moders.php?id='.$id.'&del=1&delid='.$mde['id'].'"> <b>Убрать</b></a></div>';}
}else{ echo '<div><img src="../images/img/close.gif" alt=""> Нет управляющих!</div>';}}

echo '<hr><div>';
echo ':: <a href="index.php">В форум</a><br>';
echo '::: <a href="../index.php">На главную</a></div>';
}}


} else {header ("Location: ../index.php?isset=404&".SID);}

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>