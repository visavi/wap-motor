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
define('MOTOR_VERSION', '27.0');

$debugmode = 1;

if ($debugmode) {
    @error_reporting(E_ALL);
    @ini_set('display_errors', true);
    @ini_set('html_errors', true);
    @ini_set('error_reporting', E_ALL);
} else {
    @error_reporting(E_ALL ^ E_NOTICE);
    @ini_set('display_errors', false);
    @ini_set('html_errors', false);
    @ini_set('error_reporting', E_ALL ^ E_NOTICE);
}

session_name('SID');
session_start();

$starttime = microtime(1);
$ip = $ip_addr = preg_replace('|[^0-9\.]|', '', $_SERVER['REMOTE_ADDR']);

if (version_compare(PHP_VERSION, '7.0.0') < 0) {
    die('<b>Ошибка! Версия PHP должна быть 7.0.0 или выше!</b>');
}

$level = 0;
$folder_level = '';
while (!file_exists($folder_level.'input.php') && $level < 5) {
    $folder_level .= '../';
    ++$level;
}
unset($level);

define('BASEDIR', $folder_level);
define('DATADIR', BASEDIR.'local/');
define('ADMINDIR', BASEDIR.'mpanel/');

/*foreach ($_GET as $check_url) {
if (!preg_match('#^(?:[a-z0-9_\-/]+|\.+(?!/))*$#i', $check_url)){
header ('Location: '.BASEDIR.'index.php?isset=403'); exit;
}}
unset($check_url);*/

############################################################################################
##                                  Настройки сайта                                       ##
############################################################################################
if (!file_exists(DATADIR.'config.dat')) {
    $files = glob(DATADIR."datalocal/*.dat");
    foreach ($files as $file) {
        copy($file, DATADIR.basename($file));
    }
}

