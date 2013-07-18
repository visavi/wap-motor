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
	$lines = file(DATADIR."dataforum/mainforum.dat");
	$total = count($lines);

	if ($total>0) {

	foreach($lines as $key=>$forumval){
		$data = explode("|", $forumval);

		echo '<div class="b"><img src="../images/img/forums.gif" alt="image" /> ';
		echo '<b><a href="forum.php?fid='.$data[0].'&amp;'.SID.'">'.$data[1].'</a></b> ('.$data[2].'/'.$data[3].')';

		if (is_admin(array(101,102))){
			echo '<br />';
			if ($key != 0){echo '<a href="forum.php?act=move&amp;fid='.$data[0].'&amp;where=0&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Вверх</a> | ';} else {echo 'Вверх | ';}
			if ($total > ($key+1)){echo '<a href="forum.php?act=move&amp;fid='.$data[0].'&amp;where=1&amp;uid='.$_SESSION['token'].'&amp;'.SID.'">Вниз</a>';} else {echo 'Вниз';}
			echo ' | <a href="forum.php?act=editforum&amp;fid='.$data[0].'&amp;'.SID.'">Редактировать</a>';
			if (is_admin(array(101))){
				echo ' | <a href="forum.php?act=delforum&amp;fid='.$data[0].'&amp;uid='.$_SESSION['token'].'&amp;'.SID.'" onclick="return confirm(\'Вы действительно хотите удалить раздел?\')">Удалить</a>';
			}
		}
		echo '</div>';

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

	if ($uid==$_SESSION['token']){
	if (is_admin(array(101,102))){
		$forum = search_string(DATADIR."dataforum/mainforum.dat", $fid, 0);
		if ($forum) {

			$title = check($_POST['title']);

			if (utf_strlen(trim($title))>=5 && utf_strlen($title)<=50){

				$maintext = $forum[0].'|'.$title.'|'.$forum[2].'|'.$forum[3].'|';
				replace_lines(DATADIR."dataforum/mainforum.dat", $forum['line'], $maintext);

				header ("Location: forum.php?isset=mp_editrazdel&".SID); exit;

			} else {show_error('Слишком длинный или короткий заголовок (Необходимо от 5 до 50 символов)');}
		} else {show_error('Ошибка! Данный раздел форума не найден!');}
	} else {show_error('Ошибка! Доступ разрешен только админам!');}
	} else {show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');}

	echo '<img src="../images/img/back.gif" alt="image" /> <a href="forum.php?act=editforum&amp;fid='.$fid.'&amp;'.SID.'">Вернуться</a><br />';
break;

############################################################################################
##                                    Удаление  форумов                                   ##
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
					if (file_exists(DATADIR.'dataforum/'.$data[0].'.dat')){
						unlink(DATADIR.'dataforum/'.$data[0].'.dat');
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

default:
header("location: forum.php?".SID); exit;
endswitch;


//----------------------- Концовка -------------------------//
echo '<img src="../images/img/panel.gif" alt="image" /> <a href="index.php?'.SID.'">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404&".SID); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
