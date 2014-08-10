<?php

date_default_timezone_set('PRC');

//URI前缀
//http:// + 域名或IP + URI前缀 + 路由 = URL
//example1: 通过浏览器访问的地址是http://127.0.0.1/abc/ok/index.php/aboutme 那么URI前缀请填写 /abc/ok/index.php/
//example2: 通过.htaccess文件进行了URL重写，可以直接访问 http://127.0.0.1/abc/ok/aboutme 那么URI前缀请填写 /abc/ok/
//example3: 如果index.php放在根目录下，URI前缀请填写 / 
//example4: 通过浏览器访问的地址是http://127.0.0.1/abc/ok/index.php?aboutme 那么URI前缀请填写 /abc/ok/index.php?
define('URI_PREFIX', '/jionp/?');


//默认页面的路径
define('PAGE_DEFAULT', 'default');
define('PAGE_NOTFOUND', '404');
define('PAGE_ERROR', 'err');

//数据库配置
define('DBHOST', '127.0.0.1');
define('DBNAME', 'world');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBPORT', '3306');

//版本
define('VERSION', '1.0.0');



?>
