<?php
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

$id = (int)$_GET['id'];
if (isset($id)){
$check = mysql_fetch_array(mysql_query("SELECT * FROM `theme` WHERE `id` = '".$id."'"));
if (!empty($check)){
$start = (int)$_POST['start'];
if ($start){

$filek = mysql_result(mysql_query("SELECT COUNT(*) FROM `posts` WHERE `theme` = '".$id."'"),0);
$start2 = floor($filek/$config['forumpost'])*$config['forumpost'];
$start3 = floor($start-1)*$config['forumpost'];
if ($start3 <= $start2){
header ("Location: ".$config['home']."/forum/?act=posts&id=".$id."&start=".$start3.""); exit;
}else{header ("Location: ".$config['home']."/forum/?act=posts&id=".$id."&start=0"); exit;}}}}

include_once ("../themes/".$config['themes']."/foot.php");
?>