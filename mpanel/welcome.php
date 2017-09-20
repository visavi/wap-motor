<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#              Made by  :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102))){

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Приветствие</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo 'Приветствие:<br />';

echo '<form method="post" action="welcome.php?action=edit&amp;uid='.$_SESSION['token'].'">';
echo '<textarea name="msg" cols="35" rows="5">'.file_get_contents(DATADIR."welcome.dat").'</textarea><br />';
echo '<input value="Редактировать" type="submit" /></form><hr />';
}

############################################################################################
##                                     Редактирование                                     ##
############################################################################################
if ($action=="edit"){

$uid = check($_GET['uid']);
$msg = check($_POST['msg']);

if ($uid==$_SESSION['token']){
if ($msg!=""){

write_files(DATADIR."welcome.dat", $msg, 1);

echo '<b>Приветствие успешно отредактировано!</b><br />';

} else {echo '<b>Ошибка! Вы не написали текст приветствия!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="welcome.php">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
