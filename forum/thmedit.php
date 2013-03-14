<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (is_admin(array(101,102,103,105))){

$id = (int)$_GET['id'];
if ($id) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `theme` WHERE `id` = '$id'"));
if (!empty($check)) {


if (isset($_POST['edits'])) {
$theme = check($_POST['theme']);
$description = check($_POST['description']);

if (!isset($theme {3})) {header ("Location: thmedit.php?id=".$id."&isset=stheme"); exit;} 
if (strlen($theme) > 50) {header ("Location: thmedit.php?id=".$id."&isset=btheme"); exit;} 
mysql_query("UPDATE `theme` SET `name`='".$theme."' WHERE `id` = '".$id."'");
mysql_query("UPDATE `theme` SET `description`='".$description."' WHERE `id` = '".$id."'");
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id."&start=".strts($id,$config['forumpost']).""); exit;
} 

$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '$id' ");
$thm = mysql_fetch_array($thms);
echo '<div class="b">Управление темой:</div><div>';
echo "<form action='".$config['home']."/forum/thmedit.php?id=".$id."' method='post'>\n";
echo "Название:<br><input type='text' name='theme' maxlength='50' value='" . $thm['name'] . "'><br>\n";
echo "Описание:<br><input type='text' name='description' maxlength='100' value='" . $thm['description'] . "'><br>\n";
echo "<input type='submit' name='edits' value='Отправить'></form></div>";
						
						
						
 

}}}

echo '<hr><div>';
echo ': <a href="'.$config['home'].'/forum/?act=posts&amp;id='.$id.'&amp;start='.strts($id,$config['forumpost']).'">В тему</a><br>'; 
echo ':: <a href="'.$config['home'].'/forum/">В форум</a><br>';
echo '::: <a href="'.$config['home'].'/">На главную</a><br>';
echo '</div>';

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>