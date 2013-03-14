<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

if (is_admin(array(101,102))){
$act = isset($_GET['act']) ? check($_GET['act']) : '';
switch($act){
default:

break;

case('undown'):
$id = (int)$_GET['id'];
if($id){
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '$id'"));
if($check!=0){
$frms = mysql_query("SELECT * FROM `under` WHERE `id` = '$id'");
$frm = mysql_fetch_array($frms);

$req = mysql_query("SELECT `position` FROM `under` WHERE `id` = '$id' AND `forum` = '".$frm['forum']."'");
if (mysql_num_rows($req) > 0){
$res = mysql_fetch_array($req);
$position = $res['position'];
$req = mysql_query("SELECT * FROM `under` WHERE `position` < '$position' AND `forum` = '".$frm['forum']."' ORDER BY `position` DESC");
if (mysql_num_rows($req) > 0){
$res = mysql_fetch_array($req);
$id2 = $res['id'];
$position2 = $res['position'];
mysql_query("UPDATE `under` SET `position` = '".$position2."' WHERE `id` = '".$id."'  AND `forum` = '".$frm['forum']."'");
mysql_query("UPDATE `under` SET `position` = '".$position."' WHERE `id` = '".$id2."'  AND `forum` = '".$frm['forum']."'");}}
header ("Location: index.php?".SID);  exit;
}}
break;


case('unup'):
$id = (int)$_GET['id'];
if($id){
$unds = mysql_query("SELECT * FROM `under` WHERE `id` = '$id'");
$und = mysql_fetch_array($unds);
$check = mysql_fetch_array(mysql_query("SELECT * FROM `under` WHERE `id` = '$id'"));
if($check!=0){
$frms = mysql_query("SELECT * FROM `under` WHERE `id` = '$id'");
$frm = mysql_fetch_array($frms);

$req = mysql_query("SELECT `position` FROM `under` WHERE `id` = '$id' AND `forum` = '".$frm['forum']."'");
if (mysql_num_rows($req) > 0){
$res = mysql_fetch_array($req);
$position = $res['position'];
$req = mysql_query("SELECT * FROM `under` WHERE `position` > '$position' AND `forum` = '".$frm['forum']."' ORDER BY `position` ASC");
if (mysql_num_rows($req) > 0){
$res = mysql_fetch_array($req);
$id2 = $res['id'];
$position2 = $res['position'];
mysql_query("UPDATE `under` SET `position` = '".$position2."' WHERE `id` = '".$id."' AND `forum` = '".$frm['forum']."'");
mysql_query("UPDATE `under` SET `position` = '".$position."' WHERE `id` = '".$id2."' AND `forum` = '".$frm['forum']."'");}}
header ("Location: index.php?".SID);  exit;
}}
break;


}
} else {header ("Location: ../index.php?isset=404&".SID);}

echo '<a href="http://7je.ru">ByForum 1.5 DEMO</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>