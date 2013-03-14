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

if (!is_user() && $action=='menu'){header ('Location: '.BASEDIR.'index.php?'.SID); exit;}
if ($action=='index'){header ('Location: '.BASEDIR.'index.php?'.SID); exit;}

if (preg_match('|^[a-z0-9_\-]+$|i', $action)){
if (file_exists(DATADIR.'datamain/'.$action.'.dat')){

include DATADIR.'datamain/'.$action.'.dat';

} else { echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, такой страницы не существует!</b><br />'; }
} else { echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, недопустимое название страницы!</b><br />'; }

echo '<br /><img src="'.BASEDIR.'images/img/act_home.gif" alt="image" /> <a href="'.BASEDIR.'index.php?'.SID.'">На главную</a>';

include_once "../themes/".$config['themes']."/foot.php";
?>