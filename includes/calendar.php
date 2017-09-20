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

$cal_den = date_fixed(SITETIME,"j");
$cal_mon = date_fixed(SITETIME,"m");
$cal_year = date_fixed(SITETIME,"Y");
$cal_monyear = date_fixed(SITETIME,"m.Y");

$array_news = array();
$array_komm = array();

$newsfile=file(DATADIR."news.dat");
foreach($newsfile as $newsvalue){
$ndata=explode('|',$newsvalue);
if (date_fixed($ndata[3],'m.Y')==$cal_monyear){
$arrday = date_fixed($ndata[3],'j');
$array_news[] = $arrday;
$array_komm[$arrday] = (int)$ndata[5];
}}

$calend = makeCal($cal_mon, $cal_year);

echo '<table><caption><b>'.date_fixed(SITETIME, 'j F Y').'</b></caption>';

echo '<thead><tr>';
echo '<th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th><span style="color:#ff6666">Сб</span></th><th><span style="color:#ff6666">Вс</span></th>';
echo '</tr></thead><tbody>';

foreach ($calend as $valned) {
echo '<tr>';
foreach ($valned as $keyday=>$valday) {

if ($cal_den==$valday){
echo '<td><b><span style="color:#ff0000">'.$valday.'</span></b></td>';
continue;
}

if(in_array($valday, $array_news)){
echo '<td><a href="'.BASEDIR.'news/komm.php?id='.$array_komm[$valday].'"><span style="color:#ff0000">'.$valday.'</span></a></td>';
continue;
}

if($keyday==5 || $keyday==6){
echo '<td><span style="color:#ff6666">'.$valday.'</span></td>';
continue;
}

echo '<td>'.$valday.'</td>';

}
echo '</tr>';
}
echo '</tbody></table>';

?>
