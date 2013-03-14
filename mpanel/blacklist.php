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

if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102))){
	
echo '<img src="../images/img/menu.gif" alt="image" /> <b>Черный список</b><br /><br />';	

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

echo '<b>Запрещенные E-mail</b> | <a href="blacklist.php?action=login&amp;'.SID.'">Запрещенные Логины</a><br /><br />';

$file = file(DATADIR."blackmail.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){

echo '<form action="blacklist.php?action=delmail&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['blacklist']){ $end = $total;}
else {$end = $start + $config['blacklist']; }
for ($fm = $start; $fm < $end; $fm++){

$data = explode("|",$file[$fm]);

$num = $total - $fm - 1;

if (empty($data[0])){$data[0] = 'Не указано';}

echo '<div class="b">';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';

echo '<img src="../images/img/edit.gif" alt="image" /> <b>'.$data[1].'</b></div>';
echo '<div>Добавил: <a href="../pages/anketa.php?uz='.$data[0].'&amp;'.SID.'">'.nickname($data[0]).'</a><br />';
echo 'Время: '.date_fixed($data[2]).'</div>';
}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('blacklist.php?', $config['blacklist'], $start, $total);
page_strnavigation('blacklist.php?', $config['blacklist'], $start, $total);

} else {echo'<img src="../images/img/reload.gif" alt="image" />  <b>Cписок e-mail еще пуст!</b><br /><br />';}  

echo '<br /><br /><form action="blacklist.php?action=addmail&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo '<b>E-mail:</b><br />';
echo '<input name="email" type="text" />';
echo '<input type="submit" value="Добавить" /></form><hr />';

echo 'Всего в списке: '.(int)$total.'<br />';
}


############################################################################################
##                                   Удаление адресов                                     ##
############################################################################################
if ($action=="delmail") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."blackmail.dat", $del); 

header ("Location: blacklist.php?start=$start&isset=mp_blackmaildel&".SID);	exit;

} else {echo '<b>Ошибка удаления! Отсутствуют выбранные адреса!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="blacklist.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';	

}

############################################################################################
##                                 Добавление адресов                                     ##
############################################################################################
if ($action=="addmail") {

$uid = check($_GET['uid']);
$email = check($_POST['email']);

if ($uid==$_SESSION['token']){
if ($email!=""){
if (preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#',$email)){

$string = search_string(DATADIR."blackmail.dat", $email, 1);
if (empty($string)){

$text = $log.'|'.$email.'|'.SITETIME.'|';

write_files(DATADIR."blackmail.dat", "$text\r\n");

header ("Location: blacklist.php?start=$start&isset=mp_blackmailadd&".SID);	exit;

} else {echo '<b>Ошибка! Данный e-mail уже имеется в списках!</b><br />';}
} else {echo '<b>Неправильный адрес e-mail, необходим формат name@site.domen!</b><br />';}
} else {echo '<b>Ошибка, вы не ввели E-mail для добавления!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="blacklist.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}

############################################################################################
##                                     Список логинов                                     ##
############################################################################################
if($action=="login"){	

echo '<a href="blacklist.php?'.SID.'">Запрещенные E-mail</a> | <b>Запрещенные Логины</b><br /><br />';

$file = file(DATADIR."blacklogin.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){ 

echo '<form action="blacklist.php?action=dellogin&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['blacklist']){ $end = $total;}
else {$end = $start + $config['blacklist']; }
for ($fm = $start; $fm < $end; $fm++){

$data = explode("|",$file[$fm]);

$num = $total - $fm - 1;


if (empty($data[0])){$data[0] = 'Не указано';}

echo '<div class="b">';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';

echo '<img src="../images/img/edit.gif" alt="image" /> <b>'.$data[1].'</b></div>';

echo '<div>Добавил: <a href="../pages/anketa.php?uz='.$data[0].'&amp;'.SID.'">'.nickname($data[0]).'</a><br />';
echo 'Время: '.date_fixed($data[2]).'</div>';
}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('blacklist.php?action=login&amp;', $config['blacklist'], $start, $total);
page_strnavigation('blacklist.php?action=login&amp;', $config['blacklist'], $start, $total);

} else {echo'<img src="../images/img/reload.gif" alt="image" />  <b>Cписок логинов еще пуст!</b><br /><br />';}  

echo '<br /><br /><form action="blacklist.php?action=addlogin&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo '<b>Логин:</b><br />';
echo '<input name="login" type="text" />';
echo '<input type="submit" value="Добавить" /></form><hr />';

echo 'Всего в списке: '.(int)$total.'<br />';
}

############################################################################################
##                                   Удаление логинов                                     ##
############################################################################################
if ($action=="dellogin") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."blacklogin.dat", $del); 

header ("Location: blacklist.php?action=login&start=$start&isset=mp_blacklogindel&".SID); exit;

} else {echo '<b>Ошибка удаления! Отсутствуют выбранные логины!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="blacklist.php?action=login&amp;start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

############################################################################################
##                                  Добавление логинов                                    ##
############################################################################################
if($action=="addlogin") {

$uid = check($_GET['uid']);
$login = check($_POST['login']);

if ($uid==$_SESSION['token']){
if ($login!=""){
if (preg_match('|^[a-z0-9\-]+$|i',$login)){

$string = search_string(DATADIR."blacklogin.dat", $login, 1);
if (empty($string)){

$text = $log.'|'.$login.'|'.SITETIME.'|';

write_files(DATADIR."blacklogin.dat", "$text\r\n");

header ("Location: blacklist.php?action=login&start=$start&isset=mp_blackloginadd&".SID); exit;

} else {echo '<b>Ошибка! Данный логин уже имеется в списках!</b><br />';}
} else {echo '<b>Недопустимый логин, разрешены знаки латинского алфавита и цифры!</b><br />';}
} else {echo '<b>Ошибка, вы не ввели логин для добавления!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="blacklist.php?action=login&amp;start='.$start.'&amp;'.SID.'">Вернуться</a>';	
}

//-------------------------------- КОНЦОВКА ------------------------------------//	
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>