if (file_exists(DATADIR.'config.dat')){
$con_text = file_get_contents(DATADIR.'config.dat');
$con_data = explode('|',$con_text);

$config['welcome'] = $con_data[0];                  #  Показывать приветствие
$config['keypass'] = $con_data[1];                  #  Ключ для шифровки/расшифровки паролей coockies
$config['themes'] = $con_data[2];                   #  Название скина/темы, посмотреть их можно в папке themes
$config['karantin'] = $con_data[3];                 #  Время карантина новичков
$config['showtime'] = $con_data[4];                 #  Показывать Часы и день недели на главной странице
$config['generics'] = $con_data[5];                 #  Показывать время генерации страницы, если нет, то пишем 0
//$config['counters'] = $con_data[6];               #  Включить счетчик 1, или выключить 0                                     временно свободно
$config['onlines'] = $con_data[7];                  #  Показывать сколько человек в онлайне, если нет, то пишем 0
$config['nickname'] = $con_data[8]; 	            #  Логин суперадминистратора
$config['emails'] = $con_data[9];                   #  E-mail суперадминистратора
$config['timeclocks'] = $con_data[10];              #  Временной сдвиг серверного времени
$config['title'] = $con_data[11];                   #  Заголовок всех страниц
$config['logos'] = $con_data[12];                   #  Название, будет отображенно на каждой странице около логотипа
$config['copy'] = $con_data[13];                    #  Копирайт ,  будет отображенно внизу на каждой странице
$config['home'] = $con_data[14];                    #  Главная страница сайта
$config['logotip'] = $con_data[15];                 #  Адрес логотипа, вы можете просто заменить саму картинку в папке images
$config['ras'] = $con_data[16];                     #  Расширение страниц движка (по умолчанию mot)
$config['postnews'] = $con_data[17];                #  Новостей показывается на страницу
$config['lastnews'] = $con_data[18];                #  Cколько новостей выводить на главную? не надо то 0
$config['bookpost'] = $con_data[19];                #  Сообщений в гостевой показывается на страницу
$config['bookadds'] = $con_data[20];                #  Разрешать гостям писать в гостевой? Если 0, то запрещено
$config['guestsuser'] = $con_data[21];              #  Как представлять незарегистрированных посетителей
$config['maxpostchat'] = $con_data[22];             #  Какое количество  постов в  чате сохраняется
$config['chatpost'] = $con_data[23];                #  Cообщений на страницу в чате
//$config['maxpostnews'] = $con_data[24];           #  Какое количество новостей сохраняется                                      временно свободно
$config['maxpostbook'] = $con_data[25];             #  Какое количество  постов в гостевой сохраняется
$config['forumpost'] = $con_data[26];               #  Кол-во отображаемых сообщений на каждой странице в форуме
$config['forumtem'] = $con_data[27];                #  Кол-во отображаемых тем на страницу в форуме
$config['topforum'] = $con_data[28];                #  Oставлять последних тем
$config['floodstime'] = $con_data[29];              #  Время антифлуда между сообщениями в сек.
$config['limitsmail'] = $con_data[30];              #  Размер ящика для привата пользователей в kb
$config['userlist'] = $con_data[31];                #  Количество пользователей в Юзерлисте на страницу
//$config['priv'] = $con_data[32];                    #  Расширение для файлов привата, рекомендум изменить на свое               временно свободно
$config['privatpost'] = $con_data[33];              #  Писем на страницу в привате
$config['copyfoto'] = $con_data[34];                #  Наложение копирайта на изображения
$config['boardspost'] = $con_data[35];              #  Kол-во отображаемых объявлений на каждой странице
$config['boarddays'] = $con_data[36];               #  Максимальное кол-во дней показа объявления
$config['fotolist'] = $con_data[37];                #  Kол-во отображаемых фото на каждой странице
$config['filesize'] = $con_data[38];                #  Максимальный вес файла в байтах
$config['filefoto'] = $con_data[39];                #  Максимальные размеры в пикселях
$config['postdown'] = $con_data[40];                #  Комментариев на страницу в загрузках
$config['maxpostdown'] = $con_data[41];             #  Какое количество комментариев в загрузках сохраняется
$config['downlist'] = $con_data[42]; 	            #  Файлов на страницу в загрузках
//$config['publics'] = $con_data[43];                 #  Название корневой на хосте (public_html, htdocs и тд)                       временно свободно
$config['showuser'] = $con_data[44];                #  Вывод на стр. в кто-где
$config['lastusers'] = $con_data[45];               #  Сохраняется истории в кто-где (maх 100)
$config['allvotes'] = $con_data[46];                #  Голосования на страницу
$config['quotes'] = $con_data[47];                  #  Цитаты, 0 - выкл 1-вкл
//$config['mpanel'] = $con_data[48];                  #  Папка с админкой                                                         временно свободно
$config['vkladlist'] = $con_data[49];               #  Чел на стр. в статистике вкладов
$config['cookies'] = $con_data[50];                 #  Разрешить вход по кукам
$config['referer'] = $con_data[51];	                #  Сохраняется рефереров
$config['nocache'] = $con_data[52];                 #  Кэширование 0-выкл 1-вкл
$config['showlink'] = $con_data[53];                #  Выводится на главную ccылок если не надо то 0
$config['onlinelist'] = $con_data[54];	            #  Юзеров на страницу в онлайне
$config['smilelist'] = $con_data[55];	            #  Число смайлов на страницу
$config['submail'] = $con_data[56];                 #  Число отправки писем рассылки в пакете
$config['doslimit'] = $con_data[57];                #  Максимальное кол. обращений с одного ip в минуту
$config['maxlogdat'] = $con_data[58];               #  Сохраняется информации в лог-файле
$config['resmiles'] = $con_data[59];                #  Число смайлов в сообщении
$config['showref'] = $con_data[60];                 #  На страницу в кто -откуда
$config['openreg'] = $con_data[61];                 #  Открыта регистрация или закрыта
$config['regkeys'] = $con_data[62];                 #  Включить подтверждение регистрации
$config['shutnik'] = $con_data[63];                 #  Шутник в чате (1-включен, 0-выключен)
$config['botnik'] = $con_data[64];                  #  Бот в чате (1-включен, 0-выключен)
$config['magnik'] = $con_data[65];                  #  Умник в чате (1-включен, 0-выключен)
$config['ziplist'] = $con_data[66];                 #  Файлов на страницу в просмотре архивов
$config['liblist'] = $con_data[67];                 #  Статей в библиотеке на страницу
$config['libpost'] = $con_data[68];                 #  Строк в статье на страницу
$config['gzip'] = $con_data[69];                    #  Включено сжатие страниц GZIP или выключено
$config['avtorlist'] = $con_data[70];               #  Кол.юзеров в рейтинге авторитетов на стр.
//$config['translit'] = $con_data[71];                #  Возможность транслита (1-есть, 0-нет) для англоязычных сайтов               Ячейка временно свободна
$config['rekhead'] = $con_data[72];                 #  Включить рекламу вверху страниц
$config['rekfoot'] = $con_data[73];                 #  Включить рекламу внизу страниц
$config['incount'] = $con_data[74];                 #  Вид счетчика (Хосты,хиты,всего или графика)
//$config['sessionlife'] = $con_data[75];             #  Время простоя сессии                                  Ячейка временно свободна
$config['userlistcache'] = $con_data[76];           #  Кеширование в юзерлисте
$config['avtorlistcache'] = $con_data[77];          #  Кеширование в рейтинге авторитетов
$config['raitinglistcache'] = $con_data[78];        #  Кеширование в рейтинге толстосумов
$config['downloadcache'] = $con_data[79];           #  Кеширование подсчета в загруз-центре
$config['librarycache'] = $con_data[80];            #  Кеширование подсчета в библиотеке
//$config['rssicon'] = $con_data[81];                 #  Включить вывод иконки RSS в теме                                Ячейка временно свободна
$config['keywords'] = $con_data[82];                #  Ключевые слова в описании сайта для поисковиков
$config['description'] = $con_data[83];             #  Краткое описание сайта для поисковиков
$config['usersearchcache'] = $con_data[84];         #  Кеширование в поиске пользователей
$config['calendar'] = $con_data[85];                #  Включить календарь на главной
$config['onliner'] = $con_data[86];                 #  Включить бегущую строку со списком юзеров
$config['autoskins'] = $con_data[87];               #  Выпадающий список скинов/тем
$config['nocheck'] = $con_data[88];                 #  Расширения которые не нужно сканировать
$config['includenick'] = $con_data[89];             #  Разрешить русские ники
$config['addbansend'] = $con_data[90];              #  Разрешить писать объснительные из бана
$config['navigation'] = $con_data[91];              #  Выпадающий список навигации
$config['kontaktlist'] = $con_data[92];             #  Листинг в контакт-листе
$config['ignorlist'] = $con_data[93];               #  Листинг в игнор листе
$config['lifelist'] = $con_data[94];                #  Листинг в рейтинге долгожителей
$config['lifelistcache'] = $con_data[95];           #  Кеширование в рейтинге долгожителей
$config['banlist'] = $con_data[96];                 #  Листинг в списке забаненных
$config['maxbantime'] = $con_data[97];              #  Максимальное время бана
$config['notificraiting'] = $con_data[98];          #  Разрешить уведомление об изменении авторитета
$config['maxpostsub'] = $con_data[99];              #  Количество подписчиков рассылки на страницу
$config['headlines'] = $con_data[100];              #  Количество вывода заголовков на страницу
$config['libadd'] = $con_data[101];                 #  Разрешить добавлять новые статьи
$config['libstring'] = $con_data[102];              #  Макс. кол-во символов в новой статье
$config['protectimg'] = $con_data[103];             #  Включить защитную картинку с кодом
$config['protectdef'] = $con_data[104];             #  Деформация защитной картинки
$config['siteinfo'] = $con_data[105];               #  Новостей движка в обновлениях
$config['topforums'] = $con_data[106];              #  Кол-во юзеров в топе форума
$config['userforumcache'] = $con_data[107];         #  Кеширование юзеров в топе форума
$config['themesforumcache'] = $con_data[108];       #  Кеширование популярных тем форума
$config['previewsize'] = $con_data[109];            #  Размер картинки для предпросмотра в галерее
$config['postgallery'] = $con_data[110];            #  Число комментариев на страницу в галерее
$config['maxpostgallery'] = $con_data[111];         #  Всего комментариев сохраняется
$config['adminlistcache'] = $con_data[112];         #  Кеширование списка администрации
$config['webthemes'] = $con_data[113];              #  Название Веб-темы при входе с компьютера (0-выкл)
$config['avatarpay'] = $con_data[114];              #  Стоимость платного аватара
$config['avatarupload'] = $con_data[115];           #  Стоимсоть загрузки персонального аватара
$config['avlist'] = $con_data[116];                 #  Количество аватаров на страницу
$config['editfiles'] = $con_data[117];              #  Количество файлов в редакторе админки
$config['closedsite'] = $con_data[118];             #  Закрыть сайт по техническим причинам
$config['jackpot'] = $con_data[119];                #  Джек-пот в лотерее по умолчанию
$config['ochkostavka'] = $con_data[120];            #  Максимальная ставка в игре 21-очко
$config['minkredit'] = $con_data[121];              #  Минимальная сумма кредита
$config['maxkredit'] = $con_data[122];              #  Максимальная сумма кредита
$config['percentkredit'] = $con_data[123];          #  Проценты банка за кредит
$config['hisumma'] = $con_data[124];                #  Сумма выигрыша в игре Угадай число
$config['hipopytka'] = $con_data[125];              #  Число попыток в игре Угадай число
$config['regusercache'] = $con_data[126];           #  Кеширование при регистрации
$config['loglist'] = $con_data[127];                #  Просмотр логов на страницу
$config['themescache'] = $con_data[128];            #  Кеширование популярных скинов
$config['blacklist'] = $con_data[129];              #  Данных на страницу в черном списке
$config['maxkommnews'] = $con_data[130];            #  Кол-во комментариев новостей сохраняется
$config['vkladlistcache'] = $con_data[131];         #  Кеширование рейтинга вкладчиков
$config['avatarpoints'] = $con_data[132];           #  Количество баллов для загрузки аватара
$config['avatarsize'] = $con_data[133];             #  Размер загружаемого аватара (px)
$config['avatarweight'] = $con_data[134];           #  Максимальный вес загружаемого аватара (byte)
$config['maxsumbank'] = $con_data[135];             #  Максимальная сумма в банке

} else {echo '<b>Ошибка! Не установлены настройки сайта!</b>'; exit;}

//------------------- Технические настройки --------------------//
$config['userprofkey'] = 100;                       #  Количество ячеек в профиле
$config['configkeys'] = 140;                        #  Всего ячеек в настройках

define('SITETIME', time() + $config['timeclocks'] * 3600); // Установка временного сдвига сайта
?>
