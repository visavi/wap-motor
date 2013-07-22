<?php
# -----------------------------------------------------#
#           ********* WAP-MOTORS *********             #
#              Made by   :  VANTUZ                     #
#                E-mail  :  visavi.net@mail.ru         #
#                  Site  :  http://pizdec.ru           #
#              WAP-Site  :  http://visavi.net          #
#                   ICQ  :  36-44-66                   #
#   Вы не имеете право вносить изменения в код скрипта #
#         для его дальнейшего распространения          #
# -----------------------------------------------------#
if (!defined('BASEDIR')) {
	header("Location:../index.php");
	exit;
}

// --------------------------- Функция перевода секунд во время -----------------------------//
function maketime($string) {
	if ($string < 3600) {
		$string = sprintf("%02d:%02d", (int)($string / 60) % 60, $string % 60);
	} else {
		$string = sprintf("%02d:%02d:%02d", (int)($string / 3600) % 24, (int)($string / 60) % 60, $string % 60);
	}
	return $string;
}

// --------------------------- Функция перевода секунд в дни -----------------------------//
function makestime($string) {
	$day = floor($string / 86400);
	$hours = floor(($string / 3600) - $day * 24);
	$min = floor(($string - $hours * 3600 - $day * 86400) / 60);
	$sec = $string - ($min * 60 + $hours * 3600 + $day * 86400);

	return sprintf("%01d дн. %02d:%02d:%02d", $day, $hours, $min, $sec);
}

// --------------------------- Функция временного сдвига -----------------------------//
function date_fixed($timestamp, $format = "d.m.y / H:i") {
	global $config;

	if (!is_numeric($timestamp)) {
		$timestamp = SITETIME;
	}
	$shift = $config['timeclocks'] * 3600;
	$datestamp = date($format, $timestamp + $shift);

	$today = date("d.m.y", SITETIME + $shift);
	$yesterday = date("d.m.y", strtotime("-1 day") + $shift);

	$datestamp = str_replace($today, 'Сегодня', $datestamp);
	$datestamp = str_replace($yesterday, 'Вчера', $datestamp);

	$search = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$replace = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
	$datestamp = str_replace($search, $replace, $datestamp);

	return $datestamp;
}

// ------------------- Функция полного удаления юзера --------------------//
function delete_users($users) {
	$string = search_string(DATADIR."bank.dat", $users, 1);
	if ($string) {
		delete_lines(DATADIR."bank.dat", $string['line']);
	}

	$substring = search_string(DATADIR."subscribe.dat", $users, 3);
	if ($substring) {
		delete_lines(DATADIR."subscribe.dat", $substring['line']);
	}

	if (file_exists(DATADIR."profil/$users.prof")) {
		unlink (DATADIR."profil/$users.prof");
	}
	if (file_exists(DATADIR."privat/$users.priv")) {
		unlink (DATADIR."privat/$users.priv");
	}
	if (file_exists(DATADIR."dataoutput/$users.priv")) {
		unlink (DATADIR."dataoutput/$users.priv");
	}
	if (file_exists(DATADIR."dataavators/$users.gif")) {
		unlink (DATADIR."dataavators/$users.gif");
	}
	if (file_exists(DATADIR."dataraiting/$users.dat")) {
		unlink (DATADIR."dataraiting/$users.dat");
	}
	if (file_exists(DATADIR."dataignor/$users.dat")) {
		unlink (DATADIR."dataignor/$users.dat");
	}
	if (file_exists(DATADIR."datakontakt/$users.dat")) {
		unlink (DATADIR."datakontakt/$users.dat");
	}
	if (file_exists(DATADIR."datalife/$users.dat")) {
		unlink (DATADIR."datalife/$users.dat");
	}

	return $users;
}

// --------------- Функция правильного окончания для денег -------------------//
function moneys($string) {
	$string = (int)$string;

	$str1 = abs($string) % 100;
	$str2 = $string % 10;

	if ($str1 > 10 && $str1 < 20) return $string.' чатлов';
	if ($str2 > 1 && $str2 < 5) return $string.' чатла';
	if ($str2 == 1) return $string.' чатл';

	return $string.' чатлов';
}

// ------------------- Функция очистки файла --------------------//
function clear_files($files) {
	if (file_exists($files)) {
		$file = file($files);
		$fp = fopen($files, "a+");
		flock ($fp, LOCK_EX);
		ftruncate ($fp, 0);
		fflush($fp);
		flock ($fp, LOCK_UN);
		fclose($fp);
	}
}

// ------------------------ Функция записи в файл ------------------------//
function write_files($filename, $text, $clear = 0, $chmod = "") {
	$fp = fopen($filename, "a+");
	flock ($fp, LOCK_EX);
	if ($clear == 1) {
		ftruncate($fp, 0);
	}
	fputs ($fp, $text);
	fflush($fp);
	flock ($fp, LOCK_UN);
	fclose($fp);
	if ($chmod != "") {
		@chmod($filename, $chmod);
	}
}

// ------------------- Функция удаления строк(и) из файла --------------------//
function delete_lines($files, $lines) {
	if ($lines !== "") {
		if (file_exists($files)) {
			if (!is_array($lines)) {
				$data = file($files);

				if (isset($data[$lines])) {
					unset($data[$lines]);
				}

				file_put_contents($files, implode($data), LOCK_EX);

			} else {
				$data = file($files);

				foreach($lines as $val) {
					if (isset($data[$val])) {
						unset($data[$val]);
					}
				}

				file_put_contents($files, implode($data), LOCK_EX);

			}
		}
	}
}

// ------------------- Функция сдига строки в файле --------------------//
function move_lines($files, $lines, $where) {
	if (file_exists($files)) {
		if ($lines !== "") {
			if ($where !== "") {
				if ($where == 1) {
					$lines2 = $lines + 1;
				} else {
					$lines2 = $lines - 1;
				}

				$file = file($files);

				if (isset($file[$lines]) && isset($file[$lines2])) {
					$fp = fopen($files, "a+");
					flock ($fp, LOCK_EX);
					ftruncate ($fp, 0);

					foreach($file as $key => $val) {
						if ($lines == $key) {
							fputs($fp, $file[$lines2]);
						} elseif ($lines2 == $key) {
							fputs($fp, $file[$lines]);
						} else {
							fputs($fp, $val);
						}
					}

					fflush($fp);
					flock ($fp, LOCK_UN);
					fclose($fp);
				}
			}
		}
	}
}

// -------------- Функция перемещение строки вниз списка ----------------//
function shift_lines($file, $line = 0) {

	if (file_exists($file)) {

		$data = file($file);
		if (count($data)>1){

			$read = $data[$line];
			unset($data[$line]);
			array_push($data, $read);

			file_put_contents($file, $data, LOCK_EX);
		}
	}
}

// ------------------- Функция замены строки в файлe --------------------//
function replace_lines($files, $lines, $text) {
	if (file_exists($files)) {
		if ($lines !== "") {
			if ($text != "") {
				$file = file($files);
				$fp = fopen($files, "a+");
				flock ($fp, LOCK_EX);
				ftruncate ($fp, 0);

				foreach($file as $key => $val) {
					if ($lines == $key) {
						fputs($fp, "$text\r\n");
					} else {
						fputs($fp, $val);
					}
				}

				fflush($fp);
				flock ($fp, LOCK_UN);
				fclose($fp);
			}
		}
	}
}

// ------------------- Функция подсчета строк в файле--------------------//
function counter_string($files) {
	$count_lines = 0;
	if (file_exists($files)) {
		$lines = file($files);
		$count_lines = count($lines);
	}
	return $count_lines;
}

// ------------------ Функция проверки ячейки строки в файле ------------------//
function search_string($file, $str, $ceil) {
	if (file_exists($file)) {
		$files = file($file);

		foreach($files as $key => $value) {
			$data = explode("|", $value);

			if ($data[$ceil] == $str) {
				$data['line'] = $key;
				return $data;
				break;
			}
		}
	}

	return false;
}

// ------------------ Функция чтения строки в файле ------------------//
function read_string($file, $line) {
	if (file_exists($file)) {
		$files = file($file);

		if ($line === false) {
			return explode("|", end($files));
		}

		if (isset($files[$line])) {
			return explode("|", $files[$line]);
		}
	}
	return false;
}

// ------------------ Функция подсветки кода -------------------------//
function highlight_code($code) {
	$code = strtr($code, array('&#124;' => '|', '&lt;' => '<', '&gt;' => '>', '&amp;' => '&', '&#36;' => '$', '&quot;' => '"', '&#39;' => "'", '&#92;' => '`', '&#37;' => '%', '&#94;' => '^', '&#58;' => ':', '<br />' => "\r\n"));

	if (!strpos($code, '<?') && substr($code, 0, 2) != '<?') {
		$code = "<?php\r\n".trim($code);
	}

	$code = highlight_string($code, true);

	$code = strtr($code, array("\r\n" => '<br />', '|' => '&#124;', '$' => '&#36;', "'" => '&#39;', '`' => '&#92;', '%' => '&#37;', '^' => '&#94;', ':' => '&#58;'));

	$code = '<div class="d">'.$code.'</div>';
	return $code;
}

// ------------------ Вспомогательная функция для bb-кода --------------------//
function url_replace($m) {
	if (!isset($m[3])) {
		return '<a href="'.$m[1].'">'.$m[2].'</a>';
	} else {
		return '<a href="'.$m[3].'">'.$m[3].'</a>';
	}
}

