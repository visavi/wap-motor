<?php
#-----------------------------------------------------#
#          ********* WAP-MOTORS *********             #
#             Made by   :  vasya pupkin               #
#               E-mail  :  vsem@pizdec.ru             #
#                 Site  :  http://pizdec.ru           #
#             WAP-Site  :  http://visavi.net          #
#                  ICQ  :  36-44-66                   #
#  Вы не имеете право вносить изменения в код скрипта #
#-----------------------------------------------------#
echo '</div><div class="lol" id="down">';
echo '<p style="text-align:center">';
echo '<a href="'.$config['home'].'/?'.SID.'">'.$config['copy'].'</a><br />';
require_once BASEDIR."includes/counters.php";
echo '</p>';
echo '</div><div style="text-align:center">';
require_once BASEDIR."includes/gzip_foot.php";
echo '<!--'.MOTOR_VERSION.' version-->';
echo '</div></body></html>';
ob_end_flush();
exit;
?>
