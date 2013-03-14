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
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");

$id = (int)$_GET['id'];
if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])){$action = check($_GET['action']);} else {$action = "";}

show_title('partners.gif', 'Комментарии к новостям');

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

$string = search_string(DATADIR."news.dat", $id, 5);
if ($string) {

echo '<img src="../images/img/news.gif" alt="image" /> <b>'.$string[0].'</b><br /><br />';

echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
echo '<a href="#form">Написать</a> / ';	
echo '<a href="komm.php?id='.$id.'&amp;rand='.mt_rand(100,999).'&amp;'.SID.'"> Обновить</a><hr />';

if (file_exists(DATADIR."datakomm/$id.dat")){
$file = file(DATADIR."datakomm/$id.dat");
$file = array_reverse($file);
$total = count($file);    

if($total>0){

$is_admin = is_admin(array(101,102,103,105));

if ($is_admin){echo '<form action="komm.php?action=del&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';}

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['postnews']){ $end = $total; }
else {$end = $start + $config['postnews']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);
$num = $total-$i-1;

echo '<div class="b">';

if ($is_admin) {echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';}

echo user_avatars($data[4]);

echo '<b><a href="../pages/anketa.php?uz='.$data[4].'&amp;'.SID.'"> '.nickname($data[4]).' </a></b> '.user_title($data[4]).user_online($data[4]);	
	
echo '<small> ('.date_fixed($data[3]).')</small></div>';

echo '<div>'.bb_code($data[1]).'<br />';
echo '<span class="data">('.$data[0].')</span></div>';
}
if ($is_admin){echo '<br /><input type="submit" value="Удалить выбранное" /></form>';}

page_jumpnavigation('komm.php?id='.$id.'&amp;', $config['postnews'], $start, $total);
page_strnavigation('komm.php?id='.$id.'&amp;', $config['postnews'], $start, $total);

} else {show_error('Комментариев еще нет, будь первым!');}
} else {show_error('Комментариев еще нет, будь первым!');}

if (is_user()){

echo '<br /><div class="form" id="form"><form action="komm.php?action=add&amp;id='.$id.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post"><b>Сообщение:</b><br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input type="submit" value="Написать" /></form></div>';

} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><a href="#up"><img src="../images/img/ups.gif" alt="image" /></a> ';
echo '<a href="../pages/pravila.php?'.SID.'">Правила</a> / ';
echo '<a href="../pages/smiles.php?'.SID.'">Смайлы</a> / ';
echo '<a href="../pages/tegi.php?'.SID.'">Теги</a><br />';

} else {show_error('Ошибка! Выбранная вами новость не существует, возможно она была удалена!');}
}

############################################################################################
##                                  Добавление комментариев                               ##
############################################################################################
if ($action=="add"){

$uid = check($_GET['uid']);
$id = (int)$_GET['id'];
$msg = check($_POST['msg']);

if (is_user()){
if ($uid==$_SESSION['token']){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){

$string = search_string(DATADIR."news.dat", $id, 5);
if ($string) {

antiflood("Location: komm.php?id=$id&isset=antiflood&".SID);
karantin($udata[6], "Location: komm.php?id=$id&isset=karantin&".SID);
statistics(3);

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$lastid = 0;

if (file_exists(DATADIR."datakomm/$id.dat")){
$file = file(DATADIR."datakomm/$id.dat");
$lastkomm = explode("|",end($file));
$lastid = $lastkomm[5] + 1;
}

$text=no_br($brow.', '.$ip.'|'.$msg.'||'.SITETIME.'|'.$log.'|'.$lastid.'|');

write_files(DATADIR."datakomm/$id.dat", "$text\r\n", 0, 0666);

$countstr = counter_string(DATADIR."datakomm/$id.dat");
if ($countstr>=$config['maxkommnews']) {
delete_lines(DATADIR."datakomm/$id.dat",array(0,1));
}

change_profil($log, array(14=>$ip, 33=>$udata[33]+1, 36=>$udata[36]+1, 41=>$udata[41]+1));

header ("Location: komm.php?id=$id&isset=addon&".SID); exit;

} else {show_error('Ошибка! Выбранная вами новость не существует, возможно она была удалена!');}
} else {show_error('Ошибка! Слишком длинное или короткое сообщение!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="komm.php?id='.$id.'&amp;start='.$start.'&amp;'.SID.'">К комментариям</a>';
}
############################################################################################
##                                  Удаление комментариев                                 ##
############################################################################################
if ($action=="del"){

if (is_admin(array(101,102,103,105))){

$uid = check($_GET['uid']);
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){
if (preg_match('|^[a-z0-9_\.\-]+$|i', $id)){
if (file_exists(DATADIR."datakomm/$id.dat")){

delete_lines(DATADIR."datakomm/$id.dat", $del);

header("location: komm.php?id=$id&start=$start&isset=selectpriv&".SID); exit;

} else {show_error('Ошибка! Отстутствует файл с комментариями!');}
} else {show_error('Ошибка! Не выбран файл с комментариями!');}
} else {show_error('Ошибка! Отстутствуют выбранные сообщения для удаления!');}
} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}
} else {show_error('Ошибка! Удалять сообщения могут только модераторы!');}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="komm.php?id='.$id.'&amp;start='.$start.'&amp;'.SID.'">К комментариям</a>';
}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="index.php?'.SID.'">Вернуться</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>
