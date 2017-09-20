<?php
#-----------------------------------------------------#
#     ******* night_city  for Wap-Motor 17.0 ******   #
#             Made by   :  dekameron                  #
#               E-mail  :  dekameron.if@gmail.com     #
#                 Site  :  http://mobilni.h2m.ru      #
#                  ICQ  :  490900396                  #
#                 Банка :  WM397061295941             #
#                          R392966157285              #
#                          Z413162534324              #
#-----------------------------------------------------#
echo '</div><div class="c" id="down">';
echo '<br /><a href="'.$config['home'].'/">'.$config['copy'].'</a><br />';
require_once BASEDIR."includes/counters.php";
require_once BASEDIR."includes/gzip_foot.php";
echo '<!--'.MOTOR_VERSION.' version-->';
echo '</div>';
echo '</td></tr></table>';
echo '</body></html>';
ob_end_flush();
exit;
?>
