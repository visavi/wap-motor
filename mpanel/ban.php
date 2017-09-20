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

$config['ipbanlist'] = 10;

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>IP-бан панель</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$file = file(DATADIR."ban.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

echo '<form action="ban.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['ipbanlist']){ $end = $total; }
else {$end = $start + $config['ipbanlist']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

echo '<div class="b">';
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<img src="../images/img/files.gif" alt="image" /> <b>'.$data[1].'</b></div>';

echo '<div>Добавлен: ';

if (empty($data[3])){
echo '<b>Автоматически</b><br />';
} else {
echo '<b><a href="../pages/anketa.php?uz='.$data[3].'">'.nickname($data[3]).'</a></b><br />';
}

echo 'Время: '.date_fixed($data[2]).'</div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('ban.php?', $config['ipbanlist'], $start, $total);
page_strnavigation('ban.php?', $config['ipbanlist'], $start, $total);

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Список чист!</b>';}

echo '<br /><br />Всего заблокировано: <b>'.(int)$total.'</b>';

echo '<hr /><form method="post" action="ban.php?action=add&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'">';
echo 'IP-адрес:<br />';
echo '<input name="ips" /> <input value="Добавить" type="submit" /></form><hr />';

echo 'Примеры банов: 127.0.0.1 без отступов и пробелов<br />';
echo 'Или по маске 127.0.0.* , 127.0.*.* , будут забанены все IP совпадающие по начальным цифрам<br /><br />';

if ($total>1){echo'<img src="../images/img/error.gif" alt="image" /> <a href="ban.php?action=clear&amp;uid='.$_SESSION['token'].'">Очистить список</a><br />';}
echo '<img src="../images/img/arhiv.gif" alt="image" /> <a href="logfiles.php?list=ban">Смотреть логи</a>';
}

############################################################################################
##                                   Занесение в список                                   ##
############################################################################################
if ($action=="add"){

$uid = check($_GET['uid']);
$ips = check($_POST['ips']);

if ($uid==$_SESSION['token']){
if ($ips!=""){

$string = search_string(DATADIR."ban.dat", $ips, 1);
if(empty($string)){

write_files(DATADIR."ban.dat", '|'.$ips.'|'.SITETIME.'|'.$log."|\r\n");

header ("Location: ban.php?start=$start&isset=mp_addbanlist"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Введенный IP уже имеетеся в списке!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не ввели IP-адрес для бана!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ban.php">Вернуться</a>';
}

############################################################################################
##                                   Удаление из списка                                   ##
############################################################################################
if ($action=="del"){

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."ban.dat", $del);

header ("Location: ban.php?start=$start&isset=mp_delbanlist");  exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка удаления! Отсутствуют выбранные IP</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ban.php?start='.$start.'">Вернуться</a>';
}


############################################################################################
##                                     Очистка списка                                     ##
############################################################################################
if ($action=="clear"){

$uid = check($_GET['uid']);
if ($uid==$_SESSION['token']){

clear_files(DATADIR."ban.dat");

header ("Location: ban.php?start=$start&isset=mp_clearbanlist"); exit;

} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ban.php?start='.$start.'">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
