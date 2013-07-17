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

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;

show_title('menu.gif', 'Форум '.$config['title']);

switch ($act):
############################################################################################
##                                 Вывод перечня категорий                                ##
############################################################################################
case "index":
if (file_exists(DATADIR."dataforum/mainforum.dat")) {
	$lines = file(DATADIR."dataforum/mainforum.dat");
	$total = count($lines);

	if ($total>0) {

	foreach($lines as $forumval){
		$data = explode("|", $forumval);

		echo '<div class="b"><img src="../images/img/forums.gif" alt="image" /> ';
		echo '<b><a href="forum.php?fid='.$data[0].'&amp;'.SID.'">'.$data[1].'</a></b> ('.$data[2].'/'.$data[3].')</div>';

		$totalforum = counter_string(DATADIR."dataforum/topic".$data[0].".dat");

		if($totalforum>0){
			$filetopic = file(DATADIR."dataforum/topic".$data[0].".dat");
			$topic = explode("|", end($filetopic));

			if (file_exists(DATADIR."dataforum/".$topic[0].".dat")) {
				$filepost = file(DATADIR."dataforum/".$topic[0].".dat");
				$post = explode("|", end($filepost));

				if (utf_strlen($topic[3])>35) {$topic[3]=utf_substr($topic[3], 0, 30); $topic[3].="...";}

				echo '<div>Тема: <a href="topic.php?act=end&amp;fid='.$data[0].'&amp;id='.$topic[0].'&amp;'.SID.'">'.$topic[3].'</a><br />';
				echo 'Сообщение: '.nickname($post[2]).' ('.date_fixed($post[6]).')</div>';

			} else {echo 'Последняя тема не найдена!';}
		} else {echo 'Раздел пустой! Темы еще не созданы!';}
	}

	echo '<br /><br />Всего разделов: <b>'.$total.'</b><br />';

	} else {show_error('Форум пустой! Разделы еще не созданы!');}
} else {show_error('Форум пустой! Разделы еще не созданы!');}
break;


default:
header("location: index.php?".SID); exit;
endswitch;

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ('../themes/'.$config['themes'].'/foot.php');
?>
