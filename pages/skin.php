<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#	
require_once "../includes/start.php";
require_once "../includes/functions.php";
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){
if (isset($_GET['skins'])) {$skins = check($_GET['skins']);} elseif (isset($_POST['skins'])) {$skins = check($_POST['skins']);} else {$skins = "";}

if (preg_match('|^[a-z0-9_\-]+$|i', $skins)){
if (file_exists(BASEDIR."themes/$skins/index.php")){

$_SESSION['my_themes'] = "";
unset($_SESSION['my_themes']);
$_SESSION['my_themes'] = $skins;

}}
header ("Location: ".BASEDIR."index.php?".SID); exit;
}

############################################################################################
##                                    Переход по навигации                                ##
############################################################################################
if ($action=="navigation"){
if (isset($_POST['link'])) {$link = check($_POST['link']);} else {$link = "index.php";}

header ("Location: ".BASEDIR.verifi($link)); exit;
}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>
