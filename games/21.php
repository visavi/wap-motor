<?php#-----------------------------------------------------##          ********* WAP-MOTORS *********             ##             Made by   :  VANTUZ                     ##               E-mail  :  visavi.net@mail.ru         ##                 Site  :  http://pizdec.ru           ##             WAP-Site  :  http://visavi.net          ##                  ICQ  :  36-44-66                   ##  Вы не имеете право вносить изменения в код скрипта ##        для его дальнейшего распространения          ##-----------------------------------------------------#	require_once ("../includes/start.php");require_once ("../includes/functions.php");require_once ("../includes/header.php");include_once ("../themes/".$config['themes']."/index.php");if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}show_title('partners.gif', '21 (Очко)');$randcard = mt_rand(1,36);$randcard2 = mt_rand(1,36);$randgame = mt_rand(100,999);	if (is_user()){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($action==""){
echo 'В наличии: '.moneys($udata[41]).'<br /><br />';

if (empty($_SESSION['stavka'])){

if ($udata[41]>0){
echo 'Ваша ставка (1 - '.$config['ochkostavka'].'):<br />';

echo'<form action="21.php?action=ini&amp;rand='.$randgame.'&amp;'.SID.'" method="post">';
echo'<input name="mn" /><br />';
echo'<input type="submit" value="Играть" /></form><hr />';

} else {echo '<b>У вас нет денег для игры!</b><br /><br />';}

echo'Mаксимальная ставка - '.moneys($config['ochkostavka']).'<br /><br />';

} else {
echo 'Cтавки сделаны, на кону: '.moneys($_SESSION['stavka']*2).'<br /><br />';
echo '<b><a href="21.php?action=game&amp;act=go&amp;rand='.$randgame.'&amp;'.SID.'">Вернитесь в игру</a></b><br /><br />';
}

