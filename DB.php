<?php

define("INSERT_QUERY", 1);
define("UPDATE_QUERY", 2);
define("DELETE_QUERY", 3);
define("SELECT_QUERY", 4);
define("INI_FILE", "config.ini");

class DB
{	

	private $con;

	function __construct() {
		if (!$config = parse_ini_file(INI_FILE, TRUE)) throw new exception('Unable to open ini file!');
		extract($config['database']);
		$port = isset($port) ? ";port=$port" : "";
		$dns = "{$driver}:host={$host}{$port};dbname=$schema";
		$this->con = new PDO($dns, $username, $password);        
	}

	public function execute ($query_type, $object, $conditions = array()) {
		$tableName = is_object($object) ? get_class($object) : $object; 
		switch ($query_type) {
			case INSERT_QUERY:
				return $this->executeInsertQuery (
					$this->makeQuery($query_type, $tableName, (array)$object, $conditions)
				);
			case SELECT_QUERY:	
				$stmt = $this->con->prepare(
					$this->makeQuery($query_type, $tableName, array(), $conditions)
				);
				$stmt->execute();
				if($stmt->rowCount() == 1)
					return $stmt->fetch(PDO::FETCH_OBJ);			
				else
					return $stmt->fetchAll();
			default:
				return $this->con->exec(
					$this->makeQuery($query_type, $tableName, (array)$object, $conditions)
				);
				break;
		}
	}

	private function executeInsertQuery ($query) {
		$this->con->exec($query);
		return $this->con->lastInsertId();
	}

	public function makeQuery (int $query_type, string $tableName, array $data, array $conditions = array()) {
		switch ($query_type) {
			case INSERT_QUERY:
				$sQuery = "INSERT INTO $tableName ";
				$sQuery .= $this->makeSet($data);
				break;
			case UPDATE_QUERY:
				$sQuery = "UPDATE $tableName ";
				$sQuery .= $this->makeSet($data);
				$sQuery .= "WHERE id = {$data['id']}";
				break;
			case DELETE_QUERY:
				$sQuery = "DELETE FROM $tableName WHERE id = {$data['id']}";
				break;
			case SELECT_QUERY:
				$sQuery = "SELECT * FROM $tableName ";
				$sQuery .= $this->makeWhere($conditions);
				break;
		}
		return $sQuery;
	}

	public function makeSet (array $data) {
		if(!is_array($data)) throw new Exception("Parameter must be array", 500);
		if(!empty($data)) {
			$sSet = " SET ";
			foreach ($data as $field => $value) {
				if(empty($value)) continue;
				$aSet[] = " $field = '$value' ";
			}
			return $sSet . implode(",", $aSet);
		}
		return "";
	}

	public function makeWhere (array $conditions, string $comparator = "AND") {
		if(!is_array($conditions)) throw new Exception("Parameter must be array", 500);
		if(!empty($conditions)) {
			$sWhere = " WHERE ";
			foreach ($conditions as $field => $value) 
				$aWhere[] = " $field = '$value' ";
			return $sWhere . implode($comparator, $aWhere);
		}
		return "";
	}
}
