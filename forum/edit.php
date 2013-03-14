<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (is_admin(array(101,102,103,105))){
$id = (int)$_GET['id'];

if (isset($id)) {
$check = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'"));
if (!empty($check)) {
//////////////////////////////////////////////////// Выводим данные //////////////////////////////////////////////////////
$posts = mysql_query("SELECT * FROM `posts` WHERE `id` = '".$id."'");
$post = mysql_fetch_array($posts);
$thms = mysql_query("SELECT * FROM `theme` WHERE `id` = '".$post['theme']."'");
$thm = mysql_fetch_array($thms);
//////////////////////////////////////////////////// Записываем данные ///////////////////////////////////////////////////
if (isset($_POST['msg'])) {
$msg = check($_POST['msg']);
$msg = no_br($msg,'<br />');

mysql_query("UPDATE `posts` SET `msg`='".$msg."' WHERE `id` = '$id'");
mysql_query("UPDATE `posts` SET `edit`=edit+1 WHERE `id` = '$id'");
mysql_query("UPDATE `posts` SET `edit_time`='".$sitetime."' WHERE `id` = '$id'");
mysql_query("UPDATE `posts` SET `edit_author`='".$log."' WHERE `id` = '$id'");
//////////////////////////////////////////////////// Перенаправляем в тему ///////////////////////////////////////////////
$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '$id'"), 0);
if ($filek != '0') {$filek = $filek-1;} 
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
header ("Location: ".$config['home']."/forum/?act=posts&id=".$thm['id']."&start=".$start."");exit;} 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<div class="b">Тема: '.$thm['name'].'</div>';
$post['msg'] = str_replace("<br />","\r\n",$post['msg']);

echo "<div class=form>\n";
echo "<form action='".$config['home']."/forum/edit.php?id=".$id."' method='post'>\n";
echo "Сообщение:<br><textarea cols='25' rows='3' name='msg'>" . $post['msg'] . "</textarea><br>\n";
echo "<input type='submit' name='add' value='Изменить'></form>\n</div>\n";
echo "<div>\n";

$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '" . $id . "'"), 0);
if ($filek != '0') { $filek = $filek-1;}
$start = floor($filek / $config['forumpost']) * $config['forumpost'];
echo ": <a href='".$config['home']."/forum/?act=posts&amp;id=".$thm['id']."&amp;start=".$start."'>В тему</a><br>";
echo ":: <a href='index.php?" . SID . "'>В форум</a><br>";
echo "::: <a href='../index.php?" . SID . "'>На главную</a>";
echo "</div>\n";
} else {echo "<br> <img src='../images/img/close.gif' alt=''> Ошибка! Такого сообщения не существует!<br>\n";}} 
} else {header ("Location: ../index.php?isset=404&".SID);} 


echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>