// ------------------ Функция вставки BB-кода --------------------//
function bb_code($message) {
	$message = preg_replace('#\[code\](.*?)\[/code\]#ie', 'highlight_code("\1")', $message);
	$message = preg_replace('#\[big\](.*?)\[/big\]#si', '<big>\1</big>', $message);
	$message = preg_replace('#\[b\](.*?)\[/b\]#si', '<b>\1</b>', $message);
	$message = preg_replace('#\[i\](.*?)\[/i\]#si', '<i>\1</i>', $message);
	$message = preg_replace('#\[u\](.*?)\[/u\]#si', '<u>\1</u>', $message);
	$message = preg_replace('#\[small\](.*?)\[/small\]#si', '<small>\1</small>', $message);
	$message = preg_replace('#\[red\](.*?)\[/red\]#si', '<span style="color:#ff0000">\1</span>', $message);
	$message = preg_replace('#\[green\](.*?)\[/green\]#si', '<span style="color:#00ff00">\1</span>', $message);
	$message = preg_replace('#\[blue\](.*?)\[/blue\]#si', '<span style="color:#0000ff">\1</span>', $message);
	$message = preg_replace('#\[yellow\](.*?)\[/yellow\]#si', '<span style="color:#ffff00">\1</span>', $message);
	$message = preg_replace('#\[q\](.*?)\[/q\]#si', '<q>\1</q>', $message);
	$message = preg_replace('#\[del\](.*?)\[/del\]#si', '<del>\1</del>', $message);
	$message = preg_replace_callback('~\\[url=(http://.+?)\\](.+?)\\[/url\\]|(http://(www.)?[0-9a-z\.-]+\.[0-9a-z]{2,6}[0-9a-zA-Z/\?\.\~&amp;_=/%-:#]*)~', 'url_replace', $message);
	return $message;
}

// ------------------ Функция перекодировки из UTF в WIN --------------------//
function utf_to_win($str) {
	if (function_exists('mb_convert_encoding')) return mb_convert_encoding($str, 'windows-1251', 'utf-8');
	if (function_exists('iconv')) return iconv('utf-8', 'windows-1251', $str);

	$utf8win1251 = array(
		"А" => "\xC0", "Б" => "\xC1", "В" => "\xC2", "Г" => "\xC3", "Д" => "\xC4", "Е" => "\xC5", "Ё" => "\xA8", "Ж" => "\xC6", "З" => "\xC7", "И" => "\xC8", "Й" => "\xC9", "К" => "\xCA", "Л" => "\xCB", "М" => "\xCC",
		"Н" => "\xCD", "О" => "\xCE", "П" => "\xCF", "Р" => "\xD0", "С" => "\xD1", "Т" => "\xD2", "У" => "\xD3", "Ф" => "\xD4", "Х" => "\xD5", "Ц" => "\xD6", "Ч" => "\xD7", "Ш" => "\xD8", "Щ" => "\xD9", "Ъ" => "\xDA",
		"Ы" => "\xDB", "Ь" => "\xDC", "Э" => "\xDD", "Ю" => "\xDE", "Я" => "\xDF", "а" => "\xE0", "б" => "\xE1", "в" => "\xE2", "г" => "\xE3", "д" => "\xE4", "е" => "\xE5", "ё" => "\xB8", "ж" => "\xE6", "з" => "\xE7",
		"и" => "\xE8", "й" => "\xE9", "к" => "\xEA", "л" => "\xEB", "м" => "\xEC", "н" => "\xED", "о" => "\xEE", "п" => "\xEF", "р" => "\xF0", "с" => "\xF1", "т" => "\xF2", "у" => "\xF3", "ф" => "\xF4", "х" => "\xF5",
		"ц" => "\xF6", "ч" => "\xF7", "ш" => "\xF8", "щ" => "\xF9", "ъ" => "\xFA", "ы" => "\xFB", "ь" => "\xFC", "э" => "\xFD", "ю" => "\xFE", "я" => "\xFF");

	return strtr($str, $utf8win1251);
}

// ------------------ Функция перекодировки из WIN в UTF --------------------//
function win_to_utf($str) {
	if (function_exists('mb_convert_encoding')) return mb_convert_encoding($str, 'utf-8', 'windows-1251');
	if (function_exists('iconv')) return iconv('windows-1251', 'utf-8', $str);

	$win1251utf8 = array(
		"\xC0" => "А", "\xC1" => "Б", "\xC2" => "В", "\xC3" => "Г", "\xC4" => "Д", "\xC5" => "Е", "\xA8" => "Ё", "\xC6" => "Ж", "\xC7" => "З", "\xC8" => "И", "\xC9" => "Й", "\xCA" => "К", "\xCB" => "Л", "\xCC" => "М",
		"\xCD" => "Н", "\xCE" => "О", "\xCF" => "П", "\xD0" => "Р", "\xD1" => "С", "\xD2" => "Т", "\xD3" => "У", "\xD4" => "Ф", "\xD5" => "Х", "\xD6" => "Ц", "\xD7" => "Ч", "\xD8" => "Ш", "\xD9" => "Щ", "\xDA" => "Ъ",
		"\xDB" => "Ы", "\xDC" => "Ь", "\xDD" => "Э", "\xDE" => "Ю", "\xDF" => "Я", "\xE0" => "а", "\xE1" => "б", "\xE2" => "в", "\xE3" => "г", "\xE4" => "д", "\xE5" => "е", "\xB8" => "ё", "\xE6" => "ж", "\xE7" => "з",
		"\xE8" => "и", "\xE9" => "й", "\xEA" => "к", "\xEB" => "л", "\xEC" => "м", "\xED" => "н", "\xEE" => "о", "\xEF" => "п", "\xF0" => "р", "\xF1" => "с", "\xF2" => "т", "\xF3" => "у", "\xF4" => "ф", "\xF5" => "х",
		"\xF6" => "ц", "\xF7" => "ч", "\xF8" => "ш", "\xF9" => "щ", "\xFA" => "ъ", "\xFB" => "ы", "\xFC" => "ь", "\xFD" => "э", "\xFE" => "ю", "\xFF" => "я");

	return strtr($str, $win1251utf8);
}

// ------------------ Функция преобразования в нижний регистр для UTF ------------------//
function rus_utf_tolower($str) {
	if (function_exists('mb_strtolower')) return mb_strtolower($str, 'utf-8');

	$arraytolower = array('А' => 'а', 'Б' => 'б', 'В' => 'в', 'Г' => 'г', 'Д' => 'д', 'Е' => 'е', 'Ё' => 'ё', 'Ж' => 'ж', 'З' => 'з', 'И' => 'и', 'Й' => 'й', 'К' => 'к', 'Л' => 'л', 'М' => 'м', 'Н' => 'н', 'О' => 'о', 'П' => 'п', 'Р' => 'р', 'С' => 'с', 'Т' => 'т', 'У' => 'у', 'Ф' => 'ф', 'Х' => 'х', 'Ц' => 'ц', 'Ч' => 'ч', 'Ш' => 'ш', 'Щ' => 'щ', 'Ь' => 'ь', 'Ъ' => 'ъ', 'Ы' => 'ы', 'Э' => 'э', 'Ю' => 'ю', 'Я' => 'я',
		'A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd', 'E' => 'e', 'I' => 'i', 'F' => 'f', 'G' => 'g', 'H' => 'h', 'J' => 'j', 'K' => 'k', 'L' => 'l', 'M' => 'm', 'N' => 'n', 'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r', 'S' => 's', 'T' => 't', 'U' => 'u', 'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y', 'Z' => 'z');

	return strtr($str, $arraytolower);
}

// ------------------ Функция определения браузера --------------------//
function get_user_agent() {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$agent = check($_SERVER['HTTP_USER_AGENT']);

		if (stripos($agent, 'Avant Browser') !== false) {
			return 'Avant Browser';
		} elseif (stripos($agent, 'Acoo Browser') !== false) {
			return 'Acoo Browser';
		} elseif (stripos($agent, 'MyIE2') !== false) {
			return 'MyIE2';
		} elseif (preg_match('|Iron/([0-9a-z\.]*)|i', $agent, $pocket)) {
			return 'SRWare Iron '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('|Chrome/([0-9a-z\.]*)|i', $agent, $pocket)) {
			return 'Chrome '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('#(Maxthon|NetCaptor)( [0-9a-z\.]*)?#i', $agent, $pocket)) {
			return $pocket[1] . $pocket[2];
		} elseif (stripos($agent, 'Safari') !== false && preg_match('|Version/([0-9]{1,2}.[0-9]{1,2})|i', $agent, $pocket)) {
			return 'Safari '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('#(NetFront|K-Meleon|Netscape|Galeon|Epiphany|Konqueror|Safari|Opera Mini|Opera Mobile)/([0-9a-z\.]*)#i', $agent, $pocket)) {
			return $pocket[1].' '.subtok($pocket[2], '.', 0, 2);
		} elseif (stripos($agent, 'Opera') !== false && preg_match('|Version/([0-9]{1,2}.[0-9]{1,2})|i', $agent, $pocket)) {
			return 'Opera '.$pocket[1];
		} elseif (preg_match('|Opera[/ ]([0-9a-z\.]*)|i', $agent, $pocket)) {
			return 'Opera '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('|Orca/([ 0-9a-z\.]*)|i', $agent, $pocket)) {
			return 'Orca '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('#(SeaMonkey|Firefox|GranParadiso|Minefield|Shiretoko)/([0-9a-z\.]*)#i', $agent, $pocket)) {
			return $pocket[1].' '.subtok($pocket[2], '.', 0, 2);
		} elseif (preg_match('|rv:([0-9a-z\.]*)|i', $agent, $pocket) && strpos($agent, 'Mozilla/') !== false) {
			return 'Mozilla '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('|Lynx/([0-9a-z\.]*)|i', $agent, $pocket)) {
			return 'Lynx '.subtok($pocket[1], '.', 0, 2);
		} elseif (preg_match('|MSIE ([0-9a-z\.]*)|i', $agent, $pocket)) {
			return 'IE '.subtok($pocket[1], '.', 0, 2);
		} else {
			$agent = preg_replace('|http://|i', '', $agent);
			$agent = strtok($agent, '( ');
			$agent = substr($agent, 0, 22);
			$agent = subtok($agent, '.', 0, 2);

			if (!empty($agent)) {
				return $agent;
			}
		}
	}
	return 'Unknown';
}

