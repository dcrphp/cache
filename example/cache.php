<?php

/**
 * 缓存系统请看https://github.com/dcrphp/core/wiki/说明:缓存
 */

return array(
    'enable' => 1,
    'type' => 'file',
    'memcache' => array('host' => 'ip', 'port' => 'port'),
    'memcached' => array('host' => 'ip', 'port' => 'port'),
    'mongodb' => array(
        'host' => 'ip',
        'port' => 'port',
        'database' => 'database',
        'collection' => 'collection'
    ),
    'php_file' => array('path' => 'dir_path'),
    'file' => array('path' => 'dir_path'),
    'redis_cluster' => array(
        'host' => 'tcp://10.10.30.112:6379,tcp://10.10.30.113:6379',
    ),
    'redis' =>
        array(
            'host' => 'host',
            'port' => 'port',
            'password' => 'password',
        ),
    'sqlite' => array('path' => 'sqlite_path', 'database' => 'database',),
);
