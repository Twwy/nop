<?php

//config
require('./config.php');

//database
require('./database.php');
$db = new database(DBHOST, DBNAME, DBUSER, DBPASS, DBPORT);

//common function: JSON
function json($result, $msg, $data = array()){
	if($result) exit(json_encode(array('result' => true, 'msg' => $msg , 'data' => $data)));
	exit(json_encode(array('result' => false, 'msg' => $msg, 'data' => $data)));                                       
}

//common function: FILTER
function filter($input, $rule, $callback){
	if(preg_match($rule, $output = trim($input))){
		return $output;
	}else{
		return $callback($input, $rule);
	}
}

//common function: POST
function post($name, $rule, $callback){
	if(!isset($_POST[$name])) return $callback('none', $rule);
	return filter($_POST[$name], $rule, $callback);
}

//parse thr url, if empty than redirect to default page
$docPath = str_replace('/', '\/', str_replace('?', '\?', DOCPATH));
preg_match('/'.$docPath.'(.+)$/', $_SERVER['REQUEST_URI'], $match);
$uri = (empty($match)) ? DOCDEFAULT : $match[1];

//model
class model{
	function db(){
		global $db;
		return $db;
	}
}

function model($value){
	require("./model/{$value}.php");
	return new $value;
}


//router
$routers = Array();
function router($path, $func){
	global $routers;
	$routers[$path] = $func;
}

router(DOCDEFAULT,function(){
	echo 'this is default page';
});

router('404', function(){
	echo 'this is 404';
});



//load user routers
require('./home/routers.php');

//match router
foreach ($routers as $key => $value) if(preg_match('/^'.$key.'$/', $uri, $matches)) exit($value($matches));

//if not match then 404
exit($routers['404']());


?>

