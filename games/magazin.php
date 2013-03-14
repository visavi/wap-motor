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

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Оружейный магазин</b><br /><br />';

if (is_user()){

if($udata[55]==1){

############################################################################################
##                                    Главная страница                                    ##
############################################################################################
if($action==""){
echo 'В наличии: '.moneys($udata[41]).'<br /><br />';

echo 'Ваше текущее оружие:<br />';

if($udata[67]!=""){
$dat67 = explode("|",$udata[67]);
echo 'Легкое: <b>'.$dat67[4].'</b> (+'.$dat67[3].'%)<br />';
} else {echo 'Легкое: <b>Отсутствует</b><br />';}

if($udata[68]!=""){
$dat68 = explode("|",$udata[68]);
echo 'Пистолет: <b>'.$dat68[4].'</b> (+'.$dat68[3].'%)<br />';
} else {echo 'Пистолет: <b>Отсутствует</b><br />';}

if($udata[69]!=""){
$dat69 = explode("|",$udata[69]);
echo 'Тяжелое: <b>'.$dat69[4].'</b> (+'.$dat69[3].'%)<br />';
} else {echo 'Тяжелое: <b>Отсутствует</b><br />';}

if($udata[70]!=""){
$dat70 = explode("|",$udata[70]);
echo 'Граната: <b>'.$dat70[4].'</b> (+'.$dat70[3].'%)<br />';
} else {echo 'Граната: <b>Отсутствует</b><br />';}

if($udata[71]!=""){
$dat71 = explode("|",$udata[71]);
echo 'Амуниция: <b>'.$dat71[4].'</b><br />';
} else {echo 'Амуниция: <b>Отсутствует</b><br />';}


@$obves=$dat67[2]+$dat68[2]+$dat69[2]+$dat70[2]+$dat71[2];
@$oburon=$dat67[3]+$dat68[3]+$dat69[3]+$dat70[3];

echo '<br />Общий урон: <b>+'.$oburon.'%</b><br />';
echo 'Общий вес оружия: <b>'.round($obves/1000,1).'кг</b><br />';

echo '<br /><b>Выберите категорию оружия</b><br /><br />';

echo '<img src="../images/weapon/kat_lite.gif" alt="image" /> <b><a href="magazin.php?action=lite&amp;'.SID.'">Легкое оружие</a></b> (4)<br />'; 
echo '<img src="../images/weapon/kat_pistols.gif" alt="image" /> <b><a href="magazin.php?action=pistols&amp;'.SID.'">Пистолеты</a></b> (5)<br />';

//echo '<img src="../images/weapon/kat_shotguns.gif" alt="image" /> <b><a href="magazin.php?action=shotguns&amp;'.SID.'">Ружья</a></b> (2)<br />'; 
echo '<img src="../images/weapon/kat_shotguns.gif" alt="image" /> <b>Ружья</b> (0)<br />'; 

//echo '<img src="../images/weapon/kat_smg.gif" alt="image" /> <b><a href="magazin.php?action=smg&amp;'.SID.'">Пистолеты-автоматы</a></b> (5)<br />'; 
echo '<img src="../images/weapon/kat_smg.gif" alt="image" /> <b>Пистолеты-автоматы</b> (0)<br />'; 

//echo '<img src="../images/weapon/kat_assault.gif" alt="image" /> <b><a href="magazin.php?action=assault&amp;'.SID.'">Автоматы</a></b> (5)<br />'; 
echo '<img src="../images/weapon/kat_assault.gif" alt="image" /> <b>Автоматы</b> (0)<br />'; 

//echo '<img src="../images/weapon/kat_rifles.gif" alt="image" /> <b><a href="magazin.php?action=rifles&amp;'.SID.'">Винтовки</a></b> (6)<br />'; 
echo '<img src="../images/weapon/kat_rifles.gif" alt="image" /> <b>Винтовки</b> (0)<br />'; 

//echo '<img src="../images/weapon/kat_grenades.gif" alt="image" /> <b><a href="magazin.php?action=grenades&amp;'.SID.'">Гранаты</a></b> (4)<br />'; 
echo '<img src="../images/weapon/kat_grenades.gif" alt="image" /> <b>Гранаты</b> (0)<br />'; 

//echo '<img src="../images/weapon/kat_ammo.gif" alt="image" /> <b><a href="magazin.php?action=ammo&amp;'.SID.'">Амуниция</a></b> (4)<br />'; 
echo '<img src="../images/weapon/kat_ammo.gif" alt="image" /> <b>Амуниция</b> (0)<br />'; 

echo '<br />Каждое оружие по-своему эффективно, в бою вам будет необходимо оружие как ближнего так и дальнего боя<br />';
echo 'Из каждой категории вы можете купить только по 1 виду оружия (Автоматы и Винтовки считаются как 1 категория)<br />';
echo 'Амуниция позволяет уменьшить наносимый вам урон и сохранить ваше здоровье<br />';
echo 'Слишком большое количество и более тяжелое оружия быстрее уменьшают выносливость<br />';
}

############################################################################################
##                                    Легкое оружие                                       ##
############################################################################################
if($action=="lite"){

echo 'У вас в наличии: <b>'.moneys($udata[41]).'</b><br /><br />';

if($udata[67]!=""){
$dat67 = explode("|",$udata[67]);
echo 'Ваше текущее оружие: <b>'.$dat67[4].'</b> (Магазин: '.$dat67[1].', Вес: '.$dat67[2].'гр, урон +'.$dat67[3].'%)<br /><br />';
}

echo '<img src="../images/weapon/kastet.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=kastet&amp;'.SID.'">Кастет</a></b> ('.moneys(100).')<br />';
echo 'Чугунный самодельный кастет, самое слабое оружие, можете купить если уверены, что до ближнего боя дело не дойдет<br />';
echo '<b>(Вес: 150гр, урон +1%)</b><br /><br />';

echo '<img src="../images/weapon/knife.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=knife&amp;'.SID.'">Охотничий нож</a></b> ('.moneys(200).')<br />';
echo 'Обыкновенный нож, с которым ходят на охоту<br />';
echo '<b>(Вес: 350гр, урон +2%)</b><br /><br />';

echo '<img src="../images/weapon/knife2.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=knife2&amp;'.SID.'">Армейский нож</a></b> ('.moneys(300).')<br />';
echo 'Армейский нож - немного лучше чем охотничий за счет более длинного лезвия, однако весит также немного больше<br />';
echo '<b>(Вес: 420гр, урон +3%)</b><br /><br />';

echo '<img src="../images/weapon/bita.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=bita&amp;'.SID.'">Бита</a></b> ('.moneys(500).')<br />';
echo 'Бейсбольная бита, в бою может быть даже лучше чем нож, так как не даст подойти на близкое расстояние<br />';
echo '<b>(Вес: 800гр, урон +4%)</b><br /><br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="magazin.php?'.SID.'">Вернуться</a>'; 
}
	
############################################################################################
##                                      Пистолеты                                         ##
############################################################################################
if($action=="pistols"){

echo 'У вас в наличии: <b>'.moneys($udata[41]).'</b><br /><br />';

if($udata[68]!=""){
$dat68 = explode("|",$udata[68]);
echo 'Ваше текущее оружие: <b>'.$dat68[4].'</b> (Магазин: '.$dat68[1].', Вес: '.$dat68[2].'гр, урон +'.$dat68[3].'%)<br /><br />';
}

echo '<img src="../images/weapon/glock18.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=glock18&amp;'.SID.'">Glock18</a></b> ('.moneys(1000).')<br />';
echo 'Glock18 имеет дополнительную функцию - стрельба по 3 патрона. В бою практически бесполезен. Реальную пользу из него можно извлечь только при стрельбе на малом расстоянии<br />';
echo '<b>(Магазин: 20, Вес: 900гр, урон +5%)</b><br /><br />';

echo '<img src="../images/weapon/usp.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=usp&amp;'.SID.'">USP Tactical</a></b> ('.moneys(2000).')<br />';
echo 'Неплохая убойная сила и кучность. Дополнительно - можно накручивать глушак, что делает стрельбу практически бесшумной, в этом режиме улучшается кучность, но ослабевает убойная сила<br />';
echo '<b>(Магазин: 12, Вес: 1кг, урон +6%)</b><br /><br />';

echo '<img src="../images/weapon/p228.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=p228&amp;'.SID.'">P228</a></b> ('.moneys(2500).')<br />';
echo 'Оптимальный варинт  цена и качество  - небольшая стоимость, 13 патронов в магазине, и нормальная меткость - эти качества делают в игры его присутствие вовсе не бесполезным<br />';
echo '<b>(Магазин: 13, Вес: 1.1кг, урон +7%)</b><br /><br />';

echo '<img src="../images/weapon/fiveseven.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=fiveseven&amp;'.SID.'">Five-Seven</a></b> ('.moneys(3000).')<br />';
echo 'Очень хороший пистолет, имеет хорошую кучность, скорострельность<br />';
echo '<b>(Магазин: 20, Вес: 600гр, урон +7%)</b><br /><br />';

echo '<img src="../images/weapon/elites.gif" alt="image" /> <b><a href="magazin.php?action=shop&amp;weapon=elites&amp;'.SID.'">Dual Beretta</a></b> ('.moneys(5000).')<br />';
echo 'Имеет огромное преимущество - 30 патронов в обоймах. Минус: слишком низкая кучность<br />';
echo '<b>(Магазин: 30, Вес: 2*1.1кг, урон +8%)</b><br /><br />';

echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="magazin.php?'.SID.'">Вернуться</a>';
}	
	
	
############################################################################################
##                                       Покупка                                          ##
############################################################################################
if($action=="shop"){

$weapon = check($_GET['weapon']);
	
if($weapon!=""){
//-----------------------------------//
if($weapon=="kastet"){	
	
if($udata[41]>=100){

change_profil($log, array(41=>$udata[41]-100, 67=>"kastet|0|150|1|Кастет"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/kastet.gif" alt="image" /> <b>(Вес: 150гр, урон +1%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(100).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}	


//-----------------------------------//
if($weapon=="knife"){	
	
if($udata[41]>=200){

change_profil($log, array(41=>$udata[41]-200, 67=>"knife|0|350|2|Охотничий нож"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/knife.gif" alt="image" /> <b>(Вес: 350гр, урон +2%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(200).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}	


//-----------------------------------//
if($weapon=="knife2"){	
	
if($udata[41]>=300){

change_profil($log, array(41=>$udata[41]-300, 67=>"knife2|0|420|3|Армейский нож"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/knife2.gif" alt="image" /> <b>(Вес: 420гр, урон +3%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(300).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}	


//-----------------------------------//
if($weapon=="bita"){	
	
if($udata[41]>=500){

change_profil($log, array(41=>$udata[41]-500, 67=>"bita|0|800|4|Бита"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/bita.gif" alt="image" /> <b>(Вес: 420гр, урон +3%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(500).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}	

##########################################################################
##                        Покупка пистолета
##########################################################################	
if($weapon=="glock18"){	
	
if($udata[41]>=1000){

change_profil($log, array(41=>$udata[41]-1000, 68=>"glock18|20|900|5|Glock18"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/glock18.gif" alt="image" /> <b>(Магазин: 20, Вес: 900гр, урон +5%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(1000).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}	

//-----------------------------------//

if($weapon=="usp"){	
	
if($udata[41]>=2000){

change_profil($log, array(41=>$udata[41]-2000, 68=>"usp|12|1000|6|USP Tactical"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/usp.gif" alt="image" /> <b>(Магазин: 12, Вес: 1кг, урон +6%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(2000).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}	

//-----------------------------------//

if($weapon=="p228"){	
	
if($udata[41]>=2500){

change_profil($log, array(41=>$udata[41]-2500, 68=>"p228|13|1100|7|P228"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/p228.gif" alt="image" /> <b>(Магазин: 13, Вес: 1.1кг, урон +7%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(2500).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}


//-----------------------------------//

if($weapon=="fiveseven"){	
	
if($udata[41]>=3000){

change_profil($log, array(41=>$udata[41]-3000, 68=>"fiveseven|20|600|7|Five-Seven"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/fiveseven.gif" alt="image" /> <b>(Магазин: 20, Вес: 600г, урон +7%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(3000).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}


//-----------------------------------//

if($weapon=="elites"){	
	
if($udata[41]>=5000){

change_profil($log, array(41=>$udata[41]-5000, 68=>"elites|30|2200|8|Dual Beretta"));

echo '<b><span style="color:#ff0000">Оружие успешно куплено!</span></b><br /><br />';
echo '<img src="../images/weapon/elites.gif" alt="image" /> <b>(Магазин: 30, Вес: 2*1.1кг, урон +7%)</b><br /><br />';

echo 'С вашего счета списано: <b>'.moneys(5000).'</b><br /><br />';

} else {show_error('На вашем счету недостаточно средств для подобной покупки!');}
}


} else {
echo '<b>Вы забыли выбрать оружие, которое хотите купить!</b><br />';}	
echo '<br /><img src="../images/img/back.gif" alt="image" /> <a href="magazin.php?'.SID.'">Вернуться</a>';
}		
	
} else {
echo 'Ошибка! Ваш персонаж игры не включен! Для того чтобы его включить, измените свои настройки<br />';
echo 'Персонаж позволит вам участвовать в разных играх, боях, покупать оружие, прокачивать своего бойца, зарабатывать деньги и многое другое<br />';
echo '<br /><img src="../images/img/panel.gif" alt="image" /> <a href="../pages/setting.php?'.SID.'">Настройки</a>';
}	
	
} else {show_login('Вы не авторизованы, чтобы совершать операции, необходимо');}

echo '<br /><img src="../images/img/games.gif" alt="image" /> <a href="../pages/index.php?action=arkada&amp;'.SID.'">Развлечения</a><br />'; 
echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';

include_once ("../themes/".$config['themes']."/foot.php");
?>