// ----------------------- Функция экранирования основных знаков --------------------------//
function check($msg) {
	if (is_array($msg)) {
		foreach($msg as $key => $val) {
			$msg[$key] = check($val);
		}
	} else {
		$msg = htmlspecialchars($msg);
		$search = array('|', '\'', '$', '\\', '^', '%', '`', "\0", "\x00", "\x1A", chr(226) . chr(128) . chr(174));
		$replace = array('&#124;', '&#39;', '&#36;', '&#92;', '&#94;', '&#37;', '&#96;', '', '', '', '');

		$msg = str_replace($search, $replace, $msg);
		$msg = stripslashes(trim($msg));
	}

	return $msg;
}

// ----------------------- Функция обрезки строки с условием -------------------------//
function subtok($string, $chr, $pos, $len = null) {
	return implode($chr, array_slice(explode($chr, $string), $pos, $len));
}

// ----------------------- Функция вырезания переноса строки --------------------------//
function no_br($msg, $replace = "") {
	$msg = preg_replace ("|[\r\n]+|si", $replace, $msg);
	return $msg;
}

// ------------------- Функция замены и вывода смайлов -------------------//
function smiles($string) {
	global $config;
	$string = str_replace(':', '&#58;', $string);
	$string = preg_replace('|&#58;|', ':', $string, $config['resmiles']);

	$arrsmiles = array();
	$globsmiles = glob(BASEDIR."images/smiles/*.gif");
	foreach ($globsmiles as $filename) {
		$arrsmiles[] = basename($filename, '.gif');
	}
	rsort($arrsmiles);

	foreach($arrsmiles as $smval) {
		$string = str_replace(":$smval", '<img src="'.BASEDIR.'images/smiles/'.$smval.'.gif" alt="image" /> ', $string);
	}

	if (is_admin(array(101, 102, 103, 105))) {
		$admsmiles = array();
		$globsmiles = glob(BASEDIR."images/smiles2/*.gif");
		foreach ($globsmiles as $filename) {
			$admsmiles[] = basename($filename, '.gif');
		}
		rsort($admsmiles);

		foreach($admsmiles as $smvals) {
			$string = str_replace(":$smvals", '<img src="'.BASEDIR.'images/smiles2/'.$smvals.'.gif" alt="image" /> ', $string);
		}
	}

	return str_replace('&#58;', ':', $string);
}

// --------------- Функция обратной замены смайлов -------------------//
function nosmiles($string) {
	$string = preg_replace('|<img src="\.\./images/smiles/(.*?)\.gif" alt="image" />|', ':$1', $string);
	$string = preg_replace('|<img src="\.\./images/smiles2/(.*?)\.gif" alt="image" />|', ':$1', $string);
	return $string;
}
// --------------- Функция подсчета файлов в загрузках -------------------//
/**
 * function  count_dir($dir) {
 *
 * $count=0;
 * $newcount=0;
 *
 * $path = opendir($dir);
 * while ($file = readdir($path)) {
 * if (( $file != ".")&&($file != "..")&&($file != ".htaccess")&&($file != "index.php")&&($file != "name.dat")&& !ereg (".txt$", "$file")&& !ereg (".JPG$", "$file")&& !ereg (".GIF$", "$file")) {
 *
 * $count ++;
 *
 * $filetime=filemtime("$dir/$file")+(3600*24*5);
 * if($filetime>SITETIME){
 * $newcount ++;
 * }
 * }}
 *
 * if($newcount>0){
 * $input=(int)$count.'/+'.(int)$newcount;
 * }else{
 * $input=(int)$count;
 * }
 *
 * closedir ($path);
 * return  $input;
 * }
 */
// --------------- Функция подсчета файлов в библиотеке -------------------//
/**
 * function  count_libdir($dir) {
 *
 * $count=0;
 * $newcount=0;
 *
 * $path = opendir($dir);
 * while ($file = readdir($path)) {
 * if (ereg(".txt$", $file)){
 *
 * $count ++;
 *
 * $filetime=filemtime("$dir/$file")+(3600*24*5);
 * if($filetime>SITETIME){
 * $newcount ++;
 * }
 * }}
 *
 * if($newcount>0){
 * $input=(int)$count.'/+'.(int)$newcount;
 * }else{
 * $input=(int)$count;
 * }
 *
 * closedir ($path);
 * return  $input;
 * }
 */

// --------------- Функция правильного вывода веса файла -------------------//
function formatsize($file_size) {
	if ($file_size >= 1048576000) {
		$file_size = round(($file_size / 1073741824), 2)." Gb";
	} elseif ($file_size >= 1024000) {
		$file_size = round(($file_size / 1048576), 2)." Mb";
	} elseif ($file_size >= 1000) {
		$file_size = round(($file_size / 1024), 2)." Kb";
	} else {
		$file_size = round($file_size)." byte";
	}
	return $file_size;
}

// --------------- Функция форматированного вывода размера файла -------------------//
function read_file($file) {
	if (file_exists($file)) {
		return formatsize(filesize($file));
	} else {
		return 0;
	}
}

// --------------- Функция подсчета веса директории -------------------//
function read_dir($dir) {
	if (empty($allsize)) {
		$allsize = 0;
	}

	if ($path = opendir($dir)) {
		while ($file_name = readdir($path)) {
			if (($file_name !== '.') && ($file_name !== '..')) {
				if (is_dir($dir."/".$file_name)) {
					$allsize += read_dir($dir."/".$file_name);
				} else {
					$allsize += filesize($dir."/".$file_name);
				}
			}
		}
		closedir ($path);
	}
	return $allsize;
}

// --------------- Функция правильного вывода времени -------------------//
function formattime($file_time) {
	if ($file_time >= 86400) {
		$file_time = round((($file_time / 60) / 60) / 24, 1).' дн.';
	} elseif ($file_time >= 3600) {
		$file_time = round(($file_time / 60) / 60, 1).' час.';
	} elseif ($file_time >= 60) {
		$file_time = round($file_time / 60).' мин.';
	} else {
		$file_time = round($file_time).' сек.';
	}
	return $file_time;
}

// ------------------ Функция антимата --------------------//
function antimat($string) {
	$file = file(DATADIR."antimat.dat");

	if (count($file) > 0) {
		foreach($file as $value) {
			$data = explode("|", $value);

			$string = preg_replace("|$data[0]|iu", "***", $string);
		}
	}

	return $string;
}

// ------------------ Функция определения прав доступа (CHMOD) --------------------//
function permissions($filez) {
	$filez = decoct(fileperms($filez)) % 1000;
	return $filez;
}

// ------------------ Функция правильного вывода статуса --------------------//
function user_status($msg) {
	if ($msg == 101) {
		$status = 'СуперАдмин';
	} elseif ($msg == 102) {
		$status = 'Админ';
	} elseif ($msg == 103) {
		$status = 'Старший модер';
	} elseif ($msg == 105) {
		$status = 'Модер';
	} else {
		$status = 'Пользователь';
	}
	return $status;
}

// ------------------ Функция выводящая картинку в загрузках --------------------//
function raiting_vote($string) {
	if ($string == 0) {
		$string = str_replace('0', '<img src="../images/img/rating0.gif" alt="0"/>', $string);
	}
	if ($string > '0' && $string <= '0.5') {
		$string = str_replace($string, '<img src="../images/img/rating1.gif" alt="0.5"/>', $string);
	}
	if ($string > '0.5' && $string <= '1') {
		$string = str_replace($string, '<img src="../images/img/rating2.gif" alt="1"/>', $string);
	}
	if ($string > '1' && $string <= '1.5') {
		$string = str_replace($string, '<img src="../images/img/rating3.gif" alt="1.5"/>', $string);
	}
	if ($string > '1.5' && $string <= '2') {
		$string = str_replace($string, '<img src="../images/img/rating4.gif" alt="2"/>', $string);
	}
	if ($string > '2' && $string <= '2.5') {
		$string = str_replace($string, '<img src="../images/img/rating5.gif" alt="2.5"/>', $string);
	}
	if ($string > '2.5' && $string <= '3') {
		$string = str_replace($string, '<img src="../images/img/rating6.gif" alt="3"/>', $string);
	}
	if ($string > '3' && $string <= '3.5') {
		$string = str_replace($string, '<img src="../images/img/rating7.gif" alt="3.5"/>', $string);
	}
	if ($string > '3.5' && $string <= '4') {
		$string = str_replace($string, '<img src="../images/img/rating8.gif" alt="4"/>', $string);
	}
	if ($string > '4' && $string <= '4.5') {
		$string = str_replace($string, '<img src="../images/img/rating9.gif" alt="4.5"/>', $string);
	}
	if ($string > '4.5' && $string <= '5') {
		$string = str_replace($string, '<img src="../images/img/rating10.gif" alt="5"/>', $string);
	}
	return $string;
}

// --------------- Функция русского ника -------------------//
function nickname($string) {
	global $config;
	if ($config['includenick'] == 1) {
		if (file_exists(DATADIR."profil/$string.prof")) {
			$text = file_get_contents(DATADIR."profil/$string.prof");

			$data = explode(":||:", $text);

			if ($data[65] != "" && $data[36] >= 150) {
				$string = $data[65];
			}
		}
	}
	return $string;
}


