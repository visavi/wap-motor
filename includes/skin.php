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

if ($config['autoskins']==1){
echo '<form method="post" action="'.BASEDIR.'pages/skin.php?'.SID.'">';
echo '<select name="skins"><option value="0">Выбрать скин</option>';

$globthemes = glob(BASEDIR."themes/*", GLOB_ONLYDIR);
foreach ($globthemes as $dirname) {
echo '<option value="'.basename($dirname).'">'.basename($dirname).'</option>';
}

echo '</select>';
echo '<input value="Выбрать" type="submit" /></form>';
}

//------------------------------------------------------------------//
if ($config['autoskins']==2){
echo '<form method="post" action="'.BASEDIR.'pages/skin.php?'.SID.'">';
echo '<select name="skins" onchange="this.form.submit();"><option value="0">Выбрать скин</option>';

$globthemes = glob(BASEDIR."themes/*", GLOB_ONLYDIR);
foreach ($globthemes as $dirname) {
echo '<option value="'.basename($dirname).'">'.basename($dirname).'</option>';
}

echo '</select>';
echo '</form>';
}

?>