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
require_once ('../includes/start.php');
require_once ('../includes/functions.php');
require_once ('../includes/header.php');
include_once ('../themes/'.$config['themes'].'/index.php');

if (isset($_GET['name'])){$name = '[b]'.safe_decode(check($_GET['name'])).'[/b], ';} else {$name = "";}

show_title('menu.gif', 'Добавление сообщения');

if (is_user()){

echo'<form action="go.php?'.SID.'" name="form" method="post">';

echo'Ваш ICQ:<br />';
echo'<input type="text" name="icq" value="'.$udata[19].'" maxlength="9" /><br />';

echo 'Cообщение:<br />';
echo '<textarea cols="25" rows="4" name="msg">'.$name.'</textarea><br />';

quickpaste('msg');
quicksmiles();

echo '<input type="submit" value="Добавить" /></form><hr />';

echo '<font color="#ff0000">ВНИМАНИЕ!</font><br />';
echo 'Реклама на сайте запрещена! Все добавленные сообщения строго проверяется администрацией, при нарушении этих правил последует БАН!<br />';

echo 'Не нажимайте кнопку "Добавить" больше одного раза!<br />';
echo 'В тексте запрещено использовать любые ненормальные и матерные слова.<br /><br />';


} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>