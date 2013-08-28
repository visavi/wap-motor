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

$minfind = 3; // Минимальное кол-во символов в слове для поиска
$maxfind = 25; // Максимальное кол-во символов в слове для поиска

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;

show_title('bsearch.gif', 'Поиск по форуму');

switch ($act):
############################################################################################
##                                    Вывод всех сообщений                                ##
############################################################################################
case "index":
	echo '<div class="form">';
	echo '<form action="search.php?act=search&amp;'.SID.'" method="get">';
	echo '<input type="hidden" name="act" value="search" />';

	echo '<b>Запрос:</b><br /><input type="text" name="find" /><br /><br />';

	echo '<b>Искать:</b><br />';
	echo '<input name="where" type="radio" value="1" checked="checked" /> В темах<br />';
	echo '<input name="where" type="radio" value="2" /> В сообщениях<br /><br />';

	echo '<b>Тип запроса:</b><br />';
	echo '<input name="type" type="radio" value="1" checked="checked" /> Или<br />';
	echo '<input name="type" type="radio" value="2" /> И<br />';

	echo '<br /><input type="submit" value="Поиск" /></form></div><br />';

break;

############################################################################################
##                                          Поиск                                         ##
############################################################################################
case 'search':

	$find = (isset($_REQUEST['find'])) ? check($_REQUEST['find']) : '';
	$type = (isset($_REQUEST['type'])) ? abs(intval($_REQUEST['type'])) : 1;
	$where = (isset($_REQUEST['where'])) ? abs(intval($_REQUEST['where'])) : 1;

	if (!is_utf($find)){
		$find = win_to_utf($find);
	}


	if (utf_strlen($find) >= $minfind && utf_strlen($find) <= $maxfind) {

		$config['newtitle'] = $find.' - Результаты поиска';

	//-------------------------- Поиск в темах ----------------------------------//
	if ($where == 1){
		echo 'Поиск запроса <b>&quot;'.$find.'&quot;</b> в темах<br />';

		// Индексирование всех тем на сутки
		if (@filemtime(DATADIR."datatmp/forumtopics.dat") < time() - 3600 * 24) {
			$filetopics = glob(DATADIR.'dataforum/topic*.dat');

			if (is_array($filetopics)) {
				$arrtopics = array();
				foreach ($filetopics as $topic){
					$arrtopics[] = file_get_contents($topic);
				}
				file_put_contents(DATADIR."datatmp/forumtopics.dat", $arrtopics, LOCK_EX);
			}
		}

		$filetopics = file(DATADIR."datatmp/forumtopics.dat");
		$topics = array();

		// Поиск любого слова
		if ($type == 1){
			foreach ($filetopics as $cachetopics){
				$cachedata = explode('|', $cachetopics);

				if (utf_stristr($cachedata[3], $find)){
					$topics[] = $cachetopics;
				}
			}
		}

		// Поиск всех слов
		if ($type == 2){

		}


		$total = count($topics);
		if ($total > 0) {
			echo 'Найдено совпадений: <b>'.$total.'</b><br /><br />';

			if ($start < 0 || $start >= $total){$start = 0;}
			if ($total < $start + $config['forumtem']){ $end = $total; }
			else {$end = $start + $config['forumtem']; }
			for ($i = $start; $i < $end; $i++){

				$data = explode("|", $topics[$i]);

				if ($data[5] == 1) {
					$icon = 'lock.gif';
				} elseif($data[6] == 1) {
					$icon = 'zakr.gif';
				} else {
					$icon = 'forums.gif';
				}

				$totalpost = counter_string(DATADIR.'dataforum/'.$data[1].'-'.$data[0].'.dat');

				echo '<div class="b"><img src="/images/img/'.$icon.'" alt="image" /> ';
				echo '<b><a href="topic.php?fid='.$data[1].'&amp;id='.$data[0].'&amp;'.SID.'">'.$data[3].'</a></b> ('.$totalpost.')</div>';

				if($totalpost>0){
					$filepost = file(DATADIR.'dataforum/'.$data[1].'-'.$data[0].'.dat');
					$datapost = explode("|", end($filepost));

					$lastpage = ceil($totalpost/$config['forumpost']) * $config['forumpost'] - $config['forumpost'];

					echo '<div>Страницы: ';
					forum_navigation('topic.php?fid='.$datapost[1].'&amp;id='.$datapost[0].'&amp;', $config['forumpost'], $totalpost);

					echo 'Сообщение: '.nickname($datapost[2]).' ('.date_fixed($datapost[6]).')</div>';

					} else {echo 'Тема пустая! Сообщений еще нет!';}
			}

			page_strnavigation('search.php?act=search&amp;find='.$find.'&amp;type='.$type.'&amp;where='.$where.'&amp;', $config['forumtem'], $start, $total);

		} else {
			show_error('По вашему запросу ничего не найдено!');
		}
	}

	//------------------------- Поиск в сообщениях ------------------------------//
	if ($where == 2){
		echo 'Поиск запроса <b>&quot;'.$find.'&quot;</b> в сообщениях<br />';

		// Индексирование всех сообщений на сутки
		if (@filemtime(DATADIR."datatmp/forumposts.dat") < time() - 3600 * 24) {
			$fileposts = glob(DATADIR.'dataforum/*-*.dat');

			if (is_array($fileposts)) {
				$arrposts = array();
				foreach ($fileposts as $post){
					$arrposts[] = file_get_contents($post);
				}
				file_put_contents(DATADIR."datatmp/forumposts.dat", $arrposts, LOCK_EX);
			}
		}

		$fileposts = file(DATADIR."datatmp/forumposts.dat");

		$posts = array();
		foreach ($fileposts as $cacheposts){
			$cachedata = explode('|', $cacheposts);

			if (stristr($cachedata[3], $find)){
				$posts[] = $cacheposts;
			}
		}

		$total = count($posts);
		if ($total > 0) {
			echo 'Найдено совпадений: <b>'.$total.'</b><br /><br />';

			if ($start < 0 || $start >= $total){$start = 0;}
			if ($total < $start + $config['forumpost']){ $end = $total; }
			else {$end = $start + $config['forumpost']; }
			for ($i = $start; $i < $end; $i++){

				$data = explode("|", $posts[$i]);

				$topic = search_string(DATADIR."dataforum/topic".$data[1].".dat", $data[0], 0);
				if ($topic) {

					echo '<div class="b"><img src="/images/img/edit.gif" alt="image"> <b><a href="topic.php?fid='.$data[1].'&amp;id='.$data[0].'&amp;'.SID.'">'.$topic[3].'</a></b></div>';
					echo '<div>'.bb_code($data[3]).'<br />';
					echo 'Написал: <a href="/pages/anketa.php?uz='.$data[2].'&amp;'.SID.'">'.nickname($data[2]).'</a> '.user_online($data[2]).' ('.date_fixed($data[5]).')</div>';
				}
			}

			page_strnavigation('search.php?act=search&amp;find='.$find.'&amp;type='.$type.'&amp;where='.$where.'&amp;', $config['forumpost'], $start, $total);


		} else {
			show_error('По вашему запросу ничего не найдено!');
		}
	}

	} else {
		show_error('Ошибка! Запрос должен содержать от 3 до 50 символов!');
	}

	echo '<img src="/images/img/back.gif" alt="image"> <a href="search.php?'.SID.'">Вернуться</a><br />';