// ------------------------- Функция времени антифлуда ------------------------------//
function flood_period() {
	global $config, $udata;

	$period = $config['floodstime'];

	if ($udata[36] < 50) {
		$period = round($config['floodstime'] * 2);
	}
	if ($udata[36] >= 500) {
		$period = round($config['floodstime'] / 2);
	}
	if ($udata[36] >= 1000) {
		$period = round($config['floodstime'] / 3);
	}
	if ($udata[36] >= 5000) {
		$period = round($config['floodstime'] / 6);
	}
	if (is_admin()) {
		$period = 0;
	}

	return $period;
}

// ------------------------- Функция антифлуда ------------------------------//
function is_flood($log, $period = 0) {
	global $php_self;

	if (empty($period)) {
		$period = flood_period();
	}
	if (empty($period)) {
		return true;
	}

	$result = true;
	$file = file(DATADIR."flooder.dat");
	$fp = fopen(DATADIR."flooder.dat", "a+");
	flock ($fp, LOCK_EX);
	ftruncate ($fp, 0);

	foreach($file as $line) {
		$array = explode("|", $line);

		if (($array[2]) > SITETIME) {
			fputs ($fp, $line);

			if ($array[0] == $log && $array[1] == $php_self) {
				$result = false;
			}
		}
	}

	if ($result){
		fputs ($fp, $log.'|'.$php_self.'|'.(SITETIME + $period)."|\r\n");
	}

	fflush($fp);
	flock ($fp, LOCK_UN);
	fclose($fp);

	return $result;
}

// --------------- Вспомогательная функция антифлуда ------------------------//
/**
 * Не использовать функцию, устаревшее
 */
function flooder($ip, $php_self) {
	global $config;

	$old_db = file(DATADIR."flood.dat");
	$new_db = fopen(DATADIR."flood.dat", "a+");
	flock ($new_db, LOCK_EX);
	ftruncate ($new_db, 0);
	$result = false;

	foreach($old_db as $old_db_line) {
		$old_db_arr = explode("|", $old_db_line);

		if (($old_db_arr[0] + $config['floodstime']) > SITETIME) {
			fputs ($new_db, $old_db_line);

			if ($old_db_arr[1] == $ip && $old_db_arr[2] == $php_self) {
				$result = true;
			}
		}
	}

	fflush($new_db);
	flock ($new_db, LOCK_UN);
	fclose($new_db);
	return $result;
}

// ------------------------- Функция антифлуда ------------------------------//
/**
 * Не использовать функцию, устаревшее
 * Вместо нее if (is_flood($log))
 */
function antiflood($page) {
	global $config, $ip, $php_self;

	if ($config['floodstime'] > 0) {
		if (flooder($ip, $php_self) == true) {
			header ($page);
			exit;
		}
		$flood_file = fopen(DATADIR."flood.dat", "a+");
		flock ($flood_file, LOCK_EX);
		fputs ($flood_file, SITETIME.'|'.$ip.'|'.$php_self."|\r\n");
		fflush($flood_file);
		flock ($flood_file, LOCK_UN);
		fclose($flood_file);
	}
}

// ------------------------- Функция карантина ------------------------------//
function is_quarantine($log) {
	global $config, $udata;

	if (!empty($config['karantin'])) {
		$profil = reading_profil($log);

		if ($profil[6] + $config['karantin'] > SITETIME) {
			return false;
		}
	}
	return true;
}

// ------------------------- Функция карантина ------------------------------//
/**
 * Не использовать функцию, устаревшее
 * Вместо нее if (is_quarantine($log))
 */
function karantin($usertime, $page) {
	global $config;

	if ($config['karantin'] > 0 && $usertime > 0) {
		if ($usertime + $config['karantin'] > SITETIME) {
			header ($page);
			exit;
		}
	}
}

// ------------------ Функция для обработки base64 --------------------//
function safe_encode($string) {
	$data = base64_encode($string);
	$data = str_replace(array('+', '/', '='), array('_', '-', ''), $data);
	return $data;
}

function safe_decode($string) {
	$string = str_replace(array('_', '-'), array('+', '/'), $string);
	$data = base64_decode($string);
	return $data;
}

