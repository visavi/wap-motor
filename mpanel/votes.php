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

if (isset($_GET['start'])){$start = (int)$_GET['start'];} else {$start = 0;}
if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

if (is_admin(array(101,102))){

echo'<img src="../images/img/menu.gif" alt="image" /> <b>Управление голосованием</b><br /><br />';

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){

if (file_exists(DATADIR."datavotes/votes.dat")){
$file = file_get_contents(DATADIR."datavotes/votes.dat");
$data = explode("|",$file);

echo '<b>Внимание!</b><br />';
echo 'При редактировании голосования подсчет результатов остается неизменным<br />';
echo 'Также при редактировании нежелательно оставлять пустые поля.<hr />';

echo '<form action="votes.php?action=edit&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Вопрос:<br /><input type="text" name="question" maxlength="100"  value="'.$data[0].'" /><br />';
echo 'Ответ 1:<br /><input type="text" name="answer1" value="'.$data[1].'" /><br />';
echo 'Ответ 2:<br /><input type="text" name="answer2" value="'.$data[2].'" /><br />';
echo 'Ответ 3:<br /><input type="text" name="answer3" value="'.$data[3].'" /><br />';

if ($data[4]!=="") {echo 'Ответ 4:<br /><input type="text" name="answer4" value="'.$data[4].'" /><br />';
if ($data[5]!=="") {echo 'Ответ 5:<br /><input type="text" name="answer5" value="'.$data[5].'" /><br />';}
if ($data[6]!=="") {echo 'Ответ 6:<br /><input type="text" name="answer6" value="'.$data[6].'" /><br />';}
if ($data[7]!=="") {echo 'Ответ 7:<br /><input type="text" name="answer7" value="'.$data[7].'" /><br />';}
if ($data[8]!=="") {echo 'Ответ 8:<br /><input type="text" name="answer8" value="'.$data[8].'" /><br />';}
if ($data[9]!=="") {echo 'Ответ 9:<br /><input type="text" name="answer9" value="'.$data[9].'" /><br />';}
if ($data[10]!=="") {echo 'Ответ 10:<br /><input type="text" name="answer10" value="'.$data[10].'" /><br />';}
}
echo '<input type="submit" value="Изменить" /></form><hr />';

} else {echo'<b>Голосование еще не создано</b><br />';}

echo'<br /><img src="../images/img/reload.gif" alt="image" /> <a href="votes.php?action=new">Создать голосование</a><br />';
echo'<img src="../images/img/arhiv.gif" alt="image" /> <a href="votes.php?action=all">Архив голосований</a>';
}