break;

default:
redirect("search.php?".SID);
endswitch;

/*

$findme=check(trim($findme));
$findmetol=rus_utf_tolower($findme);
$findmewords=explode(" ",$findmetol);
$wordsitogos=count($findmewords);
$findmeword = array();

for ($wi = 0; $wi < $wordsitogos; $wi++){
if(utf_strlen($findmewords[$wi])>=3){$findmeword[]=$findmewords[$wi];}
}
$wordsitogo=count($findmeword);

if ($findme!= "" && utf_strlen($findme) >= $minfindme && utf_strlen($findme)<$maxfindme) {


$fa = array();
$fb = array();

$dir = opendir (BASEDIR."local/dataforum");
while ($file = readdir ($dir)) {

if (ereg("^top", $file)) { $fa[]=$file; }

if (ereg ("\.dat$", $file) && !ereg("^top", $file)&& !ereg("^main", $file)) {
$fb[]=$file;
}}
closedir ($dir);

$fatotal = count($fa);
$fbtotal = count($fb);

$filtime=filemtime(BASEDIR."local/datatmp/forumthemes.dat");
$filtime=$filtime+(3600*12); //12-часовое индексирование

if($sitetime>=$filtime){

//-------------------- Запись тем ----------------------//
$dat_themes=array();
for ($i = 0; $i < $fatotal; $i++){
$tex = file(BASEDIR."local/dataforum/$fa[$i]");
$toptotal = count($tex);

for ($x = 0; $x < $toptotal; $x++){
$data = explode("|",$tex[$x]);
if($data[3]!="" && $data[7]!="" && $data[8]!=""){
$dat_themes[]='|'.$data[0].'|'.rus_utf_tolower($data[3]).'||'.$data[9].'|'.$data[7].'|'.$data[8].'|';
}}}

$dat_themes=implode("\r\n",$dat_themes);

if($dat_themes!=""){
$fp = fopen(BASEDIR."local/datatmp/forumthemes.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fputs($fp,"$dat_themes\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
chmod ($fp, 0666);
chmod (BASEDIR."local/datatmp/forumthemes.dat", 0666);
}


//-------------------- Запись сообщений ----------------------//
$dat_topic=array();
for ($i = 0; $i < $fbtotal; $i++){
$tex = file(BASEDIR."local/dataforum/$fb[$i]");
$toptotal = count($tex);

for ($x = 0; $x < $toptotal; $x++){
$data = explode("|",$tex[$x]);
if($data[3]!="" && $data[4]!="" && $data[7]!="" && $data[8]!=""){

$data[4]=strip_tags($data[4]);
$dat_topic[]='|'.$data[0].'|'.$data[3].'|'.rus_utf_tolower($data[4]).'||'.$data[9].'|'.$data[7].'|'.$data[8].'|'.$x.'|';
}}}

$dat_topic=implode("\r\n",$dat_topic);

if($dat_topic!=""){
$fp = fopen(BASEDIR."local/datatmp/forumtopic.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fputs($fp,"$dat_topic\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
chmod ($fp, 0666);
chmod (BASEDIR."local/datatmp/forumtopic.dat", 0666);
}
}


//----------------------Поиск в темах---------------------------------//
if($ftype==1){
$search_topic = file(BASEDIR."local/datatmp/forumthemes.dat");
$alltotal = count($search_topic);

//--------------------------- Ищем любое сходство --------------------------//
if($tip==1){

$array_themauthor=array();
$array_themout=array();
$array_themtime=array();
$array_themid=array();
$array_themfid=array();

for ($i = 0; $i < $alltotal; $i++){

$sdata = explode("|",$search_topic[$i]);

for ($wi = 0; $wi < $wordsitogo; $wi++){
$findmetols=$findmeword[$wi];

if (strstr($sdata[2],$findmetols)){

if (!in_array($sdata[2],$array_themout)){

$sdata[2]=preg_replace("/$findmetols/",'<font color="#FF0000">'.$findmetols.'</font>',$sdata[2],1);

$array_themauthor[]=$sdata[1];
$array_themout[]=$sdata[2];
$array_themtime[]=$sdata[4];
$array_themid[]=$sdata[5];
$array_themfid[]=$sdata[6];

}}}}}

//--------------------------- Ищем полное сходство --------------------------//
if($tip==2){

$array_themauthor=array();
$array_themout=array();
$array_themtime=array();
$array_themid=array();
$array_themfid=array();

for ($i = 0; $i < $alltotal; $i++){

$sdata = explode("|",$search_topic[$i]);

if (strstr($sdata[2],$findmetol)){

if (!in_array($sdata[2],$array_themout)){

$sdata[2]=preg_replace("/$findmetol/",'<font color="#FF0000">'.$findmetol.'</font>',$sdata[2],1);

$array_themauthor[]=$sdata[1];
$array_themout[]=$sdata[2];
$array_themtime[]=$sdata[4];
$array_themid[]=$sdata[5];
$array_themfid[]=$sdata[6];

}}}

}
$total=count($array_themout);

//------------------------------ Вывод найденного ----------------------------------//
if($total>0){
echo '<br />Поиск запроса <b>'.$findme.'</b> в темах<br />';
echo 'Найдено совпадений: <b>'.(int)$total.'</b><br /><br />';


$start = (int)$_GET['start'];
if($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config_searchforum){ $end = $total; }
else {$end = $start + $config_searchforum; }
for ($i = $start; $i < $end; $i++){


echo '<div class=b><img src="/images/img/forums.gif" alt=""> ';
echo '<b>'.($i+1).'. <a href="/pages/anketa.php?uz='.$array_themauthor[$i].'&amp;'.SID.'">'.nickname($array_themauthor[$i]).'</a></b> ';
echo '('.date_fixed($array_themtime[$i]).')</div>';
echo '<div><b><a href="index.php?fid='.$array_themfid[$i].'&amp;id='.$array_themid[$i].'&amp;'.SID.'">'.$array_themout[$i].'</a></b></div>';
}

echo '<hr />';
if ($start != 0) {echo '<a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.($start - $config_searchforum).'&amp;'.SID.'">&lt;-Назад </a>';}else{echo '&lt;-Назад';}
echo ' | ';
if ($total > $start + $config_searchforum) {echo ' <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.($start + $config_searchforum).'&amp;'.SID.'">Далее-&gt;</a>';}else{echo 'Далее-&gt;';}

if($total>0){

$ba=ceil($total/$config_searchforum);
$ba2=$ba*$config_searchforum-$config_searchforum;

echo '<br /><hr />Страницы:';
$asd=$start-($config_searchforum*3);
$asd2=$start+($config_searchforum*4);

if($asd<$total && $asd>0){echo ' <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start=0&amp;'.SID.'">1</a> ... ';}

for($i=$asd; $i<$asd2;){
if($i<$total && $i>=0){
$ii=floor(1+$i/$config_searchforum);

if ($start==$i) {
echo ' <b>('.$ii.')</b>';
} else {
echo ' <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.$i.'&amp;'.SID.'">'.$ii.'</a>';
}}

$i=$i+$config_searchforum;}
if($asd2<$total){echo ' ... <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.$ba2.'&amp;'.SID.'">'.$ba.'</a>';}
}
echo '<br /><br />';

}else{echo '<b>По вашему запросу ничего не найдено.</b><br /><br />';}

}


//----------------------Поиск в сообщениях---------------------------------//
if($ftype==2){
$search_topic = file(BASEDIR."local/datatmp/forumtopic.dat");
$alltotal = count($search_topic);

//--------------------------- Ищем любое сходство --------------------------//
if($tip==1){

$array_topauthor=array();
$array_topthemes=array();
$array_topout=array();
$array_toptime=array();
$array_topid=array();
$array_topfid=array();
$array_toppost=array();

for ($i = 0; $i < $alltotal; $i++){

$sdata = explode("|",$search_topic[$i]);

for ($wi = 0; $wi < $wordsitogo; $wi++){
$findmetols=$findmeword[$wi];

if (strstr($sdata[3],$findmetols)){

if (!in_array($sdata[2],$array_topthemes)){

$sdata[3]=preg_replace("/$findmetols/",'[b][red]'.$findmetols.'[/red][/b]',$sdata[3],1);

$array_topauthor[]=$sdata[1];
$array_topthemes[]=$sdata[2];
$array_topout[]=$sdata[3];
$array_toptime[]=$sdata[5];
$array_topid[]=$sdata[6];
$array_topfid[]=$sdata[7];
$array_toppost[]=$sdata[8];
}}}}}

//--------------------------- Ищем полное сходство --------------------------//
if($tip==2){

$array_topauthor=array();
$array_topthemes=array();
$array_topout=array();
$array_toptime=array();
$array_topid=array();
$array_topfid=array();
$array_toppost=array();

for ($i = 0; $i < $alltotal; $i++){

$sdata = explode("|",$search_topic[$i]);

if (strstr($sdata[3],$findmetol)){

if (!in_array($sdata[2],$array_topthemes)){

$sdata[3]=preg_replace("/$findmetol/",'[b][red]'.$findmetol.'[/red][/b]',$sdata[3],1);

$array_topauthor[]=$sdata[1];
$array_topthemes[]=$sdata[2];
$array_topout[]=$sdata[3];
$array_toptime[]=$sdata[5];
$array_topid[]=$sdata[6];
$array_topfid[]=$sdata[7];
$array_toppost[]=$sdata[8];
}}}}

$total=count($array_topout);


//------------------------------ Вывод найденного ----------------------------------//
if($total>0){
echo '<br />Поиск запроса <b>'.$findme.'</b> в сообщениях<br />';
echo 'Найдено совпадений: <b>'.(int)$total.'</b><br /><br />';


$start = (int)$_GET['start'];
if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config_searchforum){ $end = $total; }
else {$end = $start + $config_searchforum; }
for ($i = $start; $i < $end; $i++){

$page = floor($array_toppost[$i] / $config_forumpost) * $config_forumpost;

echo '<div class=b><img src="/images/img/forums.gif" alt=""> ';
echo '<b>'.($i+1).'. <a href="index.php?fid='.$array_topfid[$i].'&amp;id='.$array_topid[$i].'&amp;page='.$page.'&amp;'.SID.'">'.$array_topthemes[$i].'</a></b> ';
echo '('.date_fixed($array_toptime[$i]).')</div>';

echo '<div>Автор: <b><a href="/pages/anketa.php?uz='.$array_topauthor[$i].'&amp;'.SID.'">'.nickname($array_topauthor[$i]).'</a></b><br />';
echo 'Сообщение: '.bb_code($array_topout[$i]).'</div>';
}

echo '<hr />';
if ($start != 0) {echo '<a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.($start - $config_searchforum).'&amp;'.SID.'">&lt;-Назад</a>';}else{echo '&lt;-Назад';}
echo ' | ';
if ($total > $start + $config_searchforum) {echo ' <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.($start + $config_searchforum).'&amp;'.SID.'">Далее-&gt;</a>';}else{echo 'Далее-&gt;';}

if($total>0){

$ba=ceil($total/$config_searchforum);
$ba2=$ba*$config_searchforum-$config_searchforum;

echo '<br /><hr />Страницы:';
$asd=$start-($config_searchforum*3);
$asd2=$start+($config_searchforum*4);

if($asd<$total && $asd>0){echo ' <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start=0&amp;'.SID.'">1</a> ... ';}

for($i=$asd; $i<$asd2;)
{
if($i<$total && $i>=0){
$ii=floor(1+$i/$config_searchforum);

if ($start==$i) {
echo ' <b>('.$ii.')</b>';
}else {

echo ' <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.$i.'&amp;'.SID.'">'.$ii.'</a>';
}}

$i=$i+$config_searchforum;}
if($asd2<$total){echo ' ... <a href="search.php?action=search&amp;findme='.$findme.'&amp;ftype='.$ftype.'&amp;tip='.$tip.'&amp;start='.$ba2.'&amp;'.SID.'">'.$ba.'</a>';}
}
echo '<br /><br />';

}else{echo '<b>По вашему запросу ничего не найдено.</b><br /><br />';}

}

}else{echo '<b>Ваш запрос пуст, менее '.(int)$minfindme.' или более '.(int)$maxfindme.' символов!</b><br /><br />'; }

echo '<img src="/images/img/back.gif" alt=""> <a href="search.php?'.SID.'">Вернуться</a>';
}*/

echo '<img src="/images/img/panel.gif" alt="image"> <a href="index.php?'.SID.'">В форум</a><br />';
echo '<img src="/images/img/homepage.gif" alt="image"> <a href="/index.php?'.SID.'">На главную</a><br />';

include_once ('../themes/'.$config['themes'].'/foot.php');
?>
