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
$fid = (isset($_GET['fid'])) ? abs(intval($_GET['fid'])) : 0;
$id = (isset($_GET['id'])) ? abs(intval($_GET['id'])) : 0;

show_title('menu.gif', 'Форум '.$config['title']);

if (file_exists(DATADIR."dataforum/topic$fid.dat")){
if (file_exists(DATADIR."dataforum/$id.dat")){

switch ($act):
############################################################################################
##                                    Вывод всех сообщений                                ##
############################################################################################
case "index":

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

		echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
		echo '<a href="index.php?'.SID.'">Форум</a> / ';
		echo '<a href="forum.php?fid='.$fid.'&amp;'.SID.'">'.$forum[1].'</a> / ';
		echo '<a href="forum.php?act=new&amp;fid='.$fid.'&amp;'.SID.'">Новая тема</a>';

		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {

			$total = counter_string(DATADIR."dataforum/$id.dat");
			echo '<br /><br /><img src="../images/img/themes.gif" alt="image" /> <b>'.$topic[3].'</b> ('.$total.' пост.)<hr />';

			if ($total>0) {
				$file = file(DATADIR."dataforum/$id.dat");

				if ($start < 0 || $start >= $total){$start = 0;}
				if ($total < $start + $config['forumpost']){ $end = $total; }
				else {$end = $start + $config['forumpost']; }
				for ($i = $start; $i < $end; $i++){

					$data = explode("|", $file[$i]);

					echo '<div class="b">';
					echo user_avatars($data[2]).' <b><a href="../pages/anketa.php?uz='.$data[2].'&amp;'.SID.'">'.nickname($data[2]).'</a></b> ';
					echo user_title($data[2]).user_online($data[2]);
					echo ' <small>('.date_fixed($data[6]).')</small></div>';
					echo '<div>'.bb_code($data[4]).'<br />';
					echo '<span class="data">('.$data[5].')</span>';
					echo '</div>';
				}

				page_strnavigation('topic.php?fid='.$fid.'&amp;id='.$id.'&amp;', $config['forumpost'], $start, $total);


				if (is_user()){

					echo '<div class="form" id="form">';
					echo '<form action="topic.php?act=add&amp;fid='.$fid.'&amp;id='.$id.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
					echo 'Сообщение:<br />';
					echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
					echo '<input type="submit" value="Написать" /></form></div><br />';

				} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}

			} else {show_error('Тема пустая! Сообщений еще нет!');}
		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}
break;

############################################################################################
##                                    Добавление сообщения                                ##
############################################################################################
case "add":
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {
		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {

			$msg = check($_POST['msg']);

			antiflood("Location: topic.php?fid=$fid&id=$id&isset=antiflood&".SID);
			karantin($udata[6], "Location: topic.php?fid=$fid&id=$id&isset=karantin&".SID);

			if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<=5000){

				$msg = no_br($msg,'<br />');

				$text = $id.'|'.$fid.'|'.$log.'|'.$topic[3].'|'.$msg.'|'.$brow.', '.$ip.'|'.SITETIME.'|';

				// Запись сообщения
				write_files(DATADIR."dataforum/$id.dat", "$text\r\n", 0, 0666);

				// Поднятие темы в списке
				shift_lines(DATADIR."dataforum/topic$fid.dat", $topic['line']);

				// Обновление mainforum
				$maintext = $forum[0].'|'.$forum[1].'|'.$forum[2].'|'.($forum[3]+1).'|';
				replace_lines(DATADIR."dataforum/mainforum.dat", $forum['line'], $maintext);

				header ("Location: topic.php?act=end&fid=$fid&id=$id&isset=oktem&".SID); exit;

			} else {show_error('Слишком длинный или короткий текст сообщения (Необходимо от 5 до 3000 символов)');}
		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="topic.php?fid='.$fid.'&amp;id='.$id.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Добавление сообщения                                ##
############################################################################################
case "end":
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {
		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {
			$totpage = counter_string(DATADIR."dataforum/".$id.".dat");
			$lastpage = ceil($totpage/$config['forumpost']) * $config['forumpost'] - $config['forumpost'];

			header ("Location: topic.php?fid=$fid&id=$id&start=$lastpage&".SID); exit;

		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="index.php?'.SID.'">Вернуться</a><br />';
break;

default:
header("location: index.php?".SID); exit;
endswitch;

} else {show_error('Данной темы не существует, возможно она была удалена!');}
} else {show_error('Разделы форума еще не созданы!');}

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

include_once ('../themes/'.$config['themes'].'/foot.php');
?>