############################################################################################
##                               Редактирование голосования                               ##
############################################################################################
if($action=="edit"){

$uid = check($_GET['uid']);
$question = check($_POST['question']);
$answer1 = check($_POST['answer1']);
$answer2 = check($_POST['answer2']);
$answer3 = check($_POST['answer3']);
if (isset($_POST['answer4'])){$answer4 = check($_POST['answer4']);} else {$answer4 = '';}
if (isset($_POST['answer5'])){$answer5 = check($_POST['answer5']);} else {$answer5 = '';}
if (isset($_POST['answer6'])){$answer6 = check($_POST['answer6']);} else {$answer6 = '';}
if (isset($_POST['answer7'])){$answer7 = check($_POST['answer7']);} else {$answer7 = '';}
if (isset($_POST['answer8'])){$answer8 = check($_POST['answer8']);} else {$answer8 = '';}
if (isset($_POST['answer9'])){$answer9 = check($_POST['answer9']);} else {$answer9 = '';}
if (isset($_POST['answer10'])){$answer10 = check($_POST['answer10']);} else {$answer10 = '';}

if ($uid==$_SESSION['token']){
if ($question!="" && $answer1!=="" && $answer2!=="" && $answer3!==""){

$text = $question.'|'.$answer1.'|'.$answer2.'|'.$answer3.'|'.$answer4.'|'.$answer5.'|'.$answer6.'|'.$answer7.'|'.$answer8.'|'.$answer9.'|'.$answer10.'|';

write_files(DATADIR."datavotes/votes.dat", $text, 1, 0666);

header ("Location: votes.php?isset=mp_editvotes"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, не заполнено какое-либо важное поле!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo'<br /><img src="../images/img/back.gif" alt="image" /> <a href="votes.php">Вернуться</a>';
}


############################################################################################
##                              Форма создания нового голосования                         ##
############################################################################################
if($action=="new"){
echo '<b><big>Новое голосование</big></b><br /><br />';

echo 'Голосование может состоять от 3 до 10 вариантов ответа.<br />';
echo 'Для создания нового голосования заполните обязательные поля: Вопрос и первые 3 поля для ответов.<br />';
echo 'При нажатии на кнопку Создать предыдущий вопрос и ответы, а также подсчёт результатов будут анулированы и отправлены в архив голосований<br /><br />';

echo '<form action="votes.php?action=add&amp;uid='.$_SESSION['token'].'" method="post">';
echo 'Вопрос *:<br /><input type="text" name="question" maxlength="100" /><br />';
echo 'Ответ 1 *:<br /><input type="text" name="answer1" /><br />';
echo 'Ответ 2 *:<br /><input type="text" name="answer2" /><br />';
echo 'Ответ 3 *:<br /><input type="text" name="answer3" /><br />';
echo 'Ответ 4:<br /><input type="text" name="answer4" /><br />';
echo 'Ответ 5:<br /><input type="text" name="answer5" /><br />';
echo 'Ответ 6:<br /><input type="text" name="answer6" /><br />';
echo 'Ответ 7:<br /><input type="text" name="answer7" /><br />';
echo 'Ответ 8:<br /><input type="text" name="answer8" /><br />';
echo 'Ответ 9:<br /><input type="text" name="answer9" /><br />';
echo 'Ответ 10:<br /><input type="text" name="answer10" /><br /><br />';
echo '<input type="submit" value="Создать" /></form><hr />';

echo 'Поля отмеченные звездочкой обязательны для заполнения<br />';
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="votes.php">Вернуться</a>';
}


############################################################################################
##                                   Создание голосования                                 ##
############################################################################################
if($action=="add"){

$uid = check($_GET['uid']);
$question = check($_POST['question']);
$answer1 = check($_POST['answer1']);
$answer2 = check($_POST['answer2']);
$answer3 = check($_POST['answer3']);
if (isset($_POST['answer4'])){$answer4 = check($_POST['answer4']);} else {$answer4 = '';}
if (isset($_POST['answer5'])){$answer5 = check($_POST['answer5']);} else {$answer5 = '';}
if (isset($_POST['answer6'])){$answer6 = check($_POST['answer6']);} else {$answer6 = '';}
if (isset($_POST['answer7'])){$answer7 = check($_POST['answer7']);} else {$answer7 = '';}
if (isset($_POST['answer8'])){$answer8 = check($_POST['answer8']);} else {$answer8 = '';}
if (isset($_POST['answer9'])){$answer9 = check($_POST['answer9']);} else {$answer9 = '';}
if (isset($_POST['answer10'])){$answer10 = check($_POST['answer10']);} else {$answer10 = '';}

if ($uid==$_SESSION['token']){
if ($question!="" && $answer1!=="" && $answer2!=="" && $answer3!==""){

if (file_exists(DATADIR."datavotes/votes.dat")){
$filevotes = file_get_contents(DATADIR."datavotes/votes.dat");
$data = explode("|",$filevotes);

$fileresult = file_get_contents(DATADIR."datavotes/result.dat");
$vr = explode("|",$fileresult);
$sum=array_sum($vr);

$res1 = $data[1].' - '.(int)$vr[1];
$res2 = $data[2].' - '.(int)$vr[2];
$res3 = $data[3].' - '.(int)$vr[3];
if($data[4]!=="") {$res4 = $data[4].' - '.(int)$vr[4];} else {$res4 = "";}
if($data[5]!=="") {$res5 = $data[5].' - '.(int)$vr[5];} else {$res5 = "";}
if($data[6]!=="") {$res6 = $data[6].' - '.(int)$vr[6];} else {$res6 = "";}
if($data[7]!=="") {$res7 = $data[7].' - '.(int)$vr[7];} else {$res7 = "";}
if($data[8]!=="") {$res8 = $data[8].' - '.(int)$vr[8];} else {$res8 = "";}
if($data[9]!=="") {$res9 = $data[9].' - '.(int)$vr[9];} else {$res9 = "";}
if($data[10]!=="") {$res10 = $data[10].' - '.(int)$vr[10];} else {$res10 = "";}

$allvotes = no_br($data[0].'|'.$res1.'|'.$res2.'|'.$res3.'|'.$res4.'|'.$res5.'|'.$res6.'|'.$res7.'|'.$res8.'|'.$res9.'|'.$res10.'|'.$sum.'|');

write_files(DATADIR."datavotes/allvotes.dat", "$allvotes\r\n", 0, 0666);
}

$newvotes = $question.'|'.$answer1.'|'.$answer2.'|'.$answer3.'|'.$answer4.'|'.$answer5.'|'.$answer6.'|'.$answer7.'|'.$answer8.'|'.$answer9.'|'.$answer10.'|';

write_files(DATADIR."datavotes/votes.dat", $newvotes, 1, 0666);

write_files(DATADIR."datavotes/result.dat", "|0|0|0|0|0|0|0|0|0|0|", 1, 0666);

write_files(DATADIR."datavotes/users.dat", "", 1, 0666);

header ("Location: votes.php?isset=mp_addvotes"); exit;

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка, не заполнено какое-либо важное поле!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

}

############################################################################################
##                                     Архив голосований                                  ##
############################################################################################
if($action=="all"){

echo '<b><big>Архив голосований</big></b><br /><br />';

if(file_exists(DATADIR."datavotes/allvotes.dat")){
$file = file(DATADIR."datavotes/allvotes.dat");
$file = array_reverse($file);
$total = count($file);

if ($total>0){

echo '<form action="votes.php?action=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';

if ($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $config['allvotes']){ $end = $total; }
else {$end = $start + $config['allvotes']; }
for ($i = $start; $i < $end; $i++){

$data = explode("|",$file[$i]);

$num = $total - $i - 1;

echo '<div class="b">';

echo '<input type="checkbox" name="del[]" value="'.$num.'" /> ';

echo '<img src="../images/img/arhiv.gif" alt="image" /> <b>'.$data[0].'</b></div>';
echo '<div>Было опрошено: '.(int)$data[11].'</div>';
}
echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

page_jumpnavigation('votes.php?action=all&amp;', $config['allvotes'], $start, $total);
page_strnavigation('votes.php?action=all&amp;', $config['allvotes'], $start, $total);

echo '<br /><br />Всего голосований: '.(int)$total.'<br />';

} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Голосований еще нет!</b>';}
} else {echo '<img src="../images/img/reload.gif" alt="image" /> <b>Архив голосований еще не создан</b>';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="votes.php">Вернуться</a>';
}


############################################################################################
##                                   Удаление из архива                                   ##
############################################################################################
if($action=="del"){

$uid = check($_GET['uid']);
if (isset($_POST['del'])) {$del = intar($_POST['del']);} else {$del = "";}

if ($uid==$_SESSION['token']){
if ($del!==""){

delete_lines(DATADIR."datavotes/allvotes.dat", $del);

header ("Location: votes.php?action=all&start=$start&isset=mp_delvotes");

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Не выбрано голосование для удаления!</b><br />';}
} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Неверный идентификатор сессии, повторите действие!</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="votes.php?action=all&amp;start='.$start.'">Вернуться</a>';
}

echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="index.php">В админку</a><br />';
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a><br />';

} else {header ("Location: ../index.php?isset=404"); exit;}

include_once ("../themes/".$config['themes']."/foot.php");
?>
