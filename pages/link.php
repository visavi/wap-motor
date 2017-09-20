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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Добавь свой сайт</b><br /><br />';

if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){

include_once BASEDIR."includes/link.php";

echo '<hr /><form action="link.php?action=add" method="post">';
echo 'Адрес сайта:<br />';
echo '<input type="text" name="linkurl" value="http://" maxlength="50" /><br />';
echo 'Название (max25):<br />';
echo '<input type="text" name="linkname" maxlength="25" /><br /><br />';
echo '<input type="submit" value="Добавить" /></form><hr />';

echo 'В названии ссылки запрещено использовать любые ненормативные и матные слова<br />';
echo 'За нарушение правил предусмотрено наказание в виде строгого бана<br />';
}


############################################################################################
##                                  Добавление ссылки                                     ##
############################################################################################
if($action=="add"){

$linkurl = check(trim(strtolower($_POST['linkurl'])));
$linkname = check(trim($_POST['linkname']));

$linkurl = strtolower($linkurl);
$linkname = antimat($linkname);

if (utf_strlen($linkname)>=5 && utf_strlen($linkname)<=25){
if (preg_match('#^http://([a-z0-9_\-\.])+(\.([a-z0-9\/])+)+$#', $linkurl)) {

$linkcell_url = search_string(DATADIR."link.dat", $linkurl, 0);
$linkcell_log = search_string(DATADIR."link.dat", $log, 2);

if(empty($linkcell_url)){
if(empty($linkcell_log)){

$text=$linkurl.'|'.$linkname.'|'.$log.'|';
$text=no_br($text);

if($text!="" && $linkurl!=""){
$fp = fopen(DATADIR."link.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}

$countstr = counter_string(DATADIR."link.dat");
if ($countstr > $config['showlink']) {
delete_lines(DATADIR."link.dat",0);
}

header ("Location: link.php?isset=addlink"); exit;

}else{echo '<b>Вы уже добавили сайт в базу, запрещено добавлять несколько сайтов подряд</b><br />';}
}else{echo '<b>Данный сайт уже имеется в базе, запрещено добавлять несколько сайтов подряд</b><br />';}
}else{echo '<b>Неправильный адрес! Разрешается добавлять только адрес главной страницы!</b><br />';}
}else{echo '<b>Неправильное название! Не менее 5 и не более 25 знаков в названии!</b><br />'; }

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="link.php">Вернуться</a>';
}

} else {show_login('Вы не авторизованы, чтобы добавить новую ссылку, необходимо');}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>
