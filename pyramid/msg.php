<?php
#####################################
##     *** WAP MOTOR ****          ##
##      Автор : VERTUOZ            ##
##     E-mail : info@05dag.ru      ##
##       Site : http://05dag.ru    ##
##        ICQ : 369902212          ##
#####################################
if (!defined('BASEDIR')) { header("Location:../index.php"); exit; }

if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}

if (file_exists(BASEDIR."pyramid/msg.dat")) {
require_once ("pyramid/conf.php");

$file = file(BASEDIR."pyramid/msg.dat");
$file = array_reverse($file);
$total = count($file);


echo '<br /><div class="b">ICQ Пирамида ('.$total.') ';


if (is_admin(array(101,102,103,105))){

echo '<a href="pyramid/del.php?action=all" onclick="return confirm(\'Вы действительно хотите очистить пирамиду?\')"><img src="images/img/close.gif" alt="Очистить" /></a> ';
echo '<a href="pyramid/admin.php"><img src="images/img/panel.gif" alt="Настройки" /></a>';}


echo ' <a href="index.php"><img src="images/img/reload.gif" alt="Обновить" /></a></div>';

echo '<a href="pyramid/index.php">Написать</a> / <a href="pyramid/history.php">История</a><br />';

if ($total>0){
if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $msg_list){ $end = $total; }
else {$end = $start + $msg_list; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);
$num = $total - $i - 1;


if ($small_msg=="On") {$data[1] = '<small>'.$data[1].'</small>';}

$data[1] = str_replace ('<img src="../images', '<img src="images', $data[1]);
if (!empty($data[2])) {$icq = ' (ICQ: '.$data[2].')';} else {$icq = '';}

echo ' <a href="pyramid/index.php?name='.safe_encode(nickname($data[0])).'"><b>'.nickname($data[0]).'</b></a>'.$icq;
if (is_admin(array(101,102,103,105))){
echo ' <a href="pyramid/del.php?id='.$num.'">[x]</a>';
}

echo '<br />'.bb_code($data[1]).'<br />';

if (is_admin(array(101,102,103,105))){
if ($look_ip=="On"){
echo '<span class="data">('.$data[4].', '. $data[5].')</span><br />';
}}
}
page_jumpnavigation('index.php?', $msg_list, $start, $total);

} else {show_error('В пирамиде еще нет сообщений!');}
} else {show_error('В пирамиде еще нет сообщений!');}

?>
