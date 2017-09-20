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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Игнор-лист</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

if (file_exists(DATADIR."dataignor/$log.dat")){
$file = file(DATADIR."dataignor/$log.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

echo '<form action="ignor.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['ignorlist']){ $end = $total; }
else {$end = $start + $config['ignorlist']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);
$num = $total - $i - 1;

echo '<div class="b">'.user_avatars($data[1]).' '.($i+1).'. <b><a href="anketa.php?uz='.$data[1].'">'.nickname($data[1]).'</a></b> '.user_online($data[1]).'</div>';
echo '<div>Дабавлен: '.date_fixed($data[2]).'<br />';
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<a href="privat.php?action=submit&amp;uz='.$data[1].'">Написать</a> | ';
echo '<a href="../games/perevod.php?uz='.$data[1].'">Перевод</a></div>';
}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('ignor.php?', $config['ignorlist'], $start, $total);
page_strnavigation('ignor.php?', $config['ignorlist'], $start, $total);

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Игнор-лист пуст!</b><br />';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Игнор-лист пуст!</b><br />';}

echo '<hr /><form method="post" action="ignor.php?action=add&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'">';
echo 'Логин юзера:<br /><input name="uz" />';
echo '<input value="Добавить" type="submit" /></form>';

if ($total>1){echo '<br /><img src="../images/img/error.gif" alt="image" /> <a href="ignor.php?action=prodel">Очистить список</a>';}
}

############################################################################################
##                                 Дабавление пользователей                               ##
############################################################################################
if($action=="add"){

$uid = check($_GET['uid']);
if (isset($_POST['uz'])) {$uz = check($_POST['uz']);} elseif (isset($_GET['uz'])){$uz = check($_GET['uz']);} else {$uz = "";}

if ($uid==$_SESSION['token']){
if (preg_match('|^[a-z0-9\-]+$|i',$uz)){
if (file_exists(DATADIR."profil/$uz.prof")){
if (counter_string(DATADIR."dataignor/$log.dat")<=50){
if ($uz!=$log){

$addstr = search_string(DATADIR."dataignor/$log.dat", $uz, 1);
if (empty($addstr)) {

write_files(DATADIR."dataignor/$log.dat", '|'.$uz.'|'.SITETIME."|\r\n", 0, 0666);

//------------------------------Уведомление по привату------------------------//
if ($udata[74]<SITETIME){

$ignorstr = search_string(DATADIR."dataignor/$uz.dat", $log, 1);
if (empty($ignorstr)) {

$filesize = filesize(DATADIR.'privat/'.$uz.'.priv');
$pers = round((($filesize / 1024) * 100) / $config['limitsmail']);
if ($pers < 99){

$text = no_br($log.'|Пользователь '.nickname($log).' добавил вас в свой игнор-лист|'.SITETIME.'|');

write_files(DATADIR.'privat/'.$uz.'.priv', "$text\r\n");

$uzdata = reading_profil($uz);
change_profil($uz, array(10=>$uzdata[10]+1));

}}}

change_profil($log, array(74=>SITETIME+300));

header ("Location: ignor.php?start=$start&isset=ignor_add"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, данный пользователь уже есть в игнор-листе!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, запрещено добавлять свой логин!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, в игнор-листе разрешено не более 50 пользователей!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, пользователя с данным логином не существует!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, недопустимое название логина!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ignor.php?start='.$start.'">Вернуться</a>';
}


############################################################################################
##                                   Удаление пользователей                               ##
############################################################################################
if($action=="del"){

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."dataignor/$log.dat", $del);
header ("Location: ignor.php?start=$start&isset=ignor_del"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка удаления из игнор-листа!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ignor.php?start='.$start.'">Вернуться</a>';
}

############################################################################################
##                                 Подтверждение очистки                                  ##
############################################################################################
if ($action=="prodel") {
echo 'Вы уверены что хотите удалить всех пользователе из игнора?<br />';
echo '<img src="../images/img/error.gif" alt="image" /> <b><a href="ignor.php?action=alldel&amp;uid='.$_SESSION['token'].'">Да, уверен!</a></b><br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ignor.php?start='.$start.'">Вернуться</a>';
}

############################################################################################
##                                      Очистка списка                                    ##
############################################################################################
if($action=="alldel"){

$uid = check($_GET['uid']);

if ($uid==$_SESSION['token']){

clear_files(DATADIR."dataignor/$log.dat");
header ("Location: ignor.php?isset=ignor_clear");	exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ignor.php?start='.$start.'">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, для просмотра игнор-листа, необходимо');}

echo '<br /><img src="../images/img/chat.gif" alt="image" /> <a href="kontakt.php">Контакт-лист</a><br />';
echo '<img src="../images/img/mail.gif" alt="image" /> <a href="privat.php">В приват</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>
