<?php
/**
 * UFOCMS v2 Content Management System
 * 
 * @copyright   Copyright (C) 2005 - 2017 Enikeishik <enikeishik@gmail.com>. All rights reserved.
 * @author      Enikeishik <enikeishik@gmail.com>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Ufocms\Frontend;

/**
 * Класс CAPTCHA.
 */
class Captcha
{
    /**
     * @var Debug
     */
    protected $debug = null;
    
    /**
     * @var Config
     */
    protected $config = null;
    
    /**
     * Имя переменной ключа, передаваемой в GET при запросе картинки.
     * @var string
     */
    protected $htgetFieldKey = 'key';
    
    /**
     * Имя переменной ключа, передаваемые в POST при использовании CAPTCHA.
     * @var string
     */
    protected $htpostFieldKey = '!CaptchaKey';
    
    /**
     * Имя переменной значения, передаваемые в POST при использовании CAPTCHA.
     * @var string
     */
    protected $htpostFieldValue = '!CaptchaValue';
    
    /**
     * Объект работы со стэком.
     * @var Stack
     */
    protected $stack = null;
    
    /**
     * Файл стека, хранит временные ключи картинок.
     * @var string
     */
    protected $stackFile = '~captchagen_stack.txt';
    
    /**
     * Время жизни ключей в стеке.
     * @var string
     */
    protected $stackLifetime = 600;
    
    /**
     * Цвет фона.
     * @var array<R, G, B>
     */
    protected $bgColor = array(0xEE, 0xEE, 0xFF);
    
    /**
     * Цвет теней.
     * @var array<R, G, B>
     */
    protected $shColor = array(0xCC, 0xCC, 0xEE);
    
    /**
     * Цвет текста.
     * @var array<R, G, B>
     */
    protected $fgColor = array(0x99, 0x99, 0xCC);
    
    /**
     * Уровень сжатия JPEG.
     * @var int<0-100>
     */
    protected $jpegQuality = 15;
    
    /**
     * Размер шрифта.
     * @var int<1-100>
     */
    protected $font = 5;
    
    /**
     * Разделитель между символами.
     * @var string
     */
    protected $letterSeparator = ' ';
    
    /**
     * Параметры CAPTCHA.
     * @var array
     */
    protected $data = null;
    
    /**
     * Конструктор.
     * @param Config &$config = null
     * @param Debug &$debug = null
     */
    public function __construct(&$config = null, &$debug = null)
    {
        $this->debug =& $debug;
        if (null === $config) {
            $this->config = new Config();
        } else {
            $this->config =& $config;
        }
        $this->stack = new Stack($this->config, $this->debug);
        $this->stack->set($this->stackFile, $this->stackLifetime);
        if (isset($this->config->captcha)) {
            //TODO: may be overwrite only some props?
            foreach ($this->config->captcha as $name => $value) {
                if (!property_exists($this, $name)) {
                    continue;
                }
                $this->$name = $value;
            }
        }
    }
    
    /**
     * @return string
     */
    protected function getRandomData()
    {
        return (string) mt_rand(1000, 9999); //можно и усложнить
    }
    
    /**
     * Отображение картинки по-умолчанию (ошибки) CAPTCHA.
     */
    protected function showImageError()
    {
        //выводим картинку с надписью 'ERROR', пока вывод пустой картинки
        @header('Content-type: image/gif');
        echo "\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\xFF\xFF\xFF" . 
             "\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00" . 
             "\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B";
    }
    
    /**
     * @param string $data
     * @return string
     */
    protected function separateData($data)
    {
        if ($this->letterSeparator != '') {
            $dataSeparated = '';
            for ($i = 0, $dataLength = strlen($data); $i < $dataLength; $i++) {
                $dataSeparated .= $data{$i} . $this->letterSeparator;
            }
            $data = substr($dataSeparated, 0, strlen($dataSeparated) - strlen($this->letterSeparator));
        }
        return $data;
    }
    
