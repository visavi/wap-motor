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

show_title('menu.gif', 'Форум '.$config['title']);
$config['newtitle'] = 'Форум - Список разделов';

if (file_exists(DATADIR."dataforum/mainforum.dat")) {
	$fileforum = file(DATADIR."dataforum/mainforum.dat");
	$total = count($fileforum);

	if ($total>0) {

	foreach($fileforum as $forumval){
		$forum = explode("|", $forumval);

		echo '<div class="b"><img src="../images/img/forums.gif" alt="image" /> ';
		echo '<b><a href="forum.php?fid='.$forum[0].'&amp;'.SID.'">'.$forum[1].'</a></b> ('.$forum[2].'/'.$forum[3].')</div>';

		$totalforum = counter_string(DATADIR."dataforum/topic".$forum[0].".dat");

		if($totalforum>0){
			$filetopic = file(DATADIR."dataforum/topic".$forum[0].".dat");
			$topic = explode("|", end($filetopic));

			if (file_exists(DATADIR.'dataforum/'.$forum[0].'-'.$topic[0].'.dat')) {
				$filepost = file(DATADIR.'dataforum/'.$forum[0].'-'.$topic[0].'.dat');
				$post = explode("|", end($filepost));

				if (utf_strlen($topic[3])>35) {$topic[3]=utf_substr($topic[3], 0, 30); $topic[3].="...";}

				echo '<div>Тема: <a href="topic.php?act=end&amp;fid='.$forum[0].'&amp;id='.$topic[0].'&amp;'.SID.'">'.$topic[3].'</a><br />';
				echo 'Сообщение: '.nickname($post[2]).' ('.date_fixed($post[6]).')</div>';

			} else {echo 'Последняя тема не найдена!';}
		} else {echo 'Раздел пустой! Темы еще не созданы!';}
	}

	echo '<br />Всего разделов: <b>'.$total.'</b><br /><br />';

	} else {show_error('Форум пустой! Разделы еще не созданы!');}
} else {show_error('Форум пустой! Разделы еще не созданы!');}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

include_once ('../themes/'.$config['themes'].'/foot.php');
?>
