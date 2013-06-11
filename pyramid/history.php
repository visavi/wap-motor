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


if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}


show_title('menu.gif', 'Пирамида - История');

echo '<a href="index.php?'.SID.'">Написать</a>';
if (is_admin(array(101,102,103,105))){echo' / <a href="admin.php?'.SID.'">Управление</a>';}

echo '<hr />';
#####################################

if (file_exists(BASEDIR."pyramid/msg.dat")) {
require_once ("conf.php");

$file = file(BASEDIR."pyramid/msg.dat");
$file = array_reverse($file);
$total = count($file);    

if ($total>0){

if ($start < 0 || $start >= $total){$start = 0;}
if ($total < $start + $msg_his){ $end = $total; }
else {$end = $start + $msg_his; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);
$num = $total - $i - 1;

if (!empty($data[2])) {$icq = ' (ICQ: '.$data[2].')';} else {$icq = '';}

echo ' <a href="index.php?name='.safe_encode(nickname($data[0])).'"><b>'.nickname($data[0]).'</b></a>'.$icq;
if (is_admin(array(101,102,103,105))){
echo ' <a href="del.php?id='.$num.'&amp;'.SID.'">[x]</a> ';
}

echo '<br />'.bb_code($data[1]).'<br />';

if (is_admin(array(101,102,103,105))){
if ($look_ip=="On"){
echo '<span class="data">('.$data[4].', '. $data[5].')</span><br />'; 
}}

}

page_jumpnavigation('history.php?', $msg_his, $start, $total);
page_strnavigation('history.php?', $msg_his, $start, $total);

} else {show_error('В пирамиде еще нет сообщений!');}
} else {show_error('В пирамиде еще нет сообщений!');}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");
?>