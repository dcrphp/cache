# 缓存类说明

### 1、开启缓存:  
　　enable=1  
　　driver=按下面的type来配置  

### 2、type:  
　　memcache,memcached,mongodb,php_file,file,redis_cluster,redis,sqlite,void,array  
　　redis_cluster:要在composer.json中开启predis/predis  
　　void:空缓存，不想用缓存了，配置成这个  
　　redis:请在php.ini中开启phpredis组件  
　　sqlite:请在php.ini中开启sqlite3组件  
　　mongodb:请在php.ini中开启mongo组件  

### 3、缓存配置：
　　参照example的cache.php:  

### 4、使用  
```
$clsCache = new Cache();
//$clsCache->setConfig( array('enable' => 1, 'driver' => 'php_file') );
$clsCache->setConfigFile('cache.php');
$clsCache->init();
//设置
$clsCache->save('key', 'value', 0);
//获取
echo $clsCache->fetch('key');
```