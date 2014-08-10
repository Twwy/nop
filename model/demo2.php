<?php

class demo2 {

	private $db;

	function __construct($db){
		$this->db = $db;
	}

	public function hello(){
		echo '<br>$demo2->hello()<br>';
		var_dump($this->db);
	}

}

?>