echo '<img src="../images/img/faq.gif" alt="image" /> <a href="21.php?action=pravila&amp;'.SID.'">Правила игры</a><br />';
}##############################################################################################                                    Проверка данных                                     ##############################################################################################if ($action=="ini"){if (isset($_POST['mn'])){$mn = (int)$_POST['mn'];} else {$mn = (int)$_GET['mn'];}if ($mn>0){if ($mn<=$config['ochkostavka']){if ($udata[41]>=$mn){if (empty($_SESSION['stavka'])){$_SESSION['stavka'] = $mn;change_profil($log, array(41=>$udata[41]-$mn));header ("Location: 21.php?action=game&rand=$randgame&".SID); exit;} else {show_error('Вы уже сделали ставку, вернитесь в игру!');}} else {show_error('У вас недостаточно денег для подобной ставки!');}} else {show_error('Запрещено ставить больше чем максимальная ставка '.moneys($config['ochkostavka']).'!');}} else {show_error('Вы не указали ставку, необходимо поставить от 1 до '.$config['ochkostavka'].'!');}echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="21.php?'.SID.'">Вернуться</a><br />';}##############################################################################################                                        Игра                                            ##############################################################################################if ($action=="game"){if (isset($_GET['act'])) {$act = check($_GET['act']);} else {$act = "";}if (isset($_SESSION['stavka'])){if (empty($act)){if (empty($_SESSION['cards'])) {$_SESSION['cards'] = array();}if (empty($_SESSION['bankircards'])) {$_SESSION['bankircards'] = array();}if (empty($_SESSION['uscore'])) {$_SESSION['uscore'] = 0; $_SESSION['bscore'] = 0;}$_SESSION['cards'][] = $randcard;$_SESSION['uscore']+=cards_score($randcard);if ($_SESSION['bscore']<21){$_SESSION['bankircards'][] = $randcard2;$_SESSION['bscore']+=cards_score($randcard2);}}echo 'В наличии: '.moneys($udata[41]).'<br />';echo '<br /><b>Ваши карты:</b><br />';foreach($_SESSION['cards'] as $value){echo '<img src="../images/cards/'.$value.'.gif" alt="image" /> ';}echo '<br />'.cards_points($_SESSION['uscore']).'<br /><br />';if ($act=="end"){if ($_SESSION['bscore']<17) {$_SESSION['bankircards'][]=$randcard2; $_SESSION['bscore']+=cards_score($randcard2);}if ($_SESSION['uscore']>$_SESSION['bscore']){$win=1;}if ($_SESSION['bscore']>$_SESSION['uscore']){$win=2;}if ($_SESSION['uscore']==$_SESSION['bscore']){$win=2;}if ($_SESSION['bscore']>21){$win=1;}}if ($_SESSION['uscore']>21 && count($_SESSION['cards'])!=2){echo '<b><span style="color:#ff0000">У вас перебор!</span> </b>'; $win=2;}if ($_SESSION['uscore']==22 && count($_SESSION['cards'])==2){echo '<b><span style="color:#ff0000">У вас 2 туза!</span> </b>'; $win=1;}if ($_SESSION['bscore']==22 && count($_SESSION['bankircards'])==2){echo '<b><span style="color:#ff0000">У банкира 2 туза!</span> </b>'; $win=2;}if ($_SESSION['uscore']==21){echo '<b><span style="color:#ff0000">У вас очко!</span> </b>'; $win=1;}if ($_SESSION['bscore']==21){echo '<b><span style="color:#ff0000">У банкира очко!</span> </b>'; $win=2;}if (isset($win)){if ($win==1){change_profil($log, array(41=>$udata[41]+($_SESSION['stavka']*2)));echo '<b><span style="color:#00ff00">Вы выиграли</span></b><br />';echo 'Ставка в размере '.moneys($_SESSION['stavka']*2).' отправлена вам на счет<br />';} else {echo '<b><span style="color:#ff0000">Вы проиграли</span></b><br />';echo 'Ставка в размере '.moneys($_SESSION['stavka']*2).' отправлена в банк<br />';}echo '<br /><b>Карты банкира:</b><br />';foreach($_SESSION['bankircards'] as $bvalue){echo '<img src="../images/cards/'.$bvalue.'.gif" alt="image" /> ';}echo '<br />'.cards_points($_SESSION['bscore']).'<br /><br />';echo '<img src="../images/img/reload.gif" alt="image" /> <a href="21.php?action=ini&amp;rand='.$randgame.'&amp;mn='.$_SESSION['stavka'].'&amp;'.SID.'">Повторить ставку</a>';$_SESSION['cards']="";$_SESSION['bankircards']="";$_SESSION['stavka']="";$_SESSION['uscore']="";$_SESSION['bscore']="";unset($_SESSION['cards']);unset($_SESSION['bankircard']);unset($_SESSION['stavka']);unset($_SESSION['uscore']);unset($_SESSION['bscore']);} else {echo 'На кону: '.moneys($_SESSION['stavka']*2).'<br /><br />';echo '<b><a href="21.php?action=game&amp;rand='.$randgame.'&amp;'.SID.'">Взять карту</a></b> или ';echo '<b><a href="21.php?action=game&amp;act=end&amp;rand='.$randgame.'&amp;'.SID.'">Открыться</a></b><br /><br />';}} else {show_error('Вы не установили размер ставки, необходимо сделать ставку!');}if (empty($_SESSION['stavka'])) {echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="21.php?'.SID.'">Новая ставка</a><br />';}}//-------------------------- Правила игры -------------------------------------//if ($action=="pravila"){echo 'Для участия в игре сделайте ставку и нажмите <b>Играть</b><br />';echo 'Ваша ставка будет получена Банкиром и он начнет сдавать Вам карты.<br />';echo 'В игре участвуют двое - Вы и Банкир, на кону - двойная ставка (Ваша ставка и ставка Банкира). Взяв карты, Вы подсчитываете суммарное количество их очков.<br /><br />';echo '<b>Очки считаются следующим образом:</b><br />';echo '<img src="../images/cards/2.gif" alt="image" /> шестерка - 6 очков<br />';echo '<img src="../images/cards/6.gif" alt="image" /> семерка - 7 очков<br />';echo '<img src="../images/cards/10.gif" alt="image" /> восьмерка - 8 очков<br />';echo '<img src="../images/cards/14.gif" alt="image" /> девятка - 9 очков<br />';echo '<img src="../images/cards/18.gif" alt="image" /> десятка - 10 очков<br />';echo '<img src="../images/cards/22.gif" alt="image" /> валет - 2 очков<br />';echo '<img src="../images/cards/26.gif" alt="image" /> дама - 3 очков<br />';echo '<img src="../images/cards/30.gif" alt="image" /> король - 4 очков<br />';echo '<img src="../images/cards/34.gif" alt="image" /> туз - 11 очков.<br /><br />';echo 'Сумма очков не зависит от масти карт.<br />';echo 'Для взятия очередной карты нужно нажать кнопку <b>Взять карту</b>.<br />';echo 'Если сумма Ваших очков больше 21, то Вы проиграли - перебор, исключение - 2 туза(22 очка).<br />';echo 'Очко(21) главнее чем 2 туза(22)!<br /><br />';echo 'Взяв необходимое количество карт, Вы нажимаете кнопку <b>Открыться</b>, и Банкир открывает свои карты (если Вы набираете 20, 21 или 22 (2 туза) очка то Банкир открывается автоматически). Выигрывает тот, у кого больше очков. Победитель забирает кон размером в 2 ставки. При равном количестве очков выигрывает банкир!<br /><br />';echo '<img src="../images/img/back.gif" alt="image" /> <a href="21.php?'.SID.'">В игру</a><br />';}} else {show_login('Вы не авторизованы, чтобы начать игру, необходимо');}echo '<img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada&amp;'.SID.'">Развлечения</a><br />'; echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 
include_once ("../themes/".$config['themes']."/foot.php");?>