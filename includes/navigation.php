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
if (!defined('BASEDIR')) { header("Location:../index.php"); exit; }

# 0 - Выключить выпадающий список 
# 1 - Обычный выпадающий список
# 2 - Выпадающий список без кнопки

if (file_exists(DATADIR."navigation.dat")){
$filenav = file(DATADIR."navigation.dat");
if ($filenav){

if ($config['navigation']==1){

echo '<form method="post" action="'.BASEDIR.'pages/skin.php?action=navigation&amp;'.SID.'">';
echo '<select name="link"><option value="index.php">Быстрый переход</option>';

foreach ($filenav as $valnav){
$datanav = explode("|", $valnav);	
echo '<option value="'.$datanav[0].'">'.$datanav[1].'</option>';
}

echo '</select>';
echo '<input value="Go!" type="submit" /></form>';

}

if ($config['navigation']==2){

echo '<form method="post" action="'.BASEDIR.'pages/skin.php?action=navigation&amp;'.SID.'">';
echo '<select name="link" onchange="this.form.submit();"><option value="index.php">Быстрый переход</option>';

foreach ($filenav as $valnav){
$datanav = explode("|", $valnav);	
echo '<option value="'.$datanav[0].'">'.$datanav[1].'</option>';
}

echo '</select>';
echo '</form>';
}
}}

?>