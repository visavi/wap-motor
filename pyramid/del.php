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
require_once ("conf.php");


if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

show_title('menu.gif', 'Удаление сообщений');

if (is_admin(array(101,102,103,105))){

if ($action == ""){


if (isset($_GET['id'])) {$id = intval($_GET['id']);} else {$id = "";}

if ($id!==""){

delete_lines("msg.dat", $id);

header ("Location: ../index.php?isset=selectpriv");

} else {show_error('Ошибка удаления! Отсутствуют выбранные сообщения!');}
}



#####################################
if ($action=="all"){
clear_files("msg.dat");
header ("Location: ../index.php?isset=selectpriv"); exit;
}
} else {show_error('Ошибка! Данная страница доступна только администрации!');}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
