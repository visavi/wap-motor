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

if (isset($_GET['action'])) {$action = check($_GET['action']);} else {$action = "";}

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Бан пользователя</b><br /><br />';

if (is_user()){

$time_ban = round($udata[38]-SITETIME);
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if ($time_ban>0){
if ($action==""){

echo '<img src="../images/img/error.gif" alt="image" /> <b>Вас забанили</b><br /><br />';	
echo '<b><span style="color:#ff0000">Причина бана: '.$udata[39].'</span></b><br /><br />';

echo 'До окончания бана осталось <b>'.formattime($time_ban).'</b>';	

echo '<br /><br />Чтобы не терять время зря, рекомендуем вам ознакомиться с <b><a href="'.BASEDIR.'pages/pravila.php?'.SID.'">Правилами сайта</a></b><br />';

echo '<br />Общее число строгих нарушений: <b>'.(int)$udata[64].'</b><br />';
echo 'Внимание, максимальное количество нарушений: <b>5</b><br />';
echo 'При превышении лимита нарушений ваш профиль автоматически удаляется<br />';
echo 'Востановление профиля или данных после этого будет невозможным<br />';
echo 'Будьте внимательны, старайтесь не нарушать больше правил<br />';

//--------------------------------------------------//
if ($config['addbansend']==1){
if ($udata[73]==1){

echo '<br /><form method="post" action="ban.php?action=send&amp;'.SID.'">';
echo 'Объяснение:<br />';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br />';
echo '<input value="Отправить" name="do" type="submit" /></form><hr />';

echo 'Если модер вас забанил по ошибке или вы считаете, что бан не заслужен, то вы можете написать объяснение своего нарушения<br />';
echo 'В случае если ваше объяснение будет рассмотрено и удовлетворено, то возможно вас и разбанят<br />';
}}
}

############################################################################################
##                                    Отправка объяснения                                 ##
############################################################################################
if ($action=="send"){

$msg = check($_POST['msg']);

if (file_exists(DATADIR."profil/$udata[63].prof")){
if ($config['addbansend']==1){
if ($udata[73]==1){
if (utf_strlen(trim($msg))>=5 && utf_strlen($msg)<1000){

$msg = no_br($msg,'<br />');
$msg = antimat($msg);
$msg = smiles($msg);

$text = no_br($log.'|Объяснение нарушения: '.$msg.'|'.SITETIME.'|'); 

write_files(DATADIR.'privat/'.$udata[63].'.priv', "$text\r\n");

$uzdata = reading_profil($udata[63]);
change_profil($udata[63], array(10=>$uzdata[10]+1));

change_profil($log, array(73=>0));

header ("Location: ban.php?isset=addbansend&".SID); exit;

} else { echo '<b>Ошибка! Слишком длинное или короткое объяснение!</b><br />';}
} else { echo '<b>Ошибка! Вы уже писали объяснение!</b><br />';}
} else { echo '<b>Писать объяснительные запрещено админом</b><br />';}
} else { echo '<b>Ошибка! Вам запрещено писать объяснение</b><br />';}

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="ban.php?'.SID.'">Вернуться</a>';
}

############################################################################################
##                                    Конец бана                                          ##
############################################################################################
} else {

echo '<img src="../images/img/open.gif" alt="image" /> ВЫ БЫЛИ ЗАБАНЕНЫ<br /><br />';
echo '<b><span style="color:#ff0000">Причина бана: '.$udata[39].'</span></b><br /><br />';

echo 'Поздравляем!!! Время вашего бана вышло, постарайтесь вести себя достойно и не нарушать правила сайта<br />';

echo '<br />Рекомендуем ознакомиться с <b><a href="'.BASEDIR.'pages/pravila.php?'.SID.'">Правилами сайта</a></b><br />';

echo 'Также у вас есть возможность исправиться и снять строгое нарушение.<br />';
echo 'Если прошло более 1 месяца после последнего бана, то на странице <b><a href="'.BASEDIR.'pages/razban.php?'.SID.'">Исправительная</a></b> заплатив штраф вы можете снять 1 строгое нарушение<br />';

if ($udata[37]==1){
change_profil($log, array(37=>0, 38=>0, 73=>0));
}
}

} else {echo '<img src="../images/img/error.gif" alt="image" /> <b>Ошибка! Вы не авторизованы!</b><br />';}

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';
include_once"../themes/".$config['themes']."/foot.php";
?>