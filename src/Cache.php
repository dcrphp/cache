<?php
declare(strict_types=1);


namespace DcrPHP\Cache;

use DcrPHP\Config\Config;
use Doctrine\Common\Cache\Cache as DCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\MongoDBCache;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Cache\PredisCache;
use Doctrine\Common\Cache\SQLite3Cache;
use Doctrine\Common\Cache\VoidCache;

class Cache implements DCache
{
    private $config = array();
    /**
     * @var cache实例
     */
    private $cacheInstance;
    private $configTip = "请启用或配置好cache:https://github.com/dcrphp/core/wiki/说明:缓存";

    public function setConfig($config){
        $this->config['cache'] = $config;
    }

    public function setConfigFile($config){
        $clsConfig = new Config($config);
        //$clsConfig->addFile($config);
        $clsConfig->setDriver('php');//解析php格式的
        $clsConfig->init();
        $this->config = $clsConfig->get();
    }

    public function init()
    {
        $cacheConfig = $this->config['cache'];
        $type = $cacheConfig['type'];
        $configDetail = $cacheConfig[$type];
        switch ($type) {
            case 'void':
                $this->cacheInstance = new VoidCache();
                break;
            case 'array':
                $this->cacheInstance = new ArrayCache();
                break;
            case 'php_file':
                $this->cacheInstance = new PhpFileCache($configDetail['path']);
                break;
            case 'file':
                $this->cacheInstance = new FilesystemCache($configDetail['path']);
                break;
            case 'redis_cluster':
                $client = new \Predis\Client($configDetail['host'], array('cluster' => 'redis'));
                $this->cacheInstance = new PredisCache($client);
                break;
            case 'redis':
                $client = new \Redis();
                $client->connect($configDetail['host'], $configDetail['port']);
                if ($configDetail['password']) {
                    $client->auth($configDetail['password']);
                }
                $this->cacheInstance = new RedisCache($client);
                break;
            case 'sqlite':
                $db = new \SQLite3($configDetail['path']);
                $this->cacheInstance = new SQLite3Cache($db, $configDetail['database']);
                break;
            case 'mongodb':
                $manager = new \MongoDB\Driver\Manager("mongodb://{$configDetail['host']}:{$configDetail['port']}");
                $collection = new \MongoDB\Collection($manager, $configDetail['database'], $configDetail['collection']);
                $this->cacheInstance = new MongoDBCache($collection);
                break;
            case 'memcache':
                $memcache = new \Memcache();
                $memcache->connect($configDetail['host'], $configDetail['port']);

                $cache = new MemcacheCache();
                $cache->setMemcache($memcache);
                $this->cacheInstance = $cache;
                break;
            case 'memcached':
                $memcached = new \Memcached();
                $memcached->addServer($configDetail['host'], $configDetail['port']);

                $cache = new MemcachedCache();
                $cache->setMemcache($memcached);
                $this->cacheInstance = $cache;
                break;
        }
    }


    /**
     * 本来可以用这个，但implements了接口 没办法
     * public function __call($method, $args)
     * {
     * if (!$this->cacheInstance) {
     * $this->init();
     * }
     *
     * return call_user_func_array([$this->cacheInstance, $method], $args);
     * }
     */

    public function fetch($id)
    {
        // TODO: Implement fetch() method.
        if (! $this->cacheInstance instanceof DCache) {
            $this->init();
        }
        if (! $this->cacheInstance instanceof DCache) {
            throw new \Exception($this->configTip);
        }
        return $this->cacheInstance->fetch($id);
    }

    public function contains($id)
    {
        // TODO: Implement contains() method.
        if (! $this->cacheInstance instanceof DCache) {
            $this->init();
        }
        if (! $this->cacheInstance instanceof DCache) {
            throw new \Exception($this->configTip);
        }
        return $this->cacheInstance->contains($id);
    }

    public function save($id, $data, $lifeTime = 0)
    {
        // TODO: Implement save() method.
        if (! $this->cacheInstance instanceof DCache) {
            $this->init();
        }
        if (! $this->cacheInstance instanceof DCache) {
            throw new \Exception($this->configTip);
        }
        return $this->cacheInstance->save($id, $data, $lifeTime);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        if (! $this->cacheInstance instanceof DCache) {
            $this->init();
        }
        if (! $this->cacheInstance instanceof DCache) {
            throw new \Exception($this->configTip);
        }
        return $this->cacheInstance->delete($id);
    }

    public function getStats()
    {
        // TODO: Implement getStats() method.
        if (! $this->cacheInstance instanceof DCache) {
            $this->init();
        }
        if (! $this->cacheInstance instanceof DCache) {
            throw new \Exception($this->configTip);
        }
        return $this->cacheInstance->getStats();
    }
}