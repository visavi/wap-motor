<?php
echo '</div><div align="center" class="c" id="down">';

echo '<a href="'.$config['home'].'/">'.$config['copy'].'</a><br />';
require_once BASEDIR."includes/counters.php";

echo '[<a href="'.$config['home'].'/">HOME</a> | <a href="'.$config['home'].'/download/">DOWN</a> | <a href="'.$config['home'].'/forum/">FORUM</a> | <a href="'.$config['home'].'/book/">GUEST</a> | <a href="'.$config['home'].'/pages/index.php?action=menu">MAIN</a>]<br />';

require_once BASEDIR."includes/gzip_foot.php";
echo '<!--'.MOTOR_VERSION.' version-->';
echo '</div>';

echo '</td></tr></table>';
echo '</body></html>';
ob_end_flush();
exit;
?>
