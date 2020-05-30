<?php
require_once("../vendor/autoload.php");

use DcrPHP\Cache\Cache;

ini_set('display_errors', 'on');
//加载配置
$clsCache = new Cache();
//$clsCache->setConfig( array('enable' => 1, 'driver' => 'php_file') );
$clsCache->setConfigFile('cache.php');
$clsCache->init();
//设置
$clsCache->save('key', 'value', 0);
//获取
echo $clsCache->fetch('key');