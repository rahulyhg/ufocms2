<?php
/**
 * @copyright
 */

namespace Ufocms\Backend;

/**
 * Класс конфигурации.
 */
class Config extends \Ufocms\Frontend\Config
{
    /**
     * Путь и префикс файла протокола ошибок.
     * @var string
     */
    public $logAudit = '/logs/aa';
    
    public $paramsNames = array(
        'coreModule'        => 'coremodule', 
        'sectionId'         => 'sectionid', 
        'itemId'            => 'itemid', 
        'subModule'         => 'submodule', 
        'action'            => 'action', 
        'filterName'        => 'filtername', 
        'filterValue'       => 'filtervalue', 
        'sortField'         => 'sortfield', 
        'sortDirection'     => 'sortdirection', 
        'page'              => 'page', 
        'pageSize'          => 'pagesize', 
    );
    
    public $pageMin = 1;
    public $pageMax = 1000;
    public $pageDefault = 1;
    public $pageSizeMin = 1;
    public $pageSizeMax = 1000;
    public $pageSizeDefault = 10;
    
    /**
     * Available core modules
     * @var array
     */
    public $coreModules = array(
        'insertions'    => ['Menu' => false, 'Title' => 'Вставки',                   'Description' => 'Информационные блоки, размещаемые на страницах сайта с информацией из разделов сайта'], 
        'widgets'       => ['Menu' => true,  'Title' => 'Виджеты',                   'Description' => 'Информационные и функциональные блоки, размещаемые на страницах сайта'], 
        'quotes'        => ['Menu' => true,  'Title' => 'Цитаты',                    'Description' => 'Блок с возможностью случайного отображение текста/графики/произвольного кода из списка'], 
        'interaction'   => ['Menu' => true,  'Title' => 'Интерактив',                'Description' => 'Комментарии и рейтинги'], 
        'comments'      => ['Menu' => true,  'Title' => 'Комментарии<sup>old</sup>', 'Description' => 'Комментарии и рейтинги, старый функционал'], 
        'sendform'      => ['Menu' => true,  'Title' => 'Результаты форм',           'Description' => 'Результаты форм, отпраленных со страниц сайта'], 
        'users'         => ['Menu' => true,  'Title' => 'Пользователи',              'Description' => 'Зарегистрированные пользователи сайта'], 
        'filemanager'   => ['Menu' => true,  'Title' => 'Файловый менеджер',         'Description' => 'Управление загруженными файлами и загрузка новых файлов на сайт'], 
        'sections'      => ['Menu' => true,  'Title' => 'Структура сайта',           'Description' => 'Управление структурой сайта, созданиеи и редактирование разделов сайта'], 
        'site'          => ['Menu' => true,  'Title' => 'Параметры сайта',           'Description' => 'Общие параметры сайта (название, заголовок, мета тэги и пр.)'], 
        'xmlsitemap'    => ['Menu' => true,  'Title' => 'Обновить XmlSitemap',       'Description' => 'Обновление XML карты сайта'], 
    );
    
    /**
     * Available actions
     * @var array
     */
    public $actions = array(
        'filter', 
        'sort', 
        'add', 
        'edit', 
        'insert', 
        'update', 
        'disable', 
        'enable', 
        'delete', 
    );
    
    /**
     * Actions to display form view (else - items view)
     * @var array
     */
    public $actionsForm = array('add', 'edit');
    
    /**
     * Actions to make somthing and then get output
     * @var array
     */
    public $actionsMake = array('delete', 'update', 'disable', 'enable');
    
    /**
     * @param string $action
     */
    public function registerAction($action)
    {
        if (!in_array($action, $this->actions)) {
            $this->actions = array_merge($this->actions, array($action));
        }
    }
    
    /**
     * @param string $action
     */
    public function registerFormAction($action)
    {
        if (!in_array($action, $this->actionsForm)) {
            $this->actionsForm = array_merge($this->actionsForm, array($action));
        }
    }
    
    /**
     * @param string $action
     */
    public function registerMakeAction($action)
    {
        if (!in_array($action, $this->actionsMake)) {
            $this->actionsMake = array_merge($this->actionsMake, array($action));
        }
    }
}
