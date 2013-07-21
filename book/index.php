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

if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}

show_title('partners.gif', 'Гостевая книга');

echo '<a href="#down"><img src="../images/img/downs.gif" alt="down" /></a> ';
echo '<a href="#form">Написать</a> / ';
echo '<a href="index.php?rand='.mt_rand(100,999).'&amp;'.SID.'">Обновить</a>';

if (is_admin(array(101,102,103,105))){
echo ' / <a href="'.ADMINDIR.'book.php?start='.$start.'&amp;'.SID.'">Управление</a>';
}
echo '<hr />';

$file = file(DATADIR."book.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $config['bookpost']){ $end = $total; }
else {$end = $start + $config['bookpost']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

echo '<div class="b">';

echo user_avatars($data[1]);

if ($data[1]==$config['guestsuser']){
echo '<b>'.$data[1].'</b> ';
} else {
echo '<b><a href="../pages/anketa.php?uz='.$data[1].'&amp;'.SID.'">'.nickname($data[1]).'</a></b> '.user_title($data[1]).user_online($data[1]).' ';
}

echo '<small>('.date_fixed($data[3]).')</small></div>';
echo '<div>'.bb_code($data[0]).'<br />';
echo '<span class="data">('.$data[4].', '. $data[5].')</span>';
if ($data[6]!=""){ echo '<br /><span style="color:#ff0000">'.$data[6].'</span>';}
if ($data[7]!=""){ echo '<br /><span style="color:#ff0000">Отредактировано: '.nickname($data[7]).' ('.date_fixed($data[2]).')</span>';}
echo '</div>';
}

page_jumpnavigation('index.php?', $config['bookpost'], $start, $total);
page_strnavigation('index.php?', $config['bookpost'], $start, $total);

} else {show_error('Сообщений нет, будь первым!');}

if (is_user()){

echo '<br /><div class="form" id="form">';
echo '<form action="add.php?uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Сообщение:<br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input type="submit" value="Написать" /></form></div>';

} elseif($config['bookadds']==1){

echo '<br /><div class="form" id="form">';
echo '<form action="add.php?uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
echo 'Сообщение:<br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';

echo 'Проверочный код:<br /> ';
echo '<input name="provkod" size="6" maxlength="6" /> ';

if ($config['protectimg']==1){
echo '<img src="../gallery/protect.php?'.SID.'" alt="" /><br />';
} else {
echo '<b>'.$_SESSION['protect'].'</b><br />';
}

echo '<br /><input type="submit" value="Написать" /></form></div>';

} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

echo '<br /><a href="#up"><img src="../images/img/ups.gif" alt="image" /></a> ';
echo '<a href="../pages/pravila.php?'.SID.'">Правила</a> / ';
echo '<a href="../pages/smiles.php?'.SID.'">Смайлы</a> / ';
echo '<a href="../pages/tegi.php?'.SID.'">Теги</a><br /><br />';

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>
