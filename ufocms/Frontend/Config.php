<?php
/**
 * @copyright
 */

namespace Ufocms\Frontend;

/**
 * Класс конфигурации.
 */
class Config
{
    /**
     * Путь к корню сайта.
     * @var string
     */
    public $rootPath = '';
    
    /**
     * Путь к корню сайта для URL, формируется из rootPath.
     * @var string
     */
    public $rootUrl = '';
    
    /**
     * Путь и префикс файла протокола ошибок.
     * @var string
     */
    public $logError = '/logs/er';
    
    /**
     * Путь и префикс файла протокола предупреждений.
     * @var string
     */
    public $logWarnings = '/logs/wr';
    
    /**
     * Путь и префикс файла протокола производительности.
     * @var string
     */
    public $logPerformance = '/logs/pr';
    
    /**
     * Путь и префикс файла протокола отладки.
     * @var string
     */
    public $logDebug = '/logs/dg';
    
    /**
     * Путь к папке временных файлов.
     * @var string
     */
    public $tmpDir = '/tmp';
    
    /**
     * Путь к папке кэша.
     * @var string
     */
    public $cacheDir = '/cache';
    
    /**
     * Время жизни кэша.
     * @var int
     */
    public $cacheLifeTime = 3;
    
    /**
     * Время хранения кэша.
     * @var int
     */
    public $cacheSaveTime = 3600;
    
    /**
     * Флаг запрета кэширования, устанавливается модулем при необходимости запретить кэширование.
     * @var bool
     */
    public $cacheForbidden = false;
    
    /**
     * Путь к файлу XmlSitemap.
     * @var string
     */
    public $xmlSitemapPath = '/sitemap.xml';
    
    /**
     * Служебные разделы сайта (карта сайта, поиск, пользователи и т.п.).
     * @var array(path => className)
     */
    public $systemSections = array(
        '/users'     => 'SysUsers', 
        '/sitemap'   => 'SysSitemap', 
        '/sendform'  => 'SysSendform', 
        '/search'    => 'SysSearch', 
        '/ulogin'    => 'SysULogin', 
        '/modules'   => 'SysModules', 
    );
    
    /**
     * Максимальный уровень вложенности в пути раздела (учитывая параметры передаваемые как часть пути).
     * @var int
     */
    public $pathNestingLimit = 10;
    
    /**
     * Количество символов на уровень вложенности при формировании маски раздела.
     * @var int
     */
    public $maskCharsPerLevel = 4;
    
    /**
     * Папка шаблонов (шаблоны сгруппированы по папкам тем)
     * @var string
     */
    public $templatesDir = '/templates';
    
    /**
     * Папка темы по-умолчанию
     * @var string
     */
    public $themeDefault = '/default';
    
    /**
     * Имя параметра (GET, COOKIE) определяющего стиль темы
     * @var string
     */
    public $themeStyleParam = 'themestyle';
    
    /**
     * Допустимые значения стилей темы
     * @var array<string>
     */
    public $themeStylesAllowed = array(
        'red', 
        'green', 
        'blue', 
        'yellow', 
        'orange', 
        'brown', 
        'light', 
        'dark', 
        'night', 
        'special', 
    );
    
    /**
     * Время жизни выбранного стиля темы
     * @var int
     */
    public $themeStyleLifetime = 3600 * 24 * 30;
    
    /**
     * Папка шаблонов по-умолчанию
     * @var string
     */
    public $templateDefault = '/default';
    
    /**
     * Папка шаблонов ошибок
     * @var string
     */
    public $templatesErrors = '/syserrors';
    
    /**
     * Точка входа, основной макет страниц
     * @var string
     */
    public $templatesEntry = '/index.php';
    
    /**
     * Точка входа шаблона отладки
     * @var string
     */
    public $templatesDebugEntry = '/debug.php';
    
    /**
     * Точка входа шаблона для отображения меню
     * @var string
     */
    public $templatesMenuEntry = '/menu.php';
    
    /**
     * Точка входа шаблона для отображения постраничного вывода
     * @var string
     */
    public $templatesPaginationEntry = '/pagination.php';
    
    /**
     * Точка входа шаблона для отображения комментариев
     * @var string
     */
    public $templatesCommentsEntry = '/comments.php';
    
    /**
     * Точка входа шаблона для отображения добавления комментария
     * @var string
     */
    public $templatesCommentsAddEntry = '/commentsadd.php';
    
    /**
     * Точка входа шаблона для отображения добавления комментария
     * @var string
     */
    public $templatesCommentsPaginationEntry = '/commentspg.php';
    
    /**
     * Точка входа шаблона для отображения комментариев
     * @var string
     */
    public $templatesInteractionEntry = '/interaction/index.php';
    
    /**
     * Точка входа шаблона для отображения добавления комментария
     * @var string
     */
    public $templatesInteractionAddEntry = '/interaction/add.php';
    
    /**
     * Точка входа шаблона для отображения добавления комментария
     * @var string
     */
    public $templatesInteractionPaginationEntry = '/interaction/pagination.php';
    
    /**
     * Точка входа шаблона для отображения кода в области HEAD
     * @var string
     */
    public $templatesHeadEntry = '/head.php';
    
    /**
     * Точка входа шаблона для отображения конкретного элемента
     * @var string
     */
    public $templatesItemEntry = '/item.php';
    
    /**
     * Точка входа шаблона для отображения результата действия
     * @var string
     */
    public $templatesResultEntry = '/result.php';
    
    /**
     * Точка входа шаблона для отображения списка вставок
     * @var string
     */
    public $templatesInsertionsEntry = '/insertions.php';
    
    /**
     * Точка входа шаблона для отображения вставки
     * @var string
     */
    public $templatesInsertionEntry = '/insertion.php';
    
    /**
     * Точка входа шаблона для отображения списка виджетов
     * @var string
     */
    public $templatesWidgetsEntry = '/widgets.php';
    
    /**
     * Точка входа шаблона для отображения цитат
     * @var string
     */
    public $templatesQuotesEntry = '/quotes.php';
    
    /**
     * Точка входа шаблона для отображения CAPTCHA
     * @var string
     */
    public $templatesCaptchaEntry = '/captcha.php';
    
    /**
     * Минимальное значение параметра $page
     * @var int
     */
    public $pageMin = 1;
    
    /**
     * Максимальное значение параметра $page
     * @var int
     */
    public $pageMax = 1000;
    
    /**
     * Значение параметра $page по-умолчанию
     * @var int
     */
    public $pageDefault = 1;
    
    /**
     * Минимальное значение параметра $pageSize
     * @var int
     */
    public $pageSizeMin = 1;
    
    /**
     * Максимальное значение параметра $pageSize
     * @var int
     */
    public $pageSizeMax = 1000;
    
    /**
     * Значение параметра $pageSize по-умолчанию
     * @var int
     */
    public $pageSizeDefault = 10;
    
    /**
     * Конструктор. Инициализирует вспомогательные объекты-структуры для хранения связанных параметров.
     * Поскольку в конструкторе инициализируются объекты, которые могут не содержать возможности для изменения своих полей, это единственная возможность для их переопределения.
     * 
     * @param array $overrides = null    массив, содержащий имена полей и значения, для переопределения значений
     */
    public function __construct(array $overrides = null)
    {
        $this->rootUrl = $this->rootPath;
        $this->rootPath = $_SERVER['DOCUMENT_ROOT'] . $this->rootPath;
        if (!is_null($overrides)) {
            foreach ($overrides as $name => $value) {
                if (property_exists($this, $name)) {
                    $this->$name = $value;
                }
            }
        }
    }
}
