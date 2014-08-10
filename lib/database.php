<?php

class database{
	private $dbObj = false;

	function __construct($dbHost, $dbName, $dbUser, $dbPass, $dbPort){
		$this->dbObj = new PDO("mysql:host={$dbHost};dbname={$dbName};port={$dbPort};charset=UTF8", $dbUser, $dbPass, Array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'UTF8';"));
		$this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function query($sql, $type = 'array'){
		switch($type){
			case 'array':
				$dbObj = $this->dbObj->query($sql);
				$result = $dbObj->fetchAll(PDO::FETCH_ASSOC);
				break;
			case 'row':
				$dbObj = $this->dbObj->query($sql);
				$result = $dbObj->fetch(PDO::FETCH_ASSOC);
				break;
			default:
				return false;
		}
		if(!$dbObj) return false;
		if($result) return $result;
		else return Array();
	}

	public function exec($sql){
		return $this->dbObj->exec($sql);
	}

	public function insert($table, $insertArray){
		$columns = array_keys($insertArray);
		$values = array_values($insertArray);
		unset($insertArray);
		foreach($values as $key => $value) $values[$key] = $this->dbObj->quote($value);
		foreach($columns as $key => $value) $columns[$key] = "{$table}.{$value}";
		$columns = implode(',', $columns);
		$values = implode(',', $values);
		$query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
		return $this->dbObj->exec($query);
	}

	public function update($table, $updateArray, $where){
		$updates = Array();
		foreach ($updateArray as $key => $value){
			if($value != NULL) $updates[] = $key.'='.$this->dbObj->quote($value);
			else $updates[] = "{$key} = NULL";
		}
		$updates = implode(',', $updates);
		$query = "UPDATE {$table} SET {$updates} WHERE {$where}";
		return $this->dbObj->exec($query);
	}

	public function del($table, $where){
		$query = "DELETE FROM $table WHERE {$where}";
		return $this->dbObj->exec($query);
	}

	public function insertId(){
		return $this->dbObj->lastInsertId(); 
	}

	public function quote($value){
		return $this->dbObj->quote($value);
	}
}

?>