    /**
     * Отображение картинки CAPTCHA.
     */
    public function showImage()
    {
        if (!isset($_GET[$this->htgetFieldKey])) {
            return;
        }
        
        $data = $this->stack->getDataByKey($_GET[$this->htgetFieldKey]);
        if (false === $data) {
            $this->showImageError();
            return;
        }
        $data = $this->separateData($data);
        $this->letterSeparator = '  ';
        $randomData1 = $this->separateData($this->getRandomData());
        $randomData2 = $this->separateData($this->getRandomData());
        
        //генерируем картинку с данными, искажая их по необходимости
        $img = @imagecreate(120, 60);
        if (false === $img) {
            $this->showImageError();
            return;
        }
        
        list($r, $g, $b) = $this->bgColor;
        $bg =  imagecolorallocate($img, $r, $g, $b);
        list($r, $g, $b) = $this->fgColor;
        $fg =  imagecolorallocate($img, $r, $g, $b);
        list($r, $g, $b) = $this->shColor;
        $sh =  imagecolorallocate($img, $r, $g, $b);
        unset($r, $g, $b);
        imagestring($img, $this->font, mt_rand(5, 60), mt_rand(5, 40), $data, $fg);
        imagestring($img, $this->font, mt_rand(1, 60), mt_rand(1, 20), $randomData1, $sh);
        imagestring($img, $this->font, mt_rand(1, 60), mt_rand(21, 40), $randomData2, $sh);
        @header('Content-type: image/jpeg');
        @header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time() - 1000000) . ' GMT');
        @header('Cache-Control: no-store');
        @header('Expires: ' . gmdate('D, d M Y H:i:s', time() - 1000000) . ' GMT');
        imagejpeg($img, null, $this->jpegQuality);
        imagedestroy($img);
    }
    
    /**
     * Возвращает данные CAPTCHA для генерации HTML кода.
     * @return array|false
     */
    public function getData()
    {
        if (null !== $this->data) {
            return $this->data;
        }
        //генерируем случайные данные
        $randomData = $this->getRandomData();
        //уникальный ключ для каждой записи
        $ticket = time() . mt_rand(0, 1000000);
        //убираем устаревшие записи и добавляем новую
        $this->stack->clearOld();
        if (!$this->stack->push($randomData, $ticket)) {
            return false;
        }
        $this->data = array(
            'GetFieldKey'    => $this->htgetFieldKey,
            'PostFieldKey'   => $this->htpostFieldKey,
            'PostFieldValue' => $this->htpostFieldValue,
            'Ticket'         => $ticket
        );
        return $this->data;
    }
    
    /**
     * Возвращает сгенерированный HTML код.
     * @see show
     * @return string
     */
    public function get()
    {
        ob_start();
        $this->show();
        return ob_get_clean();
    }
    
    /**
     * Поиск требуемого шаблона. Возвращаемый путь может не существовать.
     * @return string
     */
    protected function findTemplate()
    {
        if (defined('C_THEME') && '' != C_THEME) {
            $template = $this->config->rootPath . 
                        $this->config->templatesDir . '/' . C_THEME . 
                        $this->config->templatesCaptchaEntry;
            if (file_exists($template)) {
                return $template;
            }
        }
        $template = $this->config->rootPath . 
                    $this->config->templatesDir . $this->config->themeDefault . 
                    $this->config->templatesCaptchaEntry;
        return $template;
    }
    
    /**
     * Отображение HTML кода полей формы CAPTCHA.
     */
    public function show()
    {
        if (!$captcha = $this->getData()) {
            @header('HTTP/1.0 500 Internal Server Error');
            exit();
        }
        require $this->findTemplate();
    }
    
    /**
     * Проверка CAPTCHA.
     * @return bool
     */
    public function check()
    {
        if (!isset($_POST[$this->htpostFieldKey]) 
        || !isset($_POST[$this->htpostFieldValue])) {
            return false;
        }
        $key = $_POST[$this->htpostFieldKey];
        $value = $_POST[$this->htpostFieldValue];
        if ('' == $key || '' == $value) {
            return false;
        }
        
        $stackValue = $this->stack->getDataByKey($key);
        if (false === $stackValue) {
            return false;
        }
        //убираем текущую запись в любом случае
        //при успехе - чтобы избежать повтороа по F5
        //при неуспехе - чтобы избежать брутфорса
        $this->stack->remove($key);
        return $value == $stackValue;
    }
}
