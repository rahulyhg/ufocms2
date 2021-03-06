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
 * Класс кэширования данных с хранилищем в виде набора текстовых файлов.
 */
class Cache
{
    /**
     * @var Config
     */
    protected $config = null;
    
    /**
     * Файл, в котором хранится кэш для текущего хеша.
     * @var string
     */
    protected $cacheFile = '';
    
    /**
     * Конструктор класса.
     * @param Config &$config = null
     * @param string $hash
     */
    public function __construct(&$config, $hash)
    {
        $this->config =& $config;
        if ('' == $hash) {
            $hash = 'empty,' . time();
        } else if (preg_match('/[^A-Za-z0-9~_,\.\/\-]|(\.{2})/', $hash)) {
            $hash = md5($hash);
        } else {
            $hash = str_replace('/', ',', $hash);
        }
        $this->cacheFile =  $this->config->rootPath . 
                            $this->config->cacheDir . 
                            '/' . $hash;
    }
    
    /**
     * Получение кэша.
     * @return string
     */
    public function load()
    {
        if (!is_readable($this->cacheFile)) {
            return false;
        }
        return file_get_contents($this->cacheFile);
    }
    
    /**
     * Сохранение данных в кэш
     * @param string $data  данные
     * @return boolean
     */
    public function save($data)
    {
        if (file_exists($this->cacheFile)) {
            if (md5($data) == md5_file($this->cacheFile)) {
                if (touch($this->cacheFile)) {
                    return true;
                }
            }
        }
        if (!$handle = fopen($this->cacheFile, 'w')) {
            return false;
        }
        $written = false;
        if (flock($handle, LOCK_EX | LOCK_NB)) {
            fwrite($handle, $data);
            fflush($handle);
            flock($handle, LOCK_UN);
            $written = true;
        }
        fclose($handle);
        return $written;
    }
    
    /**
     * Проверка существования кэша.
     * @return boolean
     */
    public function exists()
    {
        return file_exists($this->cacheFile);
    }
    
    /**
     * Проверка не устарел ли кэш.
     * @return bool
     */
    public function expired()
    {
        clearstatcache();
        if (!$this->exists()) {
            return true;
        }
        /* TODO: check on *nix systems!
        echo time() - filemtime($this->cacheFile);
        echo '<br>';
        echo time() - filectime($this->cacheFile);
        */
        return $this->config->cacheLifeTime < (time() - filemtime($this->cacheFile));
    }
    
    /**
     * Удаление файлов кэша, срок хранения которых истек.
     */
    public function deleteOld()
    {
        $dir = $this->config->rootPath . $this->config->cacheDir;
        clearstatcache();
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                $filePath = $dir . '/' . $file;
                if (is_file($filePath) && 0 !== strpos($file, '.')) {
                    if ($this->config->cacheSaveTime < (time() - filectime($filePath))) {
                        if (!@unlink($filePath)) {
                            //$this->writeLog(sprintf($this->errors->fsUnlink, $filePath), $config->logError);
                        }
                    }
                }
            }
            closedir($dh);
        } else {
            //$this->writeLog(sprintf($this->errors->fsOpenDir, $dir), $config->logError);
        }
    }
}
