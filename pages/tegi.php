<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  VANTUZ                     #
#               E-mail  :  visavi.net@mail.ru         #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#        для его дальнейшего распространения          #
#-----------------------------------------------------#	
require_once "../includes/start.php";
require_once "../includes/functions.php";
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";        
                                                        
echo '<img src="../images/img/partners.gif" alt="image" /> <b>Справка по тегам</b><br /><br />';

echo 'Вы можете выражать свой текст следующими тегами:<br /><br />';

echo '[big]'.bb_code('[big]Большой шрифт[/big]').'[/big]<br />';
echo '[b]'.bb_code('[b]Жирный шрифт[/b]').'[/b]<br />';
echo '[i]'.bb_code('[i]Наклонный шрифт[/i]').'[/i]<br />';
echo '[u]'.bb_code('[u]Подчеркнутый шрифт[/u]').'[/u]<br />';
echo '[small]'.bb_code('[small]Маленький шрифт[/small]').'[/small]<br />';
echo '[red]'.bb_code('[red]Красный шрифт[/red]').'[/red]<br />';
echo '[green]'.bb_code('[green]Зеленый шрифт[/green]').'[/green]<br />';
echo '[blue]'.bb_code('[blue]Голубой шрифт[/blue]').'[/blue]<br />';
echo '[yellow]'.bb_code('[yellow]Желтый шрифт[/yellow]').'[/yellow]<br />';
echo '[q]'.bb_code('[q]Для вставки цитат[/q]').'[/q]<br />';
echo '[del]'.bb_code('[del]Зачеркнутый шрифт[/del]').'[/del]<br />';
echo '[code]'.bb_code('[code]&lt;? echo"Для вставки php-кода"; ?&gt;[/code]').'[/code]<br />';

echo '<br />Для того чтобы вставить ссылку, можно просто написать http://адрес_cсылки<br />';
echo 'Для ссылки с названием: [url=http://адрес_cсылки] Название [/url]<br /><br />';

echo '<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>';
include_once "../themes/".$config['themes']."/foot.php";
?>