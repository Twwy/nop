<?php

router('test',function(){
	echo 'this is test page<br>';


	$demo = load('lib', 'demo');
	$demo->hello();

	$demo2 = load('model', 'demo2', db());
	$demo2->hello();
});

?>
