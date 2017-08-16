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
if (isset($_GET['start'])) {$start = (int)$_GET['start'];} else {$start = 0;}

if (is_admin(array(101,102))){

echo '<img src="../images/img/menu.gif" alt="image" /> <b>Управление новостями</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){
$file = file(DATADIR."news.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

echo '<form action="news.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['postnews']){ $end = $total; }
else {$end = $start + $config['postnews']; }

for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

echo '<div class="b">';
echo '<img src="../images/img/edit.gif" alt="image" /> ';
echo '<b>'.$data[0].'</b> <small>('.date_fixed($data[3]).')</small><br />';
echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';
echo '<a href="news.php?action=editnews&amp;id='.$num.'&amp;start='.$start.'&amp;'.SID.'">Редактировать</a>';
echo '</div><div>'.bb_code($data[1]).'<br />';

echo 'Разместил: '.$data[4].'<br />';
echo '<a href="../news/komm.php?id='.$data[5].'&amp;'.SID.'">Комментарии</a> ';

$countkomm = counter_string(DATADIR."datakomm/$data[5].dat");
echo '('.(int)$countkomm.')</div>';

}

echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('news.php?', $config['postnews'], $start, $total);
page_strnavigation('news.php?', $config['postnews'], $start, $total);

echo '<br /><br />Всего новостей: <b>'.(int)$total.'</b><br />';

} else {echo '<br /><img src="../images/img/reload.gif" alt="image" /> <b>Новостей еще нет!</b><br />';}

echo '<br /><img src="../images/img/reload.gif" alt="image" /> <a href="news.php?action=addnews&amp;'.SID.'">Добавить новость</a>';

}

