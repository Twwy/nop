<?php

/*{{配置文件}}*/
require('./config.php');

//解析URI
if(strcasecmp(substr($_SERVER['REQUEST_URI'], 0, strlen(URI_PREFIX)), URI_PREFIX) === 0){
	$uri = substr($_SERVER['REQUEST_URI'], strlen(URI_PREFIX));
}else{
	$uri = $_SERVER['REQUEST_URI'];
}
if(empty($uri)) $uri = PAGE_DEFAULT;

//载入器，使用方法 load(路径, 类名, 依赖注入(类中__construct需要的变量，支持多个))
function load($path, $value){
	require_once("./{$path}/{$value}.php");

	$init_args = array();
	if(func_num_args() > 2){
		$list = func_get_args();
		for($i = 2; $i < func_num_args(); $i++) $init_args[] = $list[$i];
	}

	$class = new ReflectionClass($value);
    return $class->newInstanceArgs($init_args);
}

//路由器
$routers = Array();
function router($path, $func){
	global $routers;
	$routers[$path] = $func;
}

//默认路由列表
router(PAGE_DEFAULT,function(){
	echo 'this is default page';
});

router(PAGE_NOTFOUND, function(){
	echo 'this is 404';
});

router(PAGE_ERROR, function(){
	echo 'this is error';
});

//封装一些常用方法

//JSON返回
function json($result, $msg, $data = array()){
	$return = array(
		'result' => (bool)$result,
		'msg' => $msg,
		'data' => $data
	);
	exit(json_encode($return));
}

//过滤器
function filter($input, $rule, $callback){
	if(preg_match($rule, $output = trim($input))) return $output;
	else return $callback($input, $rule);
}

//数据库
function db(){
	return load('lib', 'database', DBHOST, DBNAME, DBUSER, DBPASS, DBPORT);
}

/*{{路由表}}*/
require('routers.php');

//匹配路由
foreach ($routers as $key => $value) if(preg_match('/^'.$key.'$/', $uri, $matches)) exit($value($matches));

//如果没有匹配就返回404
exit($routers[PAGE_NOTFOUND]());


?>

