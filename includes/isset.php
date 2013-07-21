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

if (isset($_SESSION['note'])) {
	echo '<div class="isset">'.$_SESSION['note'].'</div>';
}

if (is_user() && $udata[10]>0){
	if (!stristr($php_self,'pages/ban.php') && !stristr($php_self,'pages/key.php') && !stristr($php_self,'pages/banip.php') && !stristr($php_self,'pages/privat.php') && !stristr($php_self,'pages/pravila.php') && !stristr($php_self,'pages/closed.php')){
			echo '<img src="'.BASEDIR.'images/img/newmail.gif" alt="image" /> <b><a href="'.BASEDIR.'pages/privat.php?'.SID.'"><span style="color:#ff0000">Приватное сообщение! ('.(int)$udata[10].')</span></a></b><br />';
	}
}

if (isset($_GET['isset'])){

$isset = check($_GET['isset']);

if ($isset=="403"){
echo '<div class="isset">ERROR 403<br />Недопустимый запрос</div>';}

if ($isset=="404"){
echo '<div class="isset">ERROR 404<br />Извините, но такой страницы не существует</div>';}

if ($isset=="exit"){
echo '<div class="isset">Спасибо за посещение, надеемся, вам понравилось на нашем сайте</div>';}

if ($isset=="inputoff"){
echo '<div class="isset">Ошибка авторизации<br />Неправильный логин или пароль</div>';}

if ($isset=="mail"){
echo '<div class="isset">Ваше письмо успешно отправлено!</div>';}

if ($isset=="editprofil"){
echo '<div class="isset">Профиль успешно изменен!</div>';}

if ($isset=="editaccount"){
echo '<div class="isset">Ваши данные успешно изменены!</div>';}

if ($isset=="editpass"){
echo '<div class="isset">Пароль успешно изменен!</div>';}

if ($isset=="editsetting"){
echo '<div class="isset">Настройки успешно изменены!</div>';}

if ($isset=="lostpass"){
echo '<div class="isset">Пароль успешно восстановлен!<br />Ваши новые данные высланы на E-mail указанный в профиле</div>';}

if ($isset=="antiflood"){
echo '<div class="isset">Свои мысли нужно формулировать чётче. Разрешается отправлять сообщения раз в '.$config['floodstime'].' секунд!</div>'; }

if ($isset=="addon"){
echo '<div class="isset">Сообщение успешно добавлено!</div>'; }

if ($isset=="oktem"){
echo '<div class="isset">Тема успешно добавлена!</div>'; }

if ($isset=="delthemes"){
echo '<div class="isset">Тема была удалена модератором!</div>'; }

if ($isset=="nopost"){
echo '<div class="isset">Ошибка! Слишком длинное сообщение или тема!</div>'; }

if ($isset=="zakr"){
echo '<div class="isset">Вы не можете писать в закрытую тему!</div>'; }

if ($isset=="alldelpriv"){
echo '<div class="isset">Ящик успешно очищен!</div>';}

if ($isset=="selectpriv"){
echo '<div class="isset">Выбранные сообщения успешно удалены!</div>';}

if ($isset=="posts"){
echo '<div class="isset">Ваше сообщение пустое, слишком длинное или короткое.</div>'; }

if ($isset=="mp_yesset"){
echo '<div class="isset">Настройки системы успешно изменены!</div>';}

if ($isset=="mp_editvotes"){
echo '<div class="isset">Голосование успешно изменено!</div>';}

if ($isset=="mp_addvotes"){
echo '<div class="isset">Новое голосование успешно создано!</div>';}

if ($isset=="mp_delvotes"){
echo '<div class="isset">Голосование успешно удалено из архива!</div>';}

if ($isset=="yesvotes"){
echo '<div class="isset">Ваш голос успешно принят!</div>';}

if ($isset=="mp_addboard"){
echo '<div class="isset">Рубрика успешно добавлена!</div>';}

if ($isset=="mp_moveboard"){
echo '<div class="isset">Рубрика успешно перемещена!</div>';}

if ($isset=="mp_editboard"){
echo '<div class="isset">Рубрика успешно изменена!</div>';}

if ($isset=="mp_delboard"){
echo '<div class="isset">Выбранные рубрики успешно удалены!</div>';}

if ($isset=="mp_deltopboard"){
echo '<div class="isset">Выбранные объявления успешно удалены!</div>';}

if ($isset=="addboard"){
echo '<div class="isset">Объявление успешно добавлено!</div>';}

if ($isset=="ignor_add"){
echo '<div class="isset">Пользователь успешно отправлен в игнор!</div>';}

if ($isset=="ignor_del"){
echo '<div class="isset">Выбранные пользователи успешно удалены из игнора!</div>';}

if ($isset=="ignor_clear"){
echo '<div class="isset">Игнор-лист успешно очищен!</div>';}

if ($isset=="kontakt_add"){
echo '<div class="isset">Пользователь успешно добавлен в контакты!</div>';}

if ($isset=="kontakt_del"){
echo '<div class="isset">Выбранные пользователи успешно удалены из контактов!</div>';}

if ($isset=="kontakt_clear"){
echo '<div class="isset">Контакт-лист успешно очищен!</div>';}

if ($isset=="mp_editfiles"){
echo '<div class="isset">Файл успешно отредактирован!</div>';}

if ($isset=="mp_newfiles"){
echo '<div class="isset">Новый файл успешно создан!</div>';}

if ($isset=="mp_delfiles"){
echo '<div class="isset">Файл успешно удален!</div>';}

if ($isset=="mp_chatclear"){
echo '<div class="isset">Мини-чат успешно очищен!</div>';}

if ($isset=="mp_admindelchat"){
echo '<div class="isset">Админ-чат успешно очищен!</div>';}

if ($isset=="mp_adminrestatement"){
echo '<div class="isset">Сообщения админ-чата успешно пересчитаны!</div>';}

if ($isset=="mp_checkdelpost"){
echo '<div class="isset">Выбранные сообщения успешно удалены!</div>';}

if ($isset=="mp_chateditpost"){
echo '<div class="isset">Сообщение мини-чата успешно отредактировано!</div>';}

if ($isset=="mp_dellogs"){
echo '<div class="isset">Лог-файлы успешно очищены!</div>';}

if ($isset=="mp_editstatus"){
echo '<div class="isset">Статусы успешно изменены!</div>';}

if ($isset=="mp_delsubmail"){
echo '<div class="isset">Выбранные подписчики успешно удалены!</div>';}

if ($isset=="mp_delsuball"){
echo '<div class="isset">Все подписчики успешно удалены!</div>';}

if ($isset=="mp_editrazdel"){
echo '<div class="isset">Раздел форума успешно переименован!</div>';}

if ($isset=="mp_noeditrazdel"){
echo '<div class="isset">Ошибка переименовывания раздела!</div>';}

if ($isset=="mp_delthemes"){
echo '<div class="isset">Тема форума успешно удалена!</div>';}

if ($isset=="mp_nodelthemes"){
echo '<div class="isset">Ошибка удаления темы форума!</div>';}

if ($isset=="mp_delforums"){
echo '<div class="isset">Раздел форума успешно удален!</div>';}

if ($isset=="mp_nodelforums"){
echo '<div class="isset">Ошибка удаления раздела форума!</div>';}

if ($isset=="mp_addforums"){
echo '<div class="isset">Раздел форума успешно создан!</div>';}

if ($isset=="mp_noaddforums"){
echo '<div class="isset">Ошибка создания раздела форума!</div>';}

if ($isset=="noeditnick"){
echo '<div class="isset">Ошибка! Разрешены только русские символы и цифры!</div>';}

if ($isset=="editnick"){
echo '<div class="isset">Ваш ник успешно изменен!</div>';}

if ($isset=="delnick"){
echo '<div class="isset">Ваш ник успешно удален!</div>';}

if ($isset=="karantin"){
echo '<div class="isset">Включен карантин! Новые пользователи не могут писать в течении '.round($config['karantin']/3600).' часов после регистрации</div>';}

if ($isset=="addfoto"){
echo '<div class="isset">Изображение успешно загружено!</div>';}

if ($isset=="delfoto"){
echo '<div class="isset">Выбранные изображения успешно удалены!</div>';}

if ($isset=="editfoto"){
echo '<div class="isset">Изображение успешно отредактировано!</div>';}

if ($isset=="addkomm"){
echo '<div class="isset">Ваш комментарий успешно добавлен!</div>';}

if ($isset=="delkomm"){
echo '<div class="isset">Комментарий успешно удален!</div>';}

if ($isset=="mp_bookclear"){
echo '<div class="isset">Гостевая книга успешно очищена!</div>';}

if ($isset=="mp_bookeditpost"){
echo '<div class="isset">Сообщение гостевой успешно отредактировано!</div>';}

if ($isset=="mp_bookotvet"){
echo '<div class="isset">Ответ успешно добавлен!</div>';}

if ($isset=="mp_bookrestatement"){
echo '<div class="isset">Сообщения гостевой успешно пересчитаны!</div>';}

if ($isset=="mp_chatrestatement"){
echo '<div class="isset">Сообщения мини-чата успешно пересчитаны!</div>';}

if ($isset=="mp_addmat"){
echo '<div class="isset">Слово успешно добавлено в список антимата!</div>';}

if ($isset=="mp_delmat"){
echo '<div class="isset">Слово успешно удалено из списка антимата!</div>';}

if ($isset=="mp_clearmat"){
echo '<div class="isset">Список антимата успешно очищен!</div>';}

if ($isset=="addlink"){
echo '<div class="isset">Ваш сайт успешно добавлен в список партнеров и друзей!</div>';}

if ($isset=="mp_skanchecker"){
echo '<div class="isset">Система успешно отсканирована!</div>';}

if ($isset=="sendfiles"){
echo '<div class="isset">Файл успешно отправлен по электронной почте!</div>';}

if ($isset=="mp_addnews"){
echo '<div class="isset">Новость успешно добавлена!</div>';}

if ($isset=="mp_editnews"){
echo '<div class="isset">Новость успешно отредактирована!</div>';}

if ($isset=="mp_delnews"){
echo '<div class="isset">Выбранные новости успешно удалены!</div>';}

if ($isset=="addbansend"){
echo '<div class="isset">Объяснение успешно отправлено!</div>';}

if ($isset=="reload"){
echo '<div class="isset">Список успешно обновлен!</div>';}

if ($isset=="mp_headlines"){
echo '<div class="isset">Заголовок успешно изменен!</div>';}

if ($isset=="mp_addheadlines"){
echo '<div class="isset">Заголовок успешно добавлен!</div>';}

if ($isset=="mp_headdel"){
echo '<div class="isset">Выбранные заголовки успешно удалены!</div>';}

if ($isset=="mp_addreklama"){
echo '<div class="isset">Рекламная ссылка успешно добавлена!</div>';}

if ($isset=="mp_editreklama"){
echo '<div class="isset">Рекламная ссылка успешно изменена!</div>';}

if ($isset=="mp_delreklama"){
echo '<div class="isset">Рекламная ссылка успешно удалена!</div>';}

if ($isset=="mp_alldelreklama"){
echo '<div class="isset">Выбранные ссылки успешно удалены!</div>';}

if ($isset=="mp_yesbackup"){
echo '<div class="isset">Новый архив успешно создан!</div>';}

if ($isset=="mp_delbackup"){
echo '<div class="isset">Архив успешно удален!</div>';}

if ($isset=="mp_restorebackup"){
echo '<div class="isset">Архив успешно восстановлен!</div>';}

if ($isset=="mp_blackmaildel"){
echo '<div class="isset">Выбранные адреса успешно удалены!</div>';}

if ($isset=="mp_blacklogindel"){
echo '<div class="isset">Выбранные логины успешно удалены!</div>';}

if ($isset=="mp_blackmailadd"){
echo '<div class="isset">E-mail успешно добавлен в черный список!</div>';}

if ($isset=="mp_blackloginadd"){
echo '<div class="isset">Логин успешно добавлен в черный список!</div>';}

if ($isset=="mp_addbanlist"){
echo '<div class="isset">IP успешно занесен в список!</div>';}

if ($isset=="mp_delbanlist"){
echo '<div class="isset">Выбранные IP успешно удалены из списка!</div>';}

if ($isset=="mp_clearbanlist"){
echo '<div class="isset">Список IP успешно очищен!</div>';}

if ($isset=="mp_movenavigation"){
echo '<div class="isset">Ссылка успешно перемещена!</div>';}

if ($isset=="mp_delnavigation"){
echo '<div class="isset">Выбранные ссылки успешно удалены!</div>';}

if ($isset=="mp_editnavigation"){
echo '<div class="isset">Ссылка успешно изменена!</div>';}

if ($isset=="mp_addnavigation"){
echo '<div class="isset">Ссылка успешно добавлена!</div>';}

if ($isset=="mp_delregusers"){
echo '<div class="isset">Выбранные пользователи успешно удалены!</div>';}

if ($isset=="mp_addregusers"){
echo '<div class="isset">Выбранные аккаунты успешно одобрены!</div>';}
}
?>
