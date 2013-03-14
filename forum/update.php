<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

$themes = mysql_query("SELECT * FROM `theme` WHERE `author` = '$log' ORDER BY `id` DESC");
$theme = mysql_fetch_array($themes);

$act = isset($_GET['act']) ? check($_GET['act']) : '';
switch($act){
default:
$id = (int)$_GET['id'];
$psts = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `forums` = '$id'"),0);
mysql_query("UPDATE `forums` SET `posts`='$psts' WHERE `id` = '$id'");
$thms = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `forums` = '$id'"),0);
mysql_query("UPDATE `forums` SET `theme`='$thms' WHERE `id` = '$id'");
$udrs = mysql_result(mysql_query("SELECT COUNT(*) FROM `under` WHERE `forum` = '$id'"),0);
mysql_query("UPDATE `forums` SET `under`='$udrs' WHERE `id` = '$id'");
header ("Location: index.php?".SID);  exit;
break;

case('under'):
$id = (int)$_GET['id'];
$pst = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `under`='$id'"),0);
$thm = mysql_result(mysql_query("SELECT COUNT(*) FROM `theme` WHERE `under` = '$id'"),0);
mysql_query("UPDATE `under` SET `posts`='$pst' WHERE `id` = '$id'");
mysql_query("UPDATE `under` SET `theme`='$thm' WHERE `id` = '$id'");
header ("Location: index.php?".SID);  exit;
break;}

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>