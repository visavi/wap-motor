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
require_once "../includes/start.php";
require_once "../includes/functions.php";
require_once "../includes/header.php";
include_once "../themes/".$config['themes']."/index.php";

echo '<img src="../images/img/partners.gif" alt="image" /> <b>Правила сайта</b><br /><br />';

echo 'Незнание этих Правил не только не освобождает Вас от ответственности за их нарушение, но и само по себе является нарушением!<br /><br />';

echo '<b>Общие правила для пользователей сайта '.$config['title'].'</b><br /><br />';
echo '<b>1. Общие положения</b><br />';
echo 'а) Сайт посвящен вопросам призванным помочь wap-мастеру в разработке сайта, проекта или приложения для сайта.<br />';
echo 'б) На сайте НЕ обсуждаются вопросы связанные со взломами сайтов<br />';
echo 'в) Все материалы и сообщения, размещаемые на сайте, отражают исключительно мнения их авторов, администрация сайта не
дает каких-либо гарантий, выраженных явно, или подразумеваемых, что они полны, полезны или правдивы.<br /><br />';

echo '<b>2. Порядок поведения на сайте</b><br />';
echo 'а) Публикация ссылок на другие сайты допустима при условии, что страница, находящаяся по указанному адресу имеет непосредственное отношение к теме, приведена в качестве иллюстрации утверждения, высказанного автором сообщения.<br />';
echo 'б) На сайте применяется пост-модерация. Сообщения, нарушающие настоящие Правила, удаляются. Не следует воспринимать исчезновение своих сообщений следствием технического сбоя и помещать сообщения еще раз.<br />';
echo 'в) Не одобряются попытки обратить внимание на низкий уровень знаний какого-либо участника сайта.Все когда-то не знали простых вещей.<br />';
echo 'г) Вы обязаны соблюдать уважительное отношение к собеседнику, правильное (граммотное) и доходчивое изложение мыслей и фактов.<br />';
echo 'д) Не обращайте внимания на маргиналов и прочих брутальных личностей. Не дразните и не подначивайте их - отсутствие внимания сразу сводит дискуссию на нет. Не стоит отвечать им той же монетой, даже если Вы считаете, что Вас оскорбили. Остальное - забота модераторов и администраторов.<br />';
echo 'е) Если Вы видите сообщение, нарушающее любое правило сайта, сообщите об этом администрации в "Приват", не стоит об этом кричать на форуме во всеуслышанье.<br /><br />';

echo '<b>3. При создании новых тем в форуме необходимо придерживаться следующих правил:</b><br />';
echo 'а) Название темы должно быть информативным. Заголовки тем типо: "Подскажите", "Знающие люди, зайдите!",
"Есть вопрос", "Вопрос по php-коду" и подобные лишь демонстрируют Ваше неуважение к остальным участникам.<br />';
echo 'б) Тема должна соответствовать теме раздела, в котором она помещена. Не следует открывать тему в определенном
разделе только потому, что Вы хотите получить быстрый ответ в более посещаемом разделе.<br />';
echo 'в) Запрещается создание тем обращенных к конкретным участникам конференции (для этого существует "Приват").<br />';
echo 'г) Запрещается продолжение обсyждений вопросов из тем, закpытых/удалённых администрацией.
Перед тем как задать вопрос, настоятельно рекомендуем пользоваться поиском по форуму, наверняка Ваш вопрос уже обсуждался ранее.<br /><br />';

echo '<b>4. Запрещается помещение сообщений, содержащих:</b><br />';
echo 'а) Призывы к нарушению действующего законодательства, высказывания расистского характера, разжигание межнациональной розни, нагнетание обстановки на форуме и всего прочего, что попадает под действие УК РФ.<br />';
echo 'б) Грубые, нецензурные выражения и оскорбления в любой форме (флейм) - сообщения, грубые по тону, содержащие "наезды" на личности.<br />';
echo 'в) Бессмысленную или малосодержательную информацию, которая не несет смысловой нагрузки - пустую болтовню (флуд).<br />';
echo 'г) Оффтоп, т.е. уход от основного обсуждения в рамках отдельной темы.<br />';
echo 'д) Ложнyю инфоpмацию, клеветy, а также нечестные приемы ведения дискуссий
в виде "передергиваний" высказываний собеседников.<br />';
echo 'е) Откровенное рекламное содержание, в том числе с просьбой "Посетите/оцените мой сайт".<br />';
echo 'ж) Безосновательные утверждения, что "это" лучше, а "это" хуже, а также глупые советы типа "выпей йаду", "полюби гугл" и т.д.<br />';
echo 'з) Чрезмерное количество грамматических ошибок и жаргонных слов.<br />';
echo 'и) Обсуждение и выражение своих недовольств к действиям модераторов форума.<br /><br />';


echo 'За выполнением требований Правил следит администрация, а также специально назначенные модераторы. Администрация имеет право не предупреждать пользователя о принимаемых мерах.<br /><br />';

echo '5. Копирование или любое несанкционированное использование материалов сайта запрещено.<br /><br />';

echo '<b><span style="color:#ff0000">Внимание! Если пользователь пренебрегает данными Правилами, его аккуант блокируется  на срок от 1 часа до '.round($config['maxbantime']/1440).' дней.<br />
Если пользователь систематически игнорирует предупреждения администрации, то его учётная запись удаляется</span></b><br /><br />';

echo'<img src="../images/img/homepage.gif" alt="image" /> <a href="../index.php">На главную</a>';

include_once"../themes/".$config['themes']."/foot.php";
?>
