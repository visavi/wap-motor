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
if (file_exists(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat')){

switch ($act):
############################################################################################
##                                    Вывод всех сообщений                                ##
############################################################################################
case "index":

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

		echo '<a href="#down"><img src="/images/img/downs.gif" alt="image" /></a> ';
		echo '<a href="index.php">Форум</a> / ';
		echo '<a href="forum.php?fid='.$fid.'">'.$forum[1].'</a> / ';
		echo '<a href="forum.php?act=new&amp;fid='.$fid.'">Новая тема</a>';


		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {

			$config['newtitle'] = $topic[3];

			$total = counter_string(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat');
			echo '<br /><br /><img src="/images/img/themes.gif" alt="image" /> <b>'.$topic[3].'</b> ('.$total.' пост.)<hr />';

			if (is_admin()){
				$lock = (empty($topic[5])) ? 'Закрепить' : 'Открепить';
				echo '<a href="'.ADMINDIR.'forum.php?act=lockedtopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'">'.$lock.'</a> / ';


				$close = (empty($topic[6])) ? 'Закрыть' : 'Открыть';
				echo '<a href="'.ADMINDIR.'forum.php?act=closedtopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'">'.$close.'</a> / ';

				echo '<a href="'.ADMINDIR.'forum.php?act=edittopic&amp;fid='.$fid.'&amp;id='.$id.'">Изменить</a> / ';
				echo '<a href="'.ADMINDIR.'forum.php?act=deltopic&amp;del='.$id.'&amp;fid='.$fid.'&amp;uid='.$_SESSION['token'].'" onclick="return confirm(\'Вы действительно хотите удалить тему?\')">Удалить</a> / ';
				echo '<a href="'.ADMINDIR.'forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'">Управление</a>';
			}

			if ($total>0) {
				$file = file(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat');

				if ($start < 0 || $start >= $total){$start = 0;}
				if ($total < $start + $config['forumpost']){ $end = $total; }
				else {$end = $start + $config['forumpost']; }
				for ($i = $start; $i < $end; $i++){

					$data = explode("|", $file[$i]);

					echo '<div class="b">';
					echo user_avatars($data[2]).' <b><a href="/pages/anketa.php?uz='.$data[2].'">'.nickname($data[2]).'</a></b> ';
					echo user_title($data[2]).user_online($data[2]);
					echo ' <small>('.date_fixed($data[5]).')</small></div>';
					echo '<div>'.bb_code($data[3]).'<br />';
					echo '<span class="data">('.$data[4].')</span>';
					echo '</div>';
				}

				page_strnavigation('topic.php?fid='.$fid.'&amp;id='.$id.'&amp;', $config['forumpost'], $start, $total);

			} else {show_error('Тема пустая! Сообщений еще нет!');}

			// Форма для добавления сообщений
			if (empty($topic[6])){
				if (is_user()){

					echo '<div class="form" id="form">';
					echo '<form action="topic.php?act=add&amp;fid='.$fid.'&amp;id='.$id.'&amp;uid='.$_SESSION['token'].'" method="post">';
					echo 'Сообщение:<br />';
					echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
					echo '<input type="submit" value="Написать" /></form></div><br />';

				} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}
			} else {show_error('Данная тема закрыта для обсуждения!');}

			echo '<a href="#up"><img src="/images/img/ups.gif" alt="image" /></a> ';
			echo '<a href="/pages/pravila.php">Правила</a> / ';
			echo '<a href="/pages/smiles.php">Смайлы</a> / ';
			echo '<a href="/pages/tegi.php">Теги</a><br /><br />';

		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}
	echo '<img src="/images/img/back.gif" alt="image" /> <a href="forum.php?fid='.$fid.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Добавление сообщения                                ##
############################################################################################
case "add":
	$config['newtitle'] = 'Добавление сообщения';

	$uid = check($_GET['uid']);
	$msg = check($_POST['msg']);

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {
		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {
		if (is_user()) {
		if ($uid==$_SESSION['token']){

			if (empty($topic[6])){

				if (is_flood($log)) {
				if (is_quarantine($log)) {
				if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<=5000){

					statistics(2);

					$msg = no_br($msg, '<br />');
					$msg = antimat($msg);
					$msg = smiles($msg);

					$text = $id.'|'.$fid.'|'.$log.'|'.$msg.'|'.$brow.', '.$ip.'|'.SITETIME.'|';

					// Запись сообщения
					write_files(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat', "$text\r\n", 0, 0666);

					// Поднятие темы в списке
					shift_lines(DATADIR."dataforum/topic$fid.dat", $topic['line']);

					// Обновление mainforum
					$maintext = $forum[0].'|'.$forum[1].'|'.$forum[2].'|'.($forum[3]+1).'|';
					replace_lines(DATADIR."dataforum/mainforum.dat", $forum['line'], $maintext);

					change_profil($log, array(8=>$udata[8]+1, 14=>$ip, 36=>$udata[36]+1, 41=>$udata[41]+1));

					$_SESSION['note'] = 'Сообщение успешно добавлено!';
					redirect("topic.php?act=end&fid=$fid&id=$id");

				} else {show_error('Слишком длинный или короткий текст сообщения (Необходимо от 5 до 3000 символов)');}
				} else {show_error('Карантин! Вы не можете писать в течении '.round($config['karantin'] / 3600).' часов!');}
				} else {show_error('Антифлуд! Разрешается отправлять сообщения раз в '.flood_period().' секунд!');}
			} else {show_error('Ошибка! Данная тема закрыта для обсуждения!');}

		} else {
			show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
		}
		} else {
			show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');
		}
		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}

	echo '<img src="/images/img/back.gif" alt="image" /> <a href="topic.php?fid='.$fid.'&amp;id='.$id.'">Вернуться</a><br />';
break;

############################################################################################
##                                Переход к последней странице                            ##
############################################################################################
case "end":
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {
		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {
			$totpage = counter_string(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat');
			$lastpage = ceil($totpage/$config['forumpost']) * $config['forumpost'] - $config['forumpost'];

			redirect("topic.php?fid=$fid&id=$id&start=$lastpage");

		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}

	echo '<img src="/images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a><br />';
break;

default:
redirect("index.php");
endswitch;

} else {show_error('Данной темы не существует, возможно она была удалена!');}
} else {show_error('Разделы форума еще не созданы!');}

echo '<img src="/images/img/homepage.gif" alt="image" /> <a href="/index.php">На главную</a><br />';

include_once ('../themes/'.$config['themes'].'/foot.php');
?>