// ------------------ Функция шифрования по ключу --------------------//
function xoft_encode($string, $key) {
	$result = "";
	for($i = 1; $i <= strlen($string); $i++) {
		$char = substr($string, $i-1, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return safe_encode($result);
}

// ------------------ Функция расшифровки по ключу --------------------//
function xoft_decode($string, $key) {
	$string = safe_decode($string);
	$result = "";
	for($i = 1; $i <= strlen($string); $i++) {
		$char = substr($string, $i - 1, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}

// ------------------ Функция генерирования паролей --------------------//
function generate_password($length = "") {
	if (empty($length)) {
		$length = mt_rand(10, 12);
	}
	$salt = str_split('aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789');

	$makepass = "";
	for ($i = 0; $i < $length; $i++) {
		$makepass .= $salt[array_rand($salt)];
	}
	return $makepass;
}

// ------------------ Функция для читаемого вывода массива --------------------//
function text_dump($var, $level = 0) {
	if (is_array($var)) $type = "array[".count($var)."]";
	else if (is_object($var)) $type = "object";
	else $type = "";
	if ($type) {
		echo $type.'<br />';
		for(Reset($var), $level++; list($k, $v) = each($var);) {
			if (is_array($v) && $k === "GLOBALS") continue;
			for($i = 0; $i < $level * 3; $i++) echo ' ';
			echo '<b>'.htmlspecialchars($k).'</b> => ', text_dump($v, $level);
		}
	} else echo '"', htmlspecialchars($var), '"<br />';
}

function dump($var) {
	if ((is_array($var) || is_object($var)) && count($var)) {
		echo '<pre>', text_dump($var), '</pre>';
	} else {
		echo '<tt>', text_dump($var), '</tt>';
	}
}

// ------------------ Функция кодировки-раскодировки юникода --------------------//
$uniarray1 = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'Ё', 'ё');

$uniarray2 = array('&#1040;', '&#1041;', '&#1042;', '&#1043;', '&#1044;', '&#1045;', '&#1046;', '&#1047;', '&#1048;', '&#1049;', '&#1050;', '&#1051;', '&#1052;', '&#1053;', '&#1054;', '&#1055;', '&#1056;', '&#1057;', '&#1058;', '&#1059;', '&#1060;', '&#1061;', '&#1062;', '&#1063;', '&#1064;', '&#1065;', '&#1066;', '&#1067;', '&#1068;', '&#1069;', '&#1070;', '&#1071;', '&#1072;', '&#1073;', '&#1074;', '&#1075;', '&#1076;', '&#1077;', '&#1078;', '&#1079;', '&#1080;', '&#1081;', '&#1082;', '&#1083;', '&#1084;', '&#1085;', '&#1086;', '&#1087;', '&#1088;', '&#1089;', '&#1090;', '&#1091;', '&#1092;', '&#1093;', '&#1094;', '&#1095;', '&#1096;', '&#1097;', '&#1098;', '&#1099;', '&#1100;', '&#1101;', '&#1102;', '&#1103;', '&#1025;', '&#1105;');

function unicode_encode($string) {
	global $uniarray1, $uniarray2;
	$string = str_replace($uniarray1, $uniarray2, $string);
	return $string;
}

function unicode_decode($string) {
	global $uniarray1, $uniarray2;
	$string = str_replace($uniarray2, $uniarray1, $string);
	return $string;
}

// --------------- Функция листинга всех файлов и папок ---------------//
function scan_check($dirname) {
	global $arr, $config;

	if (empty($arr['files'])) {
		$arr['files'] = array();
	}
	if (empty($arr['totalfiles'])) {
		$arr['totalfiles'] = 0;
	}
	if (empty($arr['totaldirs'])) {
		$arr['totaldirs'] = 0;
	}

	$no_check = explode(',', $config['nocheck']);

	$dir = opendir($dirname);
	while (($file = readdir($dir)) !== false) {
		if ($file != "." && $file != "..") {
			if (is_file($dirname.'/'.$file)) {
				$ext = strtolower(substr($file, strrpos($file, '.') + 1));

				if (!in_array($ext, $no_check)) {
					$arr['files'][] = $dirname.'/'.$file.' - '.date_fixed(filemtime($dirname.'/'.$file), "j.m.y / H:i").' - '.formatsize(filesize($dirname.'/'.$file));
					$arr['totalfiles']++;
				}
			}

			if (is_dir($dirname.'/'.$file)) {
				$arr['files'][] = $dirname.'/'.$file;
				$arr['totaldirs']++;
				scan_check($dirname.'/'.$file);
			}
		}
	}

	closedir($dir);

	return $arr;
}

// --------------- Функция вывода календаря---------------//
function makeCal ($month, $year) {
	$wday = date("w", mktime(0, 0, 0, $month, 1, $year));
	if ($wday == 0) {
		$wday = 7;
	}
	$n = - ($wday-2);
	$cal = array();
	for ($y = 0; $y < 6; $y++) {
		$row = array();
		$notEmpty = false;
		for ($x = 0; $x < 7; $x++, $n++) {
			if (checkdate($month, $n, $year)) {
				$row[] = $n;
				$notEmpty = true;
			} else {
				$row[] = "";
			}
		}
		if (!$notEmpty) break;
		$cal[] = $row;
	}
	return $cal;
}

// --------------- Функция выключения графики ---------------//
/**
 * function disable_img($image){
 * $image = nosmiles($image);
 * $image = preg_replace('|<img src="(.*?)" alt="image" /><br />|','', $image);
 * $image = preg_replace('|<img src="(.*?)" alt="image" />|','', $image);
 * return $image;
 * }
 */

// ------------------------- Функция проверки аккаунта  ------------------------//
function check_user($login) {
	if (file_exists(DATADIR."profil/$login.prof")) {
		return true;
	}

	return false;
}

// --------------- Функция подсчета денег у юзера ---------------//
function user_many($login) {
	$prof_summ = 0;
	$bank_summ = 0;

	if (file_exists(DATADIR."profil/$login.prof")) {
		$text = file_get_contents(DATADIR."profil/$login.prof");
		$data = explode(":||:", $text);
		$prof_summ = (int)$data[41];
	}

	$string = search_string(DATADIR."bank.dat", $login, 1);
	if ($string) {
		$bank_summ = (int)$string[2];
	}

	return $prof_summ.'/'.$bank_summ;
}

// --------------- Функция подсчета денег в банке ---------------//
function user_bankmany($login) {
	$bank_summ = 0;

	$string = search_string(DATADIR."bank.dat", $login, 1);
	if ($string) {
		$bank_summ = (int)$string[2];
	}

	return $bank_summ;
}

// --------------- Функция подсчета писем у юзера ---------------//
function user_mail($login) {
	$all_privat = counter_string(DATADIR."privat/$login.priv");

	$new_privat = 0;

	if (file_exists(DATADIR."profil/$login.prof")) {
		$text = file_get_contents(DATADIR."profil/$login.prof");
		$data = explode(":||:", $text);
		$new_privat = (int)$data[10];
	}

	return $new_privat.'/'.$all_privat;
}

// --------------- Функция подсчета здоровья персонажа ---------------//
function user_health($login) {
	$health = 0;

	if (file_exists(DATADIR."profil/$login.prof")) {
		$text = file_get_contents(DATADIR."profil/$login.prof");
		$data = explode(":||:", $text);
		$health = (int)$data[56].'%';
	}

	return $health;
}

// --------------- Функция подсчета выносливости персонажа ---------------//
function user_stamina($login) {
	$stamina = 0;

	if (file_exists(DATADIR."profil/$login.prof")) {
		$text = file_get_contents(DATADIR."profil/$login.prof");
		$data = explode(":||:", $text);
		$stamina = (int)$data[57].'%';
	}

	return $stamina;
}

// --------------- Функция вывода аватара пользователя ---------------//
function user_avatars($login) {
	global $config;

	if ($login == $config['guestsuser']) {
		return '<img src="'.BASEDIR.'images/avators/guest.gif" alt="image" /> ';
	}

	if (file_exists(DATADIR."profil/$login.prof")) {
		$text = file_get_contents(DATADIR."profil/$login.prof");
		$data = explode(":||:", $text);

		if ($data[43] != "") {
			return '<img src="'.BASEDIR.$data[43].'" alt="image" /> ';
		}
	}

	return '<img src="'.BASEDIR.'images/avators/noavatar.gif" alt="image" /> ';
}

// --------------- Функция подсчета карт в игре ---------------//
function cards_score($str) {
	if ($str == 1 || $str == 2 || $str == 3 || $str == 4) {
		$num = 6;
	}
	if ($str == 5 || $str == 6 || $str == 7 || $str == 8) {
		$num = 7;
	}
	if ($str == 9 || $str == 10 || $str == 11 || $str == 12) {
		$num = 8;
	}
	if ($str == 13 || $str == 14 || $str == 15 || $str == 16) {
		$num = 9;
	}
	if ($str == 17 || $str == 18 || $str == 19 || $str == 20) {
		$num = 10;
	}
	if ($str == 21 || $str == 22 || $str == 23 || $str == 24) {
		$num = 2;
	}
	if ($str == 25 || $str == 26 || $str == 27 || $str == 28) {
		$num = 3;
	}
	if ($str == 29 || $str == 30 || $str == 31 || $str == 32) {
		$num = 4;
	}
	if ($str == 33 || $str == 34 || $str == 35 || $str == 36) {
		$num = 11;
	}
	return $num;
}

// --------------- Функция подсчета очков в игре ---------------//
function cards_points($str) {
	$str = (int)$str;
	$points = ' очков';
	if ($str == 2 || $str == 3 || $str == 4 || $str == 22 || $str == 23 || $str == 24 | $str == 32 || $str == 33 || $str == 34) {
		$points = ' очка';
	}
	if ($str == 21) {
		$points = ' <b>очко!!!</b>';
	}
	if ($str == 31) {
		$points = ' очко';
	}
	return $str.$points;
}

// --------------- Функция вывода статуса ---------------//
function user_ststuses($balls) {
	$text = file_get_contents(DATADIR."status.dat");
	if ($text != "") {
		$udta = explode("|", $text);
	}
	if ($balls >= 0 && $balls < 5) {
		$statuses = $udta[0];
	}
	if ($balls >= 5 && $balls < 10) {
		$statuses = $udta[1];
	}
	if ($balls >= 10 && $balls < 20) {
		$statuses = $udta[2];
	}
	if ($balls >= 20 && $balls < 50) {
		$statuses = $udta[3];
	}
	if ($balls >= 50 && $balls < 100) {
		$statuses = $udta[4];
	}
	if ($balls >= 100 && $balls < 250) {
		$statuses = $udta[5];
	}
	if ($balls >= 250 && $balls < 500) {
		$statuses = $udta[6];
	}
	if ($balls >= 500 && $balls < 750) {
		$statuses = $udta[7];
	}
	if ($balls >= 750 && $balls < 1000) {
		$statuses = $udta[8];
	}
	if ($balls >= 1000 && $balls < 1250) {
		$statuses = $udta[9];
	}
	if ($balls >= 1250 && $balls < 1500) {
		$statuses = $udta[10];
	}
	if ($balls >= 1500 && $balls < 1750) {
		$statuses = $udta[11];
	}
	if ($balls >= 1750 && $balls < 2000) {
		$statuses = $udta[12];
	}
	if ($balls >= 2000 && $balls < 2250) {
		$statuses = $udta[13];
	}
	if ($balls >= 2250 && $balls < 2500) {
		$statuses = $udta[14];
	}
	if ($balls >= 2500 && $balls < 2750) {
		$statuses = $udta[15];
	}
	if ($balls >= 2750 && $balls < 3000) {
		$statuses = $udta[16];
	}
	if ($balls >= 3000 && $balls < 3250) {
		$statuses = $udta[17];
	}
	if ($balls >= 3250 && $balls < 3499) {
		$statuses = $udta[18];
	}
	if ($balls >= 3500 && $balls < 4999) {
		$statuses = $udta[19];
	}
	if ($balls >= 5000 && $balls < 7499) {
		$statuses = $udta[20];
	}
	if ($balls >= 7500 && $balls < 9999) {
		$statuses = $udta[21];
	}
	if ($balls >= 10000) {
		$statuses = $udta[22];
	}
	$statuses = check($statuses);

	return $statuses;
}

// --------------- Функция подсчета человек в контакт-листе ---------------//
function user_kontakt($login) {
	return counter_string(DATADIR."datakontakt/$login.dat");
}

// --------------- Функция подсчета человек в игнор-листе ---------------//
function user_ignor($login) {
	return counter_string(DATADIR."dataignor/$login.dat");
}

// --------------- Функция вывода количества зарегистрированных ---------------//
function stats_users() {
	return counter_string(DATADIR.'datatmp/userlist.dat');
}

// --------------- Функция вывода количества админов и модеров --------------------//
function stats_admins() {
	return counter_string(DATADIR.'datatmp/adminlist.dat');
}

// --------------- Функция вывода количества забаненных --------------------//
function stats_banned() {
	return counter_string(DATADIR.'datatmp/banlist.dat');
}

// ------------ Функция вывода количества ожидающих регистрации -----------//
function stats_reglist() {
	return counter_string(DATADIR.'datatmp/reglist.dat');
}

// --------------- Функция вывода количества забаненных IP --------------------//
function stats_ipbanned() {
	return counter_string(DATADIR.'ban.dat');
}

// --------------- Функция вывода количества фотографий --------------------//
function stats_gallery() {
	return counter_string(DATADIR.'datagallery/fotobase.dat');
}

// --------------- Функция вывода количества новостей--------------------//
function stats_allnews() {
	return counter_string(DATADIR.'news.dat');
}

// ---------- Функция вывода количества запрещенных логинов ------------//
function stats_blacklogin() {
	return counter_string(DATADIR.'blacklogin.dat');
}

// ------------ Функция вывода количества запрещенных e-mail------------//
function stats_blackmail() {
	return counter_string(DATADIR.'blackmail.dat');
}

// --------------- Функция вывода количества заголовков ----------------//
function stats_headlines() {
	return counter_string(DATADIR.'headlines.dat');
}

// --------------- Функция вывода количества заголовков ----------------//
function stats_navigation() {
	return counter_string(DATADIR.'navigation.dat');
}

// --------------- Функция вывода количества заголовков ----------------//
function stats_antimat() {
	return counter_string(DATADIR.'antimat.dat');
}

// ----------- Функция вывода даты последнего сканирования -------------//
function stats_checker() {
	if (file_exists(DATADIR."datatmp/checker.dat")) {
		return date_fixed(filemtime(DATADIR."datatmp/checker.dat"), "j.m.y");
	} else {
		return 0;
	}
}

// ----------- Функция определения последней версии wap-motor ------------//
function stats_version() {
	$info = 0;
	$filtime = 0;

	if (file_exists(DATADIR."datatmp/version.dat")) {
		$filtime = filemtime(DATADIR."datatmp/version.dat") + 86400;
		$info = file_get_contents(DATADIR."datatmp/version.dat");
	}

	if (time() > $filtime) {
		if (copy("http://visavi.net/wap-motor/version.txt", DATADIR."datatmp/version.dat")) {
			@chmod(DATADIR."datatmp/version.dat", 0666);
		} else {
			write_files(DATADIR."datatmp/version.dat", 0, 1, 0666);
		}
	}

	return $info;
}

// ----------------- Функция определения местонахождения -----------------//
function user_position($string) {
	$position = 'Не определено';

	if (file_exists(DATADIR."headlines.dat")) {
		$file = file(DATADIR."headlines.dat");

		foreach($file as $value) {
			$line = explode("|", $value);

			if ($string == $line[1]) {
				$position = '<a href="'.BASEDIR.$line[1].'?'.SID.'">'.$line[2].'</a>';
				break;
			}
		}
	}

	return $position;
}

// --------------- Функция автоустановки прав доступа ---------------//
function chmode ($path = ".") {
	if ($handle = opendir ($path)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$file_path = $path."/".$file;

				if (is_dir ($file_path)) {
					$old = umask(0);
					chmod ($file_path, 0777);
					umask($old);

					chmode ($file_path);
				} else {
					chmod ($file_path, 0666);
				}
			}
		}

		closedir($handle);
	}
}

// --------------- Функция определение онлайн-статуса ---------------//
function user_online($login) {
	$statwho = '<span style="color:#ff0000">[Off]</span>';

	if (file_exists(DATADIR."datalife/$login.dat")) {
		$lifefile = file_get_contents(DATADIR."datalife/$login.dat");
		if ($lifefile != "") {
			$lifestr = explode("|", $lifefile);
			$userlife = SITETIME - $lifestr[0];

			if ($userlife < 600) {
				$statwho = '<span style="color:#00ff00">[On]</span>';
			}
		}
	}
	return $statwho;
}

// ---- Функция определение последнего посещения и местонахождения -----//
function user_visit($login, $where = "") {
	if (file_exists(DATADIR."datalife/$login.dat")) {
		$lifefile = file_get_contents(DATADIR."datalife/$login.dat");
		if ($lifefile != "") {
			$lifestr = explode("|", $lifefile);
			$userlife = SITETIME - $lifestr[0];

			if ($userlife < 600) {
				$visit = '(Сейчас на сайте)';
				$whereuser = user_position($lifestr[3]);
			} else {
				$visit = '(Последнее посещение '.date_fixed($lifestr[0]).')';
				$whereuser = 'Оффлайн';
			}
			if ($where == "") {
				return $visit;
			} else {
				return $whereuser;
			}
		}
	} else {
		return 'Оффлайн';
	}
}

// --------------- Функции сжатия страниц ---------------//
function compress_output_gzip($output) {
	return gzencode($output, 5);
}

function compress_output_deflate($output) {
	return gzdeflate($output, 5);
}

// ---------- Функция обработки строк данных и ссылок ---------//
function check_string($string) {
	$string = strtolower($string);
	$string = str_replace(array('http://www.', 'http://wap.', 'http://', 'https://'), '', $string);
	$string = strtok($string, '/?');
	return $string;
}

// ---------- Функция определение должности юзера ---------//
function user_title($login) {
	if (file_exists(DATADIR."profil/$login.prof")) {
		$text = file_get_contents(DATADIR."profil/$login.prof");

		$data = explode(":||:", $text);
		if ($data[7] >= 101 && $data[7] <= 105) {
			if ($data[7] == 101) {
				$title = '<span style="color:#0000ff">[СуперАдмин]</span>';
			}
			if ($data[7] == 102) {
				$title = '<span style="color:#0000ff">[Админ]</span>';
			}
			if ($data[7] == 103) {
				$title = '<span style="color:#ff8000">[Старший модер]</span>';
			}
			if ($data[7] == 105) {
				$title = '<span style="color:#ff8000">[Модер]</span>';
			}
			return $title;
		}
	}
}

// ---------- Аналог функции substr для UTF-8 ---------//
function utf_substr($str, $offset, $length = null) {
	if ($length === null) {
		$length = utf_strlen($str);
	}
	if (function_exists('mb_substr')) return mb_substr($str, $offset, $length, 'utf-8');
	if (function_exists('iconv_substr')) return iconv_substr($str, $offset, $length, 'utf-8');

	$str = utf_to_win($str);
	$str = substr($str, $offset, $length);
	return win_to_utf($str);
}

// ---------------------- Аналог функции strlen для UTF-8 -----------------------//
function utf_strlen($str) {
	if (function_exists('mb_strlen')) return mb_strlen($str, 'utf-8');
	if (function_exists('iconv_strlen')) return iconv_strlen($str, 'utf-8');
	if (function_exists('utf8_decode')) return strlen(utf8_decode($str));
	return strlen(utf_to_win($str));
}

// ---------- Аналог функции wordwrap для UTF-8 ---------//
function utf_wordwrap($str, $width = 75, $break = ' ', $cut = 1) {
	$str = utf_to_win($str);
	$str = wordwrap($str, $width, $break, $cut);
	return win_to_utf($str);
}

// ----------------------- Функция определения кодировки ------------------------//
function is_utf($str) {
	$c = 0;
	$b = 0;
	$bits = 0;
	$len = strlen($str);
	for($i = 0; $i < $len; $i++) {
		$c = ord($str[$i]);
		if ($c > 128) {
			if (($c >= 254)) return false;
			elseif ($c >= 252) $bits = 6;
			elseif ($c >= 248) $bits = 5;
			elseif ($c >= 240) $bits = 4;
			elseif ($c >= 224) $bits = 3;
			elseif ($c >= 192) $bits = 2;
			else return false;
			if (($i + $bits) > $len) return false;
			while ($bits > 1) {
				$i++;
				$b = ord($str[$i]);
				if ($b < 128 || $b > 191) return false;
				$bits--;
			}
		}
	}
	return true;
}

// --------------------- Функция вырезания битых символов UTF -------------------//
function utf_badstrip($str) {
	$ret = '';
	for ($i = 0;$i < strlen($str);) {
		$tmp = $str{$i++};
		$ch = ord($tmp);
		if ($ch > 0x7F) {
			if ($ch < 0xC0) continue;
			elseif ($ch < 0xE0) $di = 1;
			elseif ($ch < 0xF0) $di = 2;
			elseif ($ch < 0xF8) $di = 3;
			elseif ($ch < 0xFC) $di = 4;
			elseif ($ch < 0xFE) $di = 5;
			else continue;

			for ($j = 0;$j < $di;$j++) {
				$tmp .= $ch = $str{$i + $j};
				$ch = ord($ch);
				if ($ch < 0x80 || $ch > 0xBF) continue 2;
			}
			$i += $di;
		}
		$ret .= $tmp;
	}
	return $ret;
}

// ----------------------- Функция уникального ID по времени ------------------------//
function unitime() {
	$microtime = explode(' ', microtime());

	$unitime = $microtime[1].substr($microtime[0], 2, 2) ;

	return $unitime;
}

// ----------------------- Функция уникального ID по данным из файла ------------------------//
function unifile($file, $ceil) {
	if (file_exists($file)) {
		if ($ceil !== "") {
			$arrdata = array(0);

			$files = file($file);
			foreach($files as $value) {
				$data = explode("|", $value);

				if (isset($data[$ceil])) {
					$arrdata[] = (int)$data[$ceil];
				}
			}

			return max($arrdata) + 1;
		}
	}

	return 1;
}

// ----------------------- Функция отправки письма по e-mail ------------------------//
function addmail($mail, $subject, $messages, $sendermail="", $sendername="") {
	global $config;

	if (empty($sendermail)) {
		$sendermail = $config['emails'];
		$sendername = $config['nickname'];
	}

	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';

	$adds = "From: =?UTF-8?B?".base64_encode($sendername)."?= <".$sendermail.">\n";
	$adds .= "X-sender: =?UTF-8?B?".base64_encode($sendername)."?= <".$sendermail.">\n";
	$adds .= "Content-Type: text/plain; charset=utf-8\n";
	$adds .= "MIME-Version: 1.0\n";
	$adds .= "Content-Transfer-Encoding: 8bit\n";
	$adds .= "X-Mailer: PHP v.".phpversion()."\n";
	$adds .= "Date: ".date("r")."\n";

	return mail($mail, $subject, $messages, $adds);
}

// ----------------------- Постраничная навигация (Переходы) ------------------------//
function page_jumpnavigation($link, $posts, $start, $total) {
	echo '<hr />';
	if ($start != 0) {
		echo '<a href="'.$link.'start='.($start - $posts).'&amp;'.SID.'">&lt;-Назад</a> ';
	} else {
		echo '&lt;-Назад';
	}
	echo ' | ';
	if ($total > $start + $posts) {
		echo '<a href="'.$link.'start='.($start + $posts).'&amp;'.SID.'">Далее-&gt;</a>';
	} else {
		echo 'Далее-&gt;';
	}
}

// ----------------------- Постраничная навигация ------------------------//
function page_strnavigation($link, $posts, $start, $total, $range = 3){

	if ($total > 0) {

	   $pg_cnt = ceil($total / $posts);
	   $cur_page = ceil(($start + 1) / $posts);
		$idx_fst = max($cur_page - $range, 1);
		$idx_lst = min($cur_page + $range, $pg_cnt);

		$res = 'Страницы: ';

		if ($cur_page != 1) {
			$res .='<a href="'.$link.'start='.($cur_page - 2) * $posts.'&amp;'.SID.'" title="Назад">&laquo;</a> ';
		}

	   if (($start - $posts) >= 0) {
	      if ($cur_page > ($range + 1)) {
	         $res .= ' <a href="'.$link.'start=0&amp;'.SID.'">1</a> ';
	         if ($cur_page != ($range + 2)) {
	            $res .= ' ... ';
	         }
	      }
	   }

		for ($i = $idx_fst; $i <= $idx_lst; $i++) {
			$offset_page = ($i - 1) * $posts;
			if ($i == $cur_page) {
				$res .= ' <span class="navcurrent">'.$i.'</span> ';
			} else {
				$res .= ' <a href="'.$link.'start='.$offset_page.'&amp;'.SID.'">'.$i.'</a> ';
			}
		}

	   if (($start + $posts) < $total) {
	      if ($cur_page < ($pg_cnt - $range)) {
	         if ($cur_page != ($pg_cnt - $range - 1)) {
	            $res .= ' ... ';
	         }
	         $res .= ' <a href="'.$link.'start='.($pg_cnt - 1) * $posts.'&amp;'.SID.'">'.$pg_cnt.'</a> ';
	      }
	   }

		if ($cur_page != $pg_cnt) {
			$res .= ' <a href="'.$link.'start='.($cur_page * $posts).'&amp;'.SID.'" title="Вперед">&raquo;</a>';
		}

		echo '<hr /><div class="nav">'.$res.'</div>';
	}
}

// ----------------------- Вывод страниц в форуме ------------------------//
function forum_navigation($link, $posts, $total) {
	if ($total > 0) {
		$ba = ceil($total / $posts);
		$ba2 = $ba * $posts - $posts;
		$max = $posts * 5;

		for($i = 0; $i < $max;) {
			if ($i < $total && $i >= 0) {
				$ii = floor(1 + $i / $posts);
				echo ' <a href="'.$link.'start='.$i.'&amp;'.SID.'">'.$ii.'</a> ';
			}

			$i += $posts;
		}

		if ($max < $total) {
			if ($max + $posts < $total) {
				echo ' ... <a href="'.$link.'start='.$ba2.'&amp;'.SID.'">'.$ba.'</a>';
			} else {
				echo ' <a href="'.$link.'start='.$ba2.'&amp;'.SID.'">'.$ba.'</a>';
			}
		}

		echo '<br />';
	}
}

// --------------------- Функция динамических заголовков ------------------------//
function site_title($string) {
	global $config, $header_title;

	$position = $config['title'];

	if (file_exists(DATADIR."headlines.dat")) {
		$headlines = search_string(DATADIR."headlines.dat", $string, 1);
		if ($headlines) {
			$position .= ' - '.$headlines[2];
		}
	}
	if ($header_title) {
		$position .= ' - '.$header_title;
	}

	return $position;
}

// --------------------- Функция подсчета статистики ------------------------//
function statistics($number, $clear = false) {
	/*
	0 - Сообщений в гостевой
	1 - Тем в форуме
	2 - Сообщений в форуме
	3 - Комментарий в новостях
	4 - Сообщений в админ-чате
	5 - Комментарий в загрузках
	6 - Комментарий в библиотеке
	7 - Комментарий в галерее
	8 - Сообщений в чате
	*/

	if (isset($number)) {
		$number = (int)$number;

		$file = file_get_contents(DATADIR."local.dat");
		$u = explode("|", $file);

		if ($clear === false) {
			$u[$number]++;
		} else {
			$u[$number] = $clear;
		}

		$data = $u[0].'|'.$u[1].'|'.$u[2].'|'.$u[3].'|'.$u[4].'|'.$u[5].'|'.$u[6].'|'.$u[7].'|'.$u[8].'|'.$u[9].'|'.$u[10].'|';

		if ($data != "" && $u[$number] !== "") {
			file_put_contents(DATADIR."local.dat", $data, LOCK_EX);
			unset($number);
		}
	}
}

// --------------------- Функция вывода статистики ------------------------//
function stats($number) {
	if (isset($number)) {
		$file = file_get_contents(DATADIR."local.dat");
		$data = explode("|", $file);
		return (int)$data[$number];
	}
}

// --------------------- Функция вывода статистики форума ------------------------//
function stats_forum() {
	$allthem = 0;
	$allpost = 0;

	if (file_exists(DATADIR."dataforum/mainforum.dat")) {
		$file = file(DATADIR."dataforum/mainforum.dat");

		foreach ($file as $val) {
			$data = explode('|', $val);

			$allthem += $data[2];
			$allpost += $data[3];
		}
	}
	return $allthem.'/'.$allpost;
}

// --------------------- Функция шифровки Email-адреса ------------------------//
function crypt_mail($mail) {
	$output = "";
	$strlen = strlen($mail);
	for ($i = 0; $i < $strlen; $i++) {
		$output .= '&#'.ord($mail[$i]).';';
	}
	return $output;
}

// ------------------ Аналог функции scandir для PHP4 ------------------//
function scandirs($dir, $sortorder = 0) {
	if (is_dir($dir)) {
		if (function_exists('scandir')) {
			$files = scandir($dir, $sortorder);
			return $files;
		}

		$dirlist = opendir($dir);
		$files = array();
		while (($file = readdir($dirlist)) !== false) {
			$files[] = $file;
		}
		closedir($dirlist);
		if ($sortorder == 0) {
			sort($files);
		} else {
			rsort($files);
		}
		return $files;
	} else {
		return false;
	}
}

// ------------------- Функция обработки массива (int) --------------------//
function intar($string) {
	if (is_array($string)) {
		$newstring = array_map('intval', $string);
	} else {
		$newstring = (int)$string;
	}

	return $newstring;
}

// ------------------- Функция подсчета голосований --------------------//
function stats_votes() {
	$sum = 0;
	if (file_exists(DATADIR."datavotes/result.dat")) {
		$vresult = file(DATADIR."datavotes/result.dat");
		$vr = explode("|", $vresult[0]);
		if ($vresult) {
			$sum = array_sum($vr);
		}
	}
	return (int)$sum;
}

// ------------------- Функция подсчета объявлений --------------------//
function stats_board() {
	$itogoboards = 0;
	if (file_exists(DATADIR."databoard/database.dat")) {
		$file = file(DATADIR."databoard/database.dat");
		foreach($file as $bval) {
			$dtb = explode("|", $bval);
			if (file_exists(DATADIR."databoard/$dtb[2].dat")) {
				$total = counter_string(DATADIR."databoard/$dtb[2].dat");
				$itogoboards += $total;
			}
		}
	}
	return (int)$itogoboards;
}

// ------------------- Функция показа даты последней новости --------------------//
function stats_news() {
	$file = file(DATADIR."news.dat");
	$data = explode("|", end($file));

	if (isset($data[3])) {
		$newdate = date_fixed($data[3], "d.m.y");
		if ($newdate == 'Сегодня') {
			$newdate = '<span style="color:#ff0000">Сегодня</span>';
		}
	} else {
		$newdate = 0;
	}

	return $newdate;
}

// ------------------- Функция вывода последних новостей --------------------//
function last_news() {
	global $config;

	if ($config['lastnews'] > 0) {
		$file = file(DATADIR."news.dat");
		$file = array_reverse($file);
		$count = count($file);

		if ($config['lastnews'] > $count) {
			$config['lastnews'] = count;
		}

		for ($i = 0; $i < $config['lastnews']; $i++) {
			$dt = explode("|", $file[$i]);

			echo '<br /><img src="'.BASEDIR.'images/img/news.gif" alt="image" /> <b>'.$dt[0].'</b> ('.date_fixed($dt[3], "d.m.y").')<br />';

			echo bb_code($dt[1]).'<br /><a href="'.BASEDIR.'news/komm.php?id='.(int)$dt[5].'&amp;'.SID.'">Комментарии</a> ';

			$totalkomm = counter_string(DATADIR."datakomm/$dt[5].dat");

			echo '('.(int)$totalkomm.')';
		}
	}
}

// ------------------- Функция присоединения идентификатора --------------------//
function verifi($link) {
	if (strpos($link, '?') === false) {
		return $link.'?'.SID;
	} else {
		return $link.'&'.SID;
	}
}

// ------------------------- Функция stripos для php4 ------------------------//
if (!function_exists("stripos")) {
	function stripos($str, $needle, $offset = 0) {
		return strpos(strtolower($str), strtolower($needle), $offset);
	}
}

// ------------------------- Функция вывода пользовательских тегов ------------------------//
function quickcode() {
	echo 'BB-код<br />';
	echo '<a href="#form" onclick="javascript:tag(\'[url=]\', \'[/url]\');"><img src="'.BASEDIR.'images/editor/a.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[b]\', \'[/b]\');"><img src="'.BASEDIR.'images/editor/b.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[big]\', \'[/big]\');"><img src="'.BASEDIR.'images/editor/big.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[small]\', \'[/small]\');"><img src="'.BASEDIR.'images/editor/small.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[i]\', \'[/i]\');"><img src="'.BASEDIR.'images/editor/i.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[u]\', \'[/u]\');"><img src="'.BASEDIR.'images/editor/u.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[q]\', \'[/q]\');"><img src="'.BASEDIR.'images/editor/q.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[del]\', \'[/del]\');"><img src="'.BASEDIR.'images/editor/del.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[code]\', \'[/code]\');"><img src="'.BASEDIR.'images/editor/code.gif" alt="image" /></a>';

	echo '<a href="#form" onclick="javascript:tag(\'[red]\', \'[/red]\');"><img src="'.BASEDIR.'images/editor/red.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[green]\', \'[/green]\');"><img src="'.BASEDIR.'images/editor/green.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[blue]\', \'[/blue]\');"><img src="'.BASEDIR.'images/editor/blue.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'[yellow]\', \'[/yellow]\');"><img src="'.BASEDIR.'images/editor/yellow.gif" alt="image" /></a>';
	echo '<br />';
}

// ------------------------- Функция вывода админских тегов ------------------------//
function quicktags() {
	echo 'Быстрые теги <br />';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;a href=&quot;&quot;&gt;\', \'&lt;/a&gt;\');"><img src="'.BASEDIR.'images/editor/a.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;img src=&quot;\', \'&quot; alt=&quot;image&quot; /&gt;\');"><img src="'.BASEDIR.'images/editor/img.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;br /&gt;\', \'\');"><img src="'.BASEDIR.'images/editor/br.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;hr /&gt;\', \'\');"><img src="'.BASEDIR.'images/editor/hr.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;b&gt;\', \'&lt;/b&gt;\');"><img src="'.BASEDIR.'images/editor/b.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;big&gt;\', \'&lt;/big&gt;\');"><img src="'.BASEDIR.'images/editor/big.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;small&gt;\', \'&lt;/small&gt;\');"><img src="'.BASEDIR.'images/editor/small.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;i&gt;\', \'&lt;/i&gt;\');"><img src="'.BASEDIR.'images/editor/i.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;u&gt;\', \'&lt;/u&gt;\');"><img src="'.BASEDIR.'images/editor/u.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;div style=&quot;text-align:left&quot;&gt;\', \'&lt;/div&gt;\');"><img src="'.BASEDIR.'images/editor/left.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;div style=&quot;text-align:center&quot;&gt;\', \'&lt;/div&gt;\');"><img src="'.BASEDIR.'images/editor/center.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;div style=&quot;text-align:right&quot;&gt;\', \'&lt;/div&gt;\');"><img src="'.BASEDIR.'images/editor/right.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;span style=&quot;color:#ff0000&quot;&gt;\', \'&lt;/span&gt;\');"><img src="'.BASEDIR.'images/editor/red.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;span style=&quot;color:#00ff00&quot;&gt;\', \'&lt;/span&gt;\');"><img src="'.BASEDIR.'images/editor/green.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;span style=&quot;color:#0000ff&quot;&gt;\', \'&lt;/span&gt;\');"><img src="'.BASEDIR.'images/editor/blue.gif" alt="image" /></a>';
	echo '<a href="#form" onclick="javascript:tag(\'&lt;span style=&quot;color:#ffff00&quot;&gt;\', \'&lt;/span&gt;\');"><img src="'.BASEDIR.'images/editor/yellow.gif" alt="image" /></a>';
	echo '<br />';
}

// ------------------------- Функция вывода быстрых смайлов ------------------------//
function quicksmiles() {
	echo 'Смайлы<br />';
	echo '<a href="#form" onclick="javascript:tag(\' :) \', \'\');"><img src="'.BASEDIR.'images/smiles/).gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :( \', \'\');"><img src="'.BASEDIR.'images/smiles/(.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :D \', \'\');"><img src="'.BASEDIR.'images/smiles/D.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :E \', \'\');"><img src="'.BASEDIR.'images/smiles/E.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :hello \', \'\');"><img src="'.BASEDIR.'images/smiles/hello.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :cry \', \'\');"><img src="'.BASEDIR.'images/smiles/cry.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :obana \', \'\');"><img src="'.BASEDIR.'images/smiles/obana.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :infat \', \'\');"><img src="'.BASEDIR.'images/smiles/infat.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :krut \', \'\');"><img src="'.BASEDIR.'images/smiles/krut.gif" alt="image" /></a> ';
	echo '<a href="#form" onclick="javascript:tag(\' :vtopku \', \'\');"><img src="'.BASEDIR.'images/smiles/vtopku.gif" alt="image" /></a> ';
	echo '<br />';
}

// ------------------------- Вспомогательная функция быстрой вставки  ------------------------//
function quickpaste($form) {
	echo '<script language="JavaScript" type="text/javascript">
function tag(text1, text2) {
if ((document.selection)) {
document.form.'.$form.'.focus();
document.form.document.selection.createRange().text = text1+document.form.document.selection.createRange().text+text2;
} else if(document.forms[\'form\'].elements[\''.$form.'\'].selectionStart!=undefined) {
var element = document.forms[\'form\'].elements[\''.$form.'\'];
var str = element.value;
var start = element.selectionStart;
var length = element.selectionEnd - element.selectionStart;
element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
} else document.form.'.$form.'.value += text1+text2;
}
</script>';
}

// ----------------------- Функция изменения настроек сайта -------------------//
function change_setting($str) {
	global $config;

	$file = file_get_contents(DATADIR."config.dat");
	$data = explode('|', $file);

	$text = "";
	for ($u = 0; $u < $config['configkeys']; $u++) {
		if (isset($str[$u])) {
			$data[$u] = $str[$u];
		}
		$text .= $data[$u].'|';
	}

	if ($data[8] != "" && $data[9] != "" && $text != "") {
		$fp = fopen(DATADIR."config.dat", "a+");
		flock($fp, LOCK_EX);
		ftruncate($fp, 0);
		fputs($fp, $text);
		fflush($fp);
		flock($fp, LOCK_UN);
		fclose($fp);
		unset($text);
	}
}

// ------------------------- Функция записи в профиль  ------------------------//
function change_profil($login, $str) {
	global $config;

	if (file_exists(DATADIR."profil/$login.prof")) {
		$file = file_get_contents(DATADIR."profil/$login.prof");
		$data = explode(':||:', $file);

		$text = "";
		for ($u = 0; $u < $config['userprofkey']; $u++) {
			if (isset($str[$u])) {
				$data[$u] = $str[$u];
			}
			$text .= $data[$u].':||:';
		}

		if ($data[0] != "" && $data[1] != "" && $data[4] != "" && $text != "") {
			$fp = fopen(DATADIR."profil/$login.prof", "a+");
			flock($fp, LOCK_EX);
			ftruncate($fp, 0);
			fputs($fp, $text);
			fflush($fp);
			flock($fp, LOCK_UN);
			fclose($fp);
			unset($text);
		}
	}
}

// ------------------------- Функция чтения из профиля  ------------------------//
function reading_profil($login) {
	$arrdata = array();

	if (file_exists(DATADIR."profil/$login.prof")) {
		$file = file_get_contents(DATADIR."profil/$login.prof");
		if ($file != "") {
			$arrdata = explode(':||:', $file);
		}
	}

	return $arrdata;
}

// ------------------------- Функция проверки авторизации  ------------------------//
function is_user() {
	if ($_SESSION['log'] != "" && $_SESSION['par'] != "") {
		if (file_exists(DATADIR.'profil/'.$_SESSION['log'].'.prof')) {
			$file = file_get_contents(DATADIR.'profil/'.$_SESSION['log'].'.prof');
			$data = explode(':||:', $file);

			if ($_SESSION['log'] == $data[0] && md5(md5($_SESSION['par'])) == $data[1]) {
				return true;
			}
		}
	}
	return false;
}

// ------------------------- Функция проверки администрации  ------------------------//
function is_admin($access = array()) {
	if (empty($access)) {
		$access = array(101, 102, 103, 105);
	}

	if (is_user()) {
		global $udata;
		if (in_array($udata[7], $access)) {
			return true;
		}
	}

	return false;
}

// ------------------------- Функция добавления копирайта в изображение ------------------------//
function copyright_image($file) {
	if (file_exists($file)) {
		$ext = getimagesize($file);

		if ($ext[2] == 1) {
			$img = imagecreatefromgif($file);
			$copy = imagecreatefromgif(BASEDIR.'images/img/copyright.gif');
			imagecopy($img, $copy, imagesx($img) - imagesx($copy), imagesy($img) - imagesy($copy), 0, 0, imagesx($copy), imagesy($copy));
			imagegif($img, $file);
			imagedestroy($img);
		} else if ($ext[2] == 2) {
			$img = imagecreatefromjpeg($file);
			$copy = imagecreatefromgif(BASEDIR.'images/img/copyright.gif');
			imagecopy($img, $copy, imagesx($img) - imagesx($copy), imagesy($img) - imagesy($copy), 0, 0, imagesx($copy), imagesy($copy));
			imagejpeg ($img, $file);
			imagedestroy($img);
		}
		return true;
	}
}

// ------------------------- Функция замены заголовков ------------------------//
function ob_processing($str) {
	global $config, $php_self;

	if (isset($config['newtitle'])) {
		$str = str_replace('%TITLE%', $config['newtitle'].' - '.$config['title'], $str);
	} else {
		$str = str_replace('%TITLE%', site_title($php_self), $str);
	}
	$str = str_replace('%KEYWORDS%', $config['keywords'], $str);
	$str = str_replace('%DESCRIPTION%', $config['description'], $str);
	return $str;
}

// ------------- Функция переадресации -------------//
function redirect($url, $permanent = false){

	if ($permanent){
		header('HTTP/1.1 301 Moved Permanently');
	}

	header('Location: '.$url);
	exit();
}

// ------------------------- Функция вывода заголовков ------------------------//
function show_title($image, $title) {
	echo '<img src="'.BASEDIR.'images/img/'.$image.'" alt="image" /> <b>'.$title.'</b><br /><br />';
}

// ------------------------- Функция вывода ошибок ------------------------//
function show_error($error) {
	echo '<img src="'.BASEDIR.'images/img/error.gif" alt="image" /> <b>'.$error.'</b><br /><br />';
}

// ------------------------- Функция вывода предупреждения ------------------------//
function show_login($notice) {
	echo '<div class="login">'.$notice.'<br /><b><a href="'.BASEDIR.'pages/login.php?'.SID.'">Авторизоваться</a></b> или в начале ';
	echo '<b><a href="'.BASEDIR.'pages/registration.php?'.SID.'">Зарегистрироваться</a></b></div>';
}

?>
