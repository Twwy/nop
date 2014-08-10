<?php

$list = array(
	array('name' => 'ReflectionClass', 'type' => 'class', 'desc' => '反射类不存在'),
	array('name' => 'Closure', 'type' => 'class', 'desc' => '闭包不存在'),
	array('name' => 'strcasecmp', 'type'=> 'function', 'desc' => 'strcasecmp方法不存在'),
	array('name' => 'func_num_args', 'type'=> 'function', 'desc' => 'func_num_args方法不存在'),
	array('name' => 'func_get_args', 'type'=> 'function', 'desc' => 'func_get_args方法不存在'),
	array('name' => 'preg_match', 'type'=> 'function', 'desc' => 'preg_match方法不存在')
);

$err = 0;

foreach($list as $one){
	switch($one['type']){
		case 'class':
			if(!class_exists($one['name'])){
				$err++;
				echo "{$one['desc']}\r\n";
			};
			break;
		case 'function':
			if(!function_exists($one['name'])){
				$err++;
				echo "{$one['desc']}\r\n";
			};
			break;
	}
}

if($err == 0){
	echo "检查完毕，环境符合\r\n";
}else{
	echo "检查完毕，环境存在{$err}个问题，请检查\r\n";
}

?>