############################################################################################
##                                  Удаление новостей                                     ##
############################################################################################
if ($action=="del") {

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

$file = file(DATADIR."news.dat");

foreach($del as $val){
if (isset($file[$val])){
$data = explode("|", $file[$val]);

if(file_exists(DATADIR."datakomm/$data[5].dat")){
unlink (DATADIR."datakomm/$data[5].dat");
}}}

delete_lines(DATADIR."news.dat", $del);

header ("Location: news.php?start=$start&isset=mp_delnews&".SID);  exit;

} else {echo '<b>Ошибка удаления! Отсутствуют выбранные новости</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="news.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                         Подготовка к редактированию новости                            ##
############################################################################################
if ($action=="editnews") {

if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!=="") {

$file = file(DATADIR."news.dat");
if (isset($file[$id])){
$data = explode("|", $file[$id]);

$data[1] = nosmiles($data[1]);
$data[1] = str_replace("<br />","\r\n",$data[1]);

echo '<b><big>Редактирование</big></b><br /><br />';

echo '<form action="news.php?action=edit&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" name="form" method="post">';
echo 'Заголовок: <br /><input type="text" name="name" size="50" maxlength="50" value="'.$data[0].'" /><br />';
echo 'Cообщение:<br />';
echo '<textarea cols="25" rows="10" name="msg">'.$data[1].'</textarea><br />';
echo '<input type="hidden" name="timer" value="'.$data[3].'" />';
echo '<input type="hidden" name="logins" value="'.$data[4].'" />';
echo '<input type="hidden" name="komm" value="'.$data[5].'" />';

quickpaste('msg');
quickcode();
quicksmiles();

echo '<br /><input type="submit" value="Изменить" /></form><hr />';

} else {echo '<b>Ошибка! Новости для редактирования не существует!</b><br />';}
} else {echo '<b>Произошла ошибка, не выбрана новость для редактирования!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="news.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                            Редактирование выбранной новости                            ##
############################################################################################
if($action=="edit"){

$uid = check($_GET['uid']);
$name = check($_POST['name']);
$msg = check($_POST['msg']);
$timer = check($_POST['timer']);
$logins = check($_POST['logins']);
$komm = (int)$_POST['komm'];
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} else {$id = "";}

if ($id!=="") {
if ($uid==$_SESSION['token']){
if ($name!="" && $msg!="" && $timer!="" && $logins!="" && $komm!==""){

$msg = no_br($msg,' <br /> ');
$msg = smiles($msg);

$text = no_br($name.'|'.$msg.'||'.$timer.'|'.$logins.'|'.$komm.'|');

replace_lines(DATADIR."news.dat", $id, $text);

header ("Location: news.php?start=$start&isset=mp_editnews&".SID); exit;

} else {echo '<b>Ошибка редактирования, отсутствуют важные данные</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}
} else {echo '<b>Ошибка редактирования выбранной вами новости</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="news.php?start='.$start.'&amp;'.SID.'">Вернуться</a>';
}


############################################################################################
##                            Подготовка к добавлению новости                             ##
############################################################################################
if($action=="addnews"){

echo '<b><big>Создание новости</big></b><br /><br />';

echo '<form action="news.php?action=add&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" name="form" method="post">';
echo 'Заголовок новости:<br />';
echo '<input type="text" name="themes" size="50" maxlength="50" /><br />';
echo 'Новость:<br />';
echo '<textarea cols="50" rows="10" name="msg"></textarea><br />';

quickpaste('msg');
quickcode();
quicksmiles();

echo 'Рассылка: <input name="subadd" type="checkbox" value="yes" /><br />';
echo '<br /><input type="submit" value="Добавить" /></form><hr />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="news.php?'.SID.'">Вернуться</a>';
}


############################################################################################
##                                  Добавление новости                                    ##
############################################################################################
if($action=="add"){

$uid = check($_GET['uid']);
$msg = check($_POST['msg']);
$themes = check($_POST['themes']);
if (isset($_POST['subadd'])) {$subadd = check($_POST['subadd']);} else {$subadd = "";}

if ($uid==$_SESSION['token']){
if ($themes!="" && $msg!=""){

$msg = no_br($msg,' <br /> ');
$msg = smiles($msg);

$file = file(DATADIR."news.dat");
$ndata = explode("|",end($file));
$kommfile = $ndata[5] + 1;

/***************** Создание новости ******************/
$textnews = no_br($themes.'|'.$msg.'||'.SITETIME.'|'.$log.'|'.$kommfile.'|');

write_files(DATADIR."news.dat", "$textnews\r\n");

/**************** Создание комментариев **************/
$textkomm = no_br($brow.', '.$ip.'|'.$msg.'||'.SITETIME.'|'.$log.'|1|');

write_files(DATADIR."datakomm/$kommfile.dat", "$textkomm\r\n", 0, 0666);

if ($subadd=="yes"){

echo '<b>Новость успешно добавлена!</b><br /><br />';

$msg = nosmiles($msg);
$msg = str_replace('<br />',"\n",$msg);
$msg = strip_tags(bb_code($msg));

echo '<form action="news.php?action=sub&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post" />';
echo '<input type="hidden" name="themes" value="'.$themes.'" />';
echo '<input type="hidden" name="msg" value="'.$msg.'" />';
echo '<input type="submit" value="Перейти к рассылке" /></form><hr />';

} else { header ("Location: news.php?isset=mp_addnews&".SID); exit;}
} else {echo '<b>Ошибка добавления новости, пустой заголовок или новость!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="news.php?action=addnews&amp;'.SID.'">Вернуться</a>';

}

############################################################################################
##                                      Рассылка писем                                    ##
############################################################################################
if ($action=="sub"){

$uid = check($_GET['uid']);
$msg = check($_POST['msg']);
$themes = check($_POST['themes']);
if (isset($_GET['last'])) {$last = (int)$_GET['last'];} else {$last = 0;}

if ($uid==$_SESSION['token']){
if ($themes!="" && $msg!=""){

$dates = date_fixed(SITETIME, "j F, Y / H:i");

$send_file = file(DATADIR."subscribe.dat");
$send_count = count($send_file);

$next = $last + $config['submail'];
if ($next > $send_count) {$next = $send_count;}

for ($i=$last; $i<$next; $i++) {
$data = explode("|",$send_file[$i]);

/******************* Рассылка писем на E-mail ********************/
if($data[0]!=""){
addmail($data[0], "Рассылка новостей с сайта ".$config['title'], html_entity_decode($themes)." (".$dates.") \n".html_entity_decode($msg)." \n\nВы получили это письмо, потому что являетесь подписчиком сайта ".$config['home']." \nОтписаться от рассылки вы можете в своем профиле на нашем сайте \nили клинув по этой ссылке \n".$config['home']."/pages/subscribe.php?key=".$data[1]);
}
}

if ($next < $send_count) {
$per = round(100 * $next / $send_count);

echo '<br />Рассылка начата<br />';
echo 'Успешно отправлено: '.(int)$per.'%<br /><br />';

echo '<form action="news.php?action=sub&amp;last='.$next.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post" />';
echo '<input type="hidden" name="themes" value="'.$themes.'" />';
echo '<input type="hidden" name="msg" value="'.$msg.'" />';
echo '<input type="submit" value="Продолжить рассылку" /></form><hr />';

} else {echo '<b>Рассылка успешно окончена</b><br /><br />';}

echo 'Всего подписчиков: '.(int)$send_count.'<br />';

} else {echo '<b>Ошибка рассылки новостей, пустой заголовок или новость!</b><br />';}
} else {echo '<b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="news.php?'.SID.'">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
