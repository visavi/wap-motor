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

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;
$fid = (isset($_GET['fid'])) ? abs(intval($_GET['fid'])) : 0;
$id = (isset($_GET['id'])) ? abs(intval($_GET['id'])) : 0;

if (is_admin()){

show_title('menu.gif', 'Форум '.$config['title']);

switch ($act):
############################################################################################
##                                 Вывод перечня категорий                                ##
############################################################################################
case "index":
if (file_exists(DATADIR."dataforum/mainforum.dat")) {
	$fileforum = file(DATADIR."dataforum/mainforum.dat");
	$total = count($fileforum);

	if ($total>0) {

	foreach($fileforum as $key=>$forumval){
		$forum = explode("|", $forumval);

		echo '<div class="b"><img src="../images/img/forums.gif" alt="image" /> ';
		echo '<b><a href="forum.php?act=forum&amp;fid='.$forum[0].'&amp;'.SID.'">'.$forum[1].'</a></b> ('.$forum[2].'/'.$forum[3].')';

		if (is_admin(array(101,102))){
			echo '<br />';
			if ($key != 0){echo '<a href="forum.php?act=move&amp;fid='.$forum[0].'&amp;where=0&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Вверх</a> / ';} else {echo 'Вверх / ';}
			if ($total > ($key+1)){echo '<a href="forum.php?act=move&amp;fid='.$forum[0].'&amp;where=1&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Вниз</a>';} else {echo 'Вниз';}
			echo ' / <a href="forum.php?act=editforum&amp;fid='.$forum[0].'&amp;'.SID.'">Редактировать</a>';
			if (is_admin(array(101))){
				echo ' / <a href="forum.php?act=delforum&amp;fid='.$forum[0].'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" onclick="return confirm(\'Вы действительно хотите удалить раздел?\')">Удалить</a>';
			}
		}
		echo '</div>';

		$totalforum = counter_string(DATADIR."dataforum/topic".$forum[0].".dat");

		if($totalforum>0){
			$filetopic = file(DATADIR."dataforum/topic".$forum[0].".dat");
			$topic = explode("|", end($filetopic));

			if (file_exists(DATADIR.'dataforum/'.$forum[0].'-'.$topic[0].'.dat')) {
				$filepost = file(DATADIR.'dataforum/'.$forum[0].'-'.$topic[0].'.dat');
				$post = explode("|", end($filepost));

				if (utf_strlen($topic[3])>35) {$topic[3]=utf_substr($topic[3], 0, 30); $topic[3].="...";}

				echo '<div>Тема: <a href="forum.php?act=end&amp;fid='.$forum[0].'&amp;id='.$topic[0].'&amp;'.SID.'">'.$topic[3].'</a><br />';
				echo 'Сообщение: '.nickname($post[2]).' ('.date_fixed($post[6]).')</div>';

			} else {echo 'Последняя тема не найдена!';}
		} else {echo 'Раздел пустой! Темы еще не созданы!';}
	}

	echo '<br /><br />Всего разделов: <b>'.$total.'</b><br />';

	} else {show_error('Форум пустой! Разделы еще не созданы!');}
} else {show_error('Форум пустой! Разделы еще не созданы!');}

if (is_admin(array(101))){
	echo '<br /><div class="form">';
	echo '<form action="forum.php?act=addforum&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
	echo 'Заголовок:<br />';
	echo '<input type="text" name="title" size="50" maxlength="50" /><br />';
	echo '<input value="Создать раздел" type="submit" /></form></div><br />';

	echo '<img src="../images/img/reload.gif" alt="image" /> <a href="forum.php?act=recount&amp;'.SID.'">Пересчитать</a><br />';
}
break;

############################################################################################
##                                      Список тем                                        ##
############################################################################################
case "forum":

$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
if ($forum) {

	$total = counter_string(DATADIR."dataforum/topic$fid.dat");

	echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
	echo '<a href="forum.php?'.SID.'">Форум</a> / ';
	echo '<a href="../forum/forum.php?act=new&amp;fid='.$fid.'&amp;'.SID.'">Новая тема</a> / ';
	echo '<a href="../forum/forum.php?&amp;fid='.$fid.'&amp;start='.$start.'&amp;'.SID.'">Обзор</a><br /><br />';


	echo '<img src="../images/img/themes.gif" alt="image" /> <b>'.$forum[1].'</b> ('.$total.' тем.)<hr />';

	if ($total>0) {
		$files = file(DATADIR."dataforum/topic$fid.dat");
		$files = array_reverse($files);

		// Выводим сперва закрепленные темы
		$fixed = array();
		foreach ($files as $key=>$value){
			$data = explode("|", $value);
			if (!empty($data[5])){
				unset($files[$key]);
				$fixed[] = $value;
			}
		}
		$files = array_merge($fixed, $files);
		//-------------------------------//

		echo '<form action="forum.php?act=deltopic&amp;fid='.$fid.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

		echo '<div class="form">';
		echo '<input type="checkbox" id="all" onchange="var o=this.form.elements;for(var i=0;i&lt;o.length;i++)o[i].checked=this.checked" /> <b><label for="all">Отметить все</label></b>';
		echo '</div>';

		if ($start < 0 || $start >= $total){$start = 0;}
		if ($total < $start + $config['forumtem']){ $end = $total; }
		else {$end = $start + $config['forumtem']; }
		for ($i = $start; $i < $end; $i++){

			$data = explode("|", $files[$i]);

			if ($data[5] == 1) {
				$icon = 'lock.gif';
			} elseif($data[6] == 1) {
				$icon = 'zakr.gif';
			} else {
				$icon = 'forums.gif';
			}

			$totalpost = counter_string(DATADIR.'dataforum/'.$fid.'-'.$data[0].'.dat');

			echo '<div class="b"><img src="../images/img/'.$icon.'" alt="image" /> ';
			echo '<b><a href="forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$data[0].'&amp;'.SID.'">'.$data[3].'</a></b> ('.$totalpost.')<br />';

			echo '<input type="checkbox" name="del[]" value="'.$data[0].'" /> ';
			echo '<a href="forum.php?act=edittopic&amp;fid='.$fid.'&amp;id='.$data[0].'&amp;start='.$start.'&amp;'.SID.'">Редактировать</a>';
			echo '</div>';

			if($totalpost>0){
				$filepost = file(DATADIR.'dataforum/'.$fid.'-'.$data[0].'.dat');
				$datapost = explode("|", end($filepost));

				$lastpage = ceil($totalpost/$config['forumpost']) * $config['forumpost'] - $config['forumpost'];

				echo '<div>Страницы: ';
				forum_navigation('topic.php?fid='.$datapost[1].'&amp;id='.$datapost[0].'&amp;', $config['forumpost'], $totalpost);

				echo 'Сообщение: '.nickname($datapost[2]).' ('.date_fixed($datapost[6]).')</div>';

			} else {echo 'Тема пустая! Сообщений еще нет!';}
		}

		echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

		page_strnavigation('forum.php?act=forum&amp;fid='.$fid.'&amp;', $config['forumtem'], $start, $total);

	} else {show_error('Раздел пустой! Темы еще не созданы!');}
} else {show_error('Ошибка! Данного раздела не существует!');}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                      Список постов                                     ##
############################################################################################
case "topic":

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

		echo '<a href="#down"><img src="../images/img/downs.gif" alt="image" /></a> ';
		echo '<a href="forum.php?'.SID.'">Форум</a> / ';
		echo '<a href="forum.php?act=forum&amp;fid='.$fid.'&amp;'.SID.'">'.$forum[1].'</a> / ';
		echo '<a href="../forum/forum.php?act=new&amp;fid='.$fid.'&amp;'.SID.'">Новая тема</a>';

		$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
		if ($topic) {

			$total = counter_string(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat');
			echo '<br /><br /><img src="../images/img/themes.gif" alt="image" /> <b>'.$topic[3].'</b> ('.$total.' пост.)<hr />';

			$lock = (empty($topic[5])) ? 'Закрепить' : 'Открепить';
			echo '<a href="forum.php?act=lockedtopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">'.$lock.'</a> / ';


			$close = (empty($topic[6])) ? 'Закрыть' : 'Открыть';
			echo '<a href="forum.php?act=closedtopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">'.$close.'</a> / ';

			echo '<a href="forum.php?act=edittopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;'.SID.'">Изменить</a> / ';
			echo '<a href="forum.php?act=deltopic&amp;del='.$id.'&amp;fid='.$fid.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" onclick="return confirm(\'Вы действительно хотите удалить тему?\')">Удалить</a> / ';
			echo '<a href="../forum/topic.php?fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Обзор</a>';

			echo '<form action="forum.php?act=delpost&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';

			echo '<div class="form">';
			echo '<input type="checkbox" id="all" onchange="var o=this.form.elements;for(var i=0;i&lt;o.length;i++)o[i].checked=this.checked" /> <b><label for="all">Отметить все</label></b>';
			echo '</div>';

			if ($total>0) {
				$file = file(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat');

				if ($start < 0 || $start >= $total){$start = 0;}
				if ($total < $start + $config['forumpost']){ $end = $total; }
				else {$end = $start + $config['forumpost']; }
				for ($i = $start; $i < $end; $i++){

					$data = explode("|", $file[$i]);

					echo '<div class="b">';
					echo user_avatars($data[2]).' <b><a href="../pages/anketa.php?uz='.$data[2].'&amp;'.SID.'">'.nickname($data[2]).'</a></b> ';
					echo user_title($data[2]).user_online($data[2]);
					echo ' <small>('.date_fixed($data[5]).')</small><br />';
					echo '<input type="checkbox" name="del[]" value="'.$i.'" /> ';
					echo '<a href="forum.php?act=editpost&amp;fid='.$fid.'&amp;id='.$data[0].'&amp;post='.$i.'&amp;start='.$start.'&amp;'.SID.'">Редактировать</a>';
					echo '</div>';
					echo '<div>'.bb_code($data[3]).'<br />';
					echo '<span class="data">('.$data[4].')</span>';
					echo '</div>';
				}

				echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

				page_strnavigation('forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;', $config['forumpost'], $start, $total);

			} else {show_error('Тема пустая! Сообщений еще нет!');}

			// Форма для добавления сообщений
			if (empty($topic[6])){
				if (is_user()){

					echo '<div class="form" id="form">';
					echo '<form action="../forum/topic.php?act=add&amp;fid='.$fid.'&amp;id='.$id.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
					echo 'Сообщение:<br />';
					echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
					echo '<input type="submit" value="Написать" /></form></div><br />';

				} else {show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');}
			} else {show_error('Данная тема закрыта для обсуждения!');}

			echo '<a href="#up"><img src="../images/img/ups.gif" alt="image" /></a> ';
			echo '<a href="../pages/pravila.php?'.SID.'">Правила</a> / ';
			echo '<a href="../pages/smiles.php?'.SID.'">Смайлы</a> / ';
			echo '<a href="../pages/tegi.php?'.SID.'">Теги</a><br /><br />';

		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=forum&amp;fid='.$fid.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                   Пересчет разделов                                    ##
############################################################################################
case "recount":
if (file_exists(DATADIR."dataforum/mainforum.dat")) {
	$fileforum = file(DATADIR."dataforum/mainforum.dat");

	if (count($fileforum)>0){
		foreach($fileforum as $key=>$forumval){
			$forum = explode("|", $forumval);

			$totaltopic = 0;
			$totalpost = 0;

			if (file_exists(DATADIR.'dataforum/topic'.$forum[0].'.dat')){
				$filetopic = file(DATADIR.'dataforum/topic'.$forum[0].'.dat');
				$totaltopic = count($filetopic);

				foreach($filetopic as $topicval){
					$topic = explode("|", $topicval);
					$totalpost += counter_string(DATADIR.'dataforum/'.$forum[0].'-'.$topic[0].'.dat');
				}
			}

			// Обновление mainforum
			$maintext = $forum[0].'|'.$forum[1].'|'.$totaltopic.'|'.$totalpost.'|';
			replace_lines(DATADIR."dataforum/mainforum.dat", $key, $maintext);
		}
		// Данные форума успешно пересчитаны!
		header ("Location: forum.php?".SID); exit;

	} else {show_error('Форум пустой! Разделы еще не созданы!');}
} else {show_error('Форум пустой! Разделы еще не созданы!');}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                     Сдвиг разделов                                     ##
############################################################################################
case "move":
$uid = check($_GET['uid']);
$where = (isset($_GET['where'])) ? abs(intval($_GET['where'])) : null;

if (is_admin(array(101,102))){
	if ($uid==$_SESSION['token']){
		$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
		if ($forum) {
			if (!is_null($where)){

				move_lines(DATADIR."dataforum/mainforum.dat", $forum['line'], $where);

				header ("Location: forum.php?isset=mp_moveboard&".SID); exit;

			} else {echo show_error('Ошибка! Не выбрано действие для сдвига!');}
		} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {echo show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}
} else {echo show_error('Ошибка! Двигать рубрики могут только администраторы!');}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                Редактирование форумов                                  ##
############################################################################################
case "editforum":
	if (is_admin(array(101,102))){
		$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
		if ($forum) {

			echo '<div class="form">';
			echo '<form action="forum.php?act=changeforum&amp;fid='.$fid.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
			echo 'Заголовок:<br />';
			echo '<input type="text" name="title" size="50" maxlength="50" value="'.$forum[1].'" /><br />';
			echo 'Кол. тем:<br />';
			echo '<input type="text" name="themes" size="10" value="'.$forum[2].'" /><br />';
			echo 'Кол. постов:<br />';
			echo '<input type="text" name="posts" size="10" value="'.$forum[3].'" /><br />';
			echo '<input value="Изменить" type="submit" /></form></div><br />';

		} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Доступ разрешен только админам!');}
	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Изменение форумов                                   ##
############################################################################################
case "changeforum":
	$uid = check($_GET['uid']);
	$title = check($_POST['title']);
	$themes = abs(intval($_POST['themes']));
	$posts = abs(intval($_POST['posts']));

	if ($uid==$_SESSION['token']){
	if (is_admin(array(101,102))){
		$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
		if ($forum) {

			if (utf_strlen(trim($title))>=5 && utf_strlen($title)<=50){

				$maintext = $forum[0].'|'.$title.'|'.$themes.'|'.$posts.'|';
				replace_lines(DATADIR."dataforum/mainforum.dat", $forum['line'], $maintext);

				header ("Location: forum.php?isset=mp_editrazdel&".SID); exit;

			} else {show_error('Слишком длинный или короткий заголовок (Необходимо от 5 до 50 символов)');}
		} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Доступ разрешен только админам!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=editforum&amp;fid='.$fid.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Удаление форумов                                    ##
############################################################################################
case "delforum":
	$uid = check($_GET['uid']);

	if ($uid==$_SESSION['token']){
	if (is_admin(array(101))){
		$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
		if ($forum) {

			// Удаление всех тем в топике
			$file = file(DATADIR."dataforum/topic$fid.dat");
			if (count($file)>0){
				foreach ($file as $data) {
					$data = explode("|", $data);
					if (file_exists(DATADIR.'dataforum/'.$fid.'-'.$data[0].'.dat')){
						unlink(DATADIR.'dataforum/'.$fid.'-'.$data[0].'.dat');
					}
				}
			}

			// Удаление файла топика
			if (file_exists(DATADIR."dataforum/topic$fid.dat")){
				unlink(DATADIR."dataforum/topic$fid.dat");
			}

			// Удаление раздела форума
			delete_lines(DATADIR."dataforum/mainforum.dat", $forum['line']);

			header ("Location: forum.php?isset=mp_delforums&".SID); exit;

		} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Доступ разрешен только суперадминам!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                     Создание форумов                                   ##
############################################################################################
case "addforum":
	$uid = check($_GET['uid']);
	$title = check($_POST['title']);

	if ($uid==$_SESSION['token']){
	if (is_admin(array(101))){

		if (utf_strlen(trim($title))>=5 && utf_strlen($title)<=50){

			$id = unifile(DATADIR."dataforum/mainforum.dat", 0);

			$maintext = $id.'|'.$title.'|0|0|';
			write_files(DATADIR."dataforum/mainforum.dat", "$maintext\r\n", 0, 0666);

			header ("Location: forum.php?isset=mp_addforums&".SID); exit;

		} else {show_error('Слишком длинный или короткий заголовок (Необходимо от 5 до 50 символов)');}
	} else {show_error('Ошибка! Доступ разрешен только суперадминам!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

//------------------------------------- Темы форума --------------------------------------//

############################################################################################
##                                      Удаление тем                                      ##
############################################################################################
case "deltopic":

	$uid = check($_GET['uid']);

	if (isset($_POST['del'])) {
		$del = intar($_POST['del']);
	} elseif (isset($_GET['del'])) {
		$del = array(abs(intval($_GET['del'])));
	} else {
		$del = 0;
	}

	if ($uid==$_SESSION['token']){
		$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
		if ($forum) {

			if (!empty($del)){
				$delete = array();

				foreach ($del as $val){

					$topic = search_string(DATADIR."dataforum/topic$fid.dat", $val, 0);
					if ($topic) {

						// Удаление файла темы
						if (file_exists(DATADIR.'dataforum/'.$fid.'-'.$topic[0].'.dat')) {
							unlink (DATADIR.'dataforum/'.$fid.'-'.$topic[0].'.dat');
						}

						$delete[] = $topic['line'];
					}
				}

				// Удаление записи в темах
				delete_lines(DATADIR."dataforum/topic$fid.dat", $delete);

				header ("Location: forum.php?act=forum&fid=$fid&start=$start&isset=mp_delthemes&".SID); exit;

			} else {show_error('Ошибка! Не выбраны темы для удаления!');}
		} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=forum&amp;fid='.$fid.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Редактирование тем                                  ##
############################################################################################
case "edittopic":

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

		echo '<div class="form">';
		echo '<form action="forum.php?act=changetopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
		echo 'Заголовок:<br />';
		echo '<input type="text" name="title" size="50" maxlength="50" value="'.$topic[3].'" /><br />';

		echo 'Автор темы:<br />';
		echo '<input type="text" name="author" size="20" maxlength="20" value="'.$topic[2].'" /><br />';

		echo 'Закрепить тему: ';
		$checked = ($topic[5] == 1) ? ' checked="checked"' : '';
		echo '<input name="locked" type="checkbox" value="1"'.$checked.' /><br />';

		echo 'Закрыть тему: ';
		$checked = ($topic[6] == 1) ? ' checked="checked"' : '';
		echo '<input name="closed" type="checkbox" value="1"'.$checked.' /><br />';

		echo '<input value="Изменить тему" type="submit" /></form></div><br />';

	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=forum&amp;fid='.$fid.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                       Изменение тем                                    ##
############################################################################################
case "changetopic":
	$uid = check($_GET['uid']);
	$title = check($_POST['title']);
	$author = check($_POST['author']);
	$locked = (empty($_POST['locked'])) ? 0 : 1;
	$closed = (empty($_POST['closed'])) ? 0 : 1;

	if ($uid==$_SESSION['token']){
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

		if (check_user($author)){
		if (utf_strlen(trim($title))>=5 && utf_strlen($title)<=50){

			$topictext = $topic[0].'|'.$topic[1].'|'.$author.'|'.$title.'|'.$topic[4].'|'.$locked.'|'.$closed.'|';
			replace_lines(DATADIR."dataforum/topic$fid.dat", $topic['line'], $topictext);

			// тема успешно изменена
			header ("Location: forum.php?act=forum&fid=$fid&start=$start&".SID); exit;

		} else {show_error('Слишком длинный или короткий заголовок (Необходимо от 5 до 50 символов)');}
		} else {show_error('Аккаунт пользователя '.$author.' не найден!');}

	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=edittopic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Закрытие тем                                        ##
############################################################################################
case "closedtopic":
	$uid = check($_GET['uid']);

	if ($uid==$_SESSION['token']){
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

		$closed = (empty($topic[6])) ? 1 : 0;

		$topictext = $topic[0].'|'.$topic[1].'|'.$topic[2].'|'.$topic[3].'|'.$topic[4].'|'.$topic[5].'|'.$closed.'|';
		replace_lines(DATADIR."dataforum/topic$fid.dat", $topic['line'], $topictext);

		// тема успешно изменена
		header ("Location: forum.php?act=topic&fid=$fid&id=$id&start=$start&".SID); exit;

	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;'.SID.'">Вернуться</a><br />';
break;


############################################################################################
##                                   Закепление тем                                       ##
############################################################################################
case "lockedtopic":
	$uid = check($_GET['uid']);

	if ($uid==$_SESSION['token']){
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

		$locked = (empty($topic[5])) ? 1 : 0;

		$topictext = $topic[0].'|'.$topic[1].'|'.$topic[2].'|'.$topic[3].'|'.$topic[4].'|'.$locked.'|'.$topic[6].'|';
		replace_lines(DATADIR."dataforum/topic$fid.dat", $topic['line'], $topictext);

		// тема успешно изменена
		header ("Location: forum.php?act=topic&fid=$fid&id=$id&start=$start&".SID); exit;

	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;'.SID.'">Вернуться</a><br />';
break;

//--------------------------------- Сообщения форума -------------------------------------//

############################################################################################
##                                     Удаление постов                                    ##
############################################################################################
case "delpost":
	$uid = check($_GET['uid']);
	$del = (isset($_POST['del'])) ? intar($_POST['del']) : null;

	if ($uid==$_SESSION['token']){
	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

		if (!is_null($del)) {

			delete_lines(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat', $del);

			// Выбранные сообщения успешно удалены!
			header ("Location: forum.php?act=topic&fid=$fid&id=$id&start=$start&".SID); exit;

		} else {show_error('Ошибка! Не выбраны сообщения для удаления!');}
	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
break;


############################################################################################
##                                  Редактирование постов                                 ##
############################################################################################
case "editpost":

	$post = (isset($_GET['post'])) ? abs(intval($_GET['post'])) : null;

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

	$data = read_string(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat', $post);
	if ($data){

		echo '<div class="form" id="form">';
		echo '<form action="forum.php?act=changepost&amp;fid='.$fid.'&amp;id='.$id.'&amp;post='.$post.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" method="post">';
		echo 'Автор:<br />';
		echo '<input type="text" name="author" size="20" maxlength="20" value="'.$data[2].'" /><br />';
		echo 'Сообщение:<br />';
		echo '<textarea cols="25" rows="3" name="msg">'.$data[3].'</textarea><br />';
		echo '<input type="submit" value="Изменить" /></form></div><br />';

	} else {show_error('Ошибка! Данное сообщение не найдено!');}
	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}

echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;start='.$start.'&amp;'.SID.'">Вернуться</a><br />';
break;


############################################################################################
##                                  Редактирование постов                                 ##
############################################################################################
case "changepost":

	$post = (isset($_GET['post'])) ? abs(intval($_GET['post'])) : null;
	$msg = check($_POST['msg']);
	$author = check($_POST['author']);

	$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
	if ($forum) {

	$topic = search_string(DATADIR."dataforum/topic$fid.dat", $id, 0);
	if ($topic) {

	$data = read_string(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat', $post);
	if ($data){

		if (check_user($author)){
		if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<=5000){

			$posttext = $data[0].'|'.$data[1].'|'.$author.'|'.$msg.'|'.$data[4].'|'.$data[5].'|';
			replace_lines(DATADIR.'dataforum/'.$fid.'-'.$id.'.dat', $post, $posttext);

			// Сообщение успешно изменено
			header ("Location: forum.php?act=topic&fid=$fid&id=$id&start=$start&".SID); exit;

		} else {show_error('Слишком длинный или короткий текст сообщения (Необходимо от 5 до 5000 символов)');}
		} else {show_error('Аккаунт пользователя '.$author.' не найден!');}

	} else {show_error('Ошибка! Данное сообщение не найдено!');}
	} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данный раздел форума не найден!');}
echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=editpost&amp;fid='.$fid.'&amp;id='.$id.'&amp;post='.$post.'&amp;start='.$start.'&amp;'.SID.'">Редактировать</a><br />';
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

			header ("Location: forum.php?act=topic&fid=$fid&id=$id&start=$lastpage&".SID); exit;

		} else {show_error('Ошибка! Данной темы не существует!');}
	} else {show_error('Ошибка! Данного раздела не существует!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?'.SID.'">Вернуться</a><br />';
break;

default:
header("location: forum.php?".SID); exit;
endswitch;

//----------------------- Концовка -------------------------//
echo '<img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
