<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Класс для работы с кэшем
 */

class Cache {

    private static $_stat=array(
            'time' =>0,
            'count' => 0,
            'count_get' => 0,
            'count_set' => 0,
    );

    private static $_backend=null;
    private static $_useCache;
    private static $_cacheType;
    
    /**
     * Инициализация модуля
     */
    public static function initModule() {

        /**
         * Типы кеширования: file и memory
         */
        define('CACHE_TYPE_FILE','file');
        define('CACHE_TYPE_MEMORY','memory');

        require_once(Config::getValue('path', 'libs').'zendcache/config.php');
        require_once('Zend/Cache.php');
        require_once('Cache/Backend/MemcachedMultiload.php');
        require_once('Cache/Backend/TagEmuWrapper.php');
        require_once('Cache/Backend/Profiler.php');

        self::$_useCache=Config::getValue('cache','use');
        self::$_cacheType=Config::getValue('cache','type');

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
            self::disable();
        }

        if (!self::$_useCache) return false;
        if (self::$_cacheType==CACHE_TYPE_FILE) {
            require_once('Zend/Cache/Backend/File.php');
            $cache = new Zend_Cache_Backend_File(
                    array(
                            'cache_dir' => Config::getValue('path','cache'),
                            'file_name_prefix'	=> Config::getValue('cache','prefix'),
                            'read_control_type' => 'crc32',
                            'hashed_directory_level' => 1,
                            'read_control' => true,
                            'file_locking' => true,
                    )
            );
            self::$_backend = new Dklab_Cache_Backend_Profiler($cache,'Cache::calcStat');
        } elseif (self::$_cacheType==CACHE_TYPE_MEMORY) {
            require_once('Zend/Cache/Backend/Memcached.php');

            $cache = new Zend_Cache_Backend_Memcached(
                    array(
                            'servers' => array( array(
                                            'host' => '127.0.0.1',
                                            'port' => '11211'
                                    ) ),
                            'compression' => true
                    ) );

            self::$_backend = new Dklab_Cache_Backend_TagEmuWrapper(
                    new Dklab_Cache_Backend_Profiler($cache,'Cache::calcStat')
            );
        }
        /* Удаляем кэш в случайном порядке */
        if (rand(1,50)==25) {
            self::cleanCache(Zend_Cache::CLEANING_MODE_OLD);
        }
    }

    /**
     * Отключить кеширование на данной странице
     */
    public static function disable() {
        self::$_useCache=false;
    }

    /**
     * Получить значение из кеша
     */
    public static function getValue($name) {
        if (!self::$_useCache) return false;
        $name=md5(Config::getValue('cache','prefix').$name);
        $data=self::$_backend->load($name);
        if (self::$_cacheType==CACHE_TYPE_FILE and $data!==false) {
            return unserialize($data);
        } else {
            return $data;
        }
    }

    /**
     * Записать значение в кеш
     */
    public static function setValue($name,$data,$tags=array(),$lifetime=false) {
        if ($lifetime==false) $lifetime=60*60;
        if (!self::$_useCache) return false;
        $name=md5(Config::getValue('cache','prefix').$name);
        if (self::$_cacheType==CACHE_TYPE_FILE) {
            $data=serialize($data);
        }
        return self::$_backend->save($data,$name,$tags,$lifetime);
    }

    /**
     * Удаляет значение из кеша по ключу(имени)
     */
    public static function deleteValue($name) {
        if (!self::$_useCache) return false;
        $name=md5(Config::getValue('cache','prefix').$name);
        return self::$_backend->remove($sName);
    }

    /**
     * Чистит кеши
     */
    public static function cleanCache($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array()) {
        if (!self::$_useCache) return false;
        return self::$_backend->clean($mode,$tags);
    }

    /**
     * Статистика использования кеша
     */
    public static function calcStat($time,$method) {
        self::$_stat['time']+=$time;
        self::$_stat['count']++;
        if ($method=='Dklab_Cache_Backend_Profiler::load') {
            self::$_stat['count_get']++;
        }
        if ($method=='Dklab_Cache_Backend_Profiler::save') {
            self::$_stat['count_set']++;
        }
    }

    public static function getStat() {
        return self::$_stat;
    }
}