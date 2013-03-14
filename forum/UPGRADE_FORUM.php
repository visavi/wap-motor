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
require_once ("../includes/start.php");
require_once ("../includes/functions.php");
require_once ("../includes/header.php");
include_once ("../themes/".$config['themes']."/index.php");
include_once ("../includes/db.php");

show_title('partners.gif', 'Апгрейд форума');

$file = file(DATADIR.'dataforum/mainforum.dat');

$countforum = count($file);

mysql_query('INSERT INTO `forums` (`id`, `name`, `position`, `under`) VALUES (1, "Форум нашего сайта", 0, '.$countforum.');');



foreach ($file as $value){
$data = explode('|', $value);


mysql_query('UPDATE `forums` SET `theme`=`theme`+'.$data[4].', `posts`=`posts`+'.$data[5].';');


mysql_query('INSERT INTO `under` (`id`, `forum`, `position`, `name`, `theme`, `posts`) VALUES ('.$data[0].', 1, '.$data[0].', "'.$data[1].'", '.$data[4].', '.$data[5].');');


$filestopic = file(DATADIR.'dataforum/topic'.$data[0].'.dat');


foreach ($filestopic as $values){
$datatopic = explode('|', $values);

$filescount = file(DATADIR.'dataforum/'.$datatopic[7].'.dat');
$countspost = count($filescount);
$datastart = explode('|', $filescount[0]);
$datastop = explode('|', end($filescount));

$closed = ($datastop[6]=='CLOSED') ? 1 : 0;
$locked = ($datatopic[10]=='ON') ? 1 : 0;

if (strstr($datatopic[2]," - ")){
list($browsers, $ipsum) = explode(" - ", $datatopic[2]);
} else {
list($browsers, $ipsum) = explode(", ", $datatopic[2]);
}




mysql_query('INSERT INTO `theme` (`forums`, `under`, `name`, `author`, `last`, `time`, `status`, `locked`, `brow`, `ip`, `posts`, `created`) VALUES ( 1, '.$data[0].', "'.$datatopic[3].'", "'.$datastart[0].'", "'.$datatopic[0].'", "'.$datatopic[9].'", '.$closed.', '.$locked.', "'.$browsers.'", "'.$ipsum.'", '.$countspost.', "'.$datastart[9].'");');

$lastid = mysql_insert_id();

mysql_query("UPDATE `theme` SET `first`='".$lastid."' WHERE `id` = '".$lastid."'");


$filespost = file(DATADIR.'dataforum/'.$datatopic[7].'.dat');

foreach ($filespost as $valuespost){
$datapost = explode('|', $valuespost);

$datapost[4] = str_replace('<br>','',$datapost[4]); // такой вот форум

$datapost[4] = preg_replace('|<img src="\.\./images/smiles/(.*?)\.gif" alt="">|',':$1', $datapost[4]);
$datapost[4] = preg_replace('|<img src="\.\./images/smiles2/(.*?)\.gif" alt="">|',':$1', $datapost[4]);


if (strstr($datapost[2]," - ")){
list($browsers, $ipsum) = explode(" - ", $datapost[2]);
} else {
list($browsers, $ipsum) = explode(", ", $datapost[2]);
}





mysql_query ("INSERT INTO `posts` (forums, under, theme, msg, author, author_n, time, brow, ip) VALUES 
(1, ".$data[0].", ".$lastid.", '".$datapost[4]."','".$datapost[0]."','".nickname($datapost[0])."','".$datapost[9]."','".$browsers."','".$ipsum."')");

/* if (mysql_errno()) { 
  echo "MySQL error ".mysql_errno().": ".mysql_error()."<br>"; 
}
 */
}

}

}





 
echo '<b>Апгрейд форума успешно произведен!</b><br />';

echo '<br /><img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php?'.SID.'">На главную</a>'; 

include_once ("../themes/".$config['themes']."/foot.php");

?>