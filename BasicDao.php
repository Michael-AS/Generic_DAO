<?php

require_once("IDAO.php");
require_once("DB.php");

class BasicDao extends DB implements IDAO
{
	
public function selectOne ($tableName, $id) {
		return $this->buildInstance($this->execute(self::SELECT_QUERY, $tableName, array("id" => $id)), $tableName);
	}

	public function selectAll ($tableName) {
		return $this->select($tableName);
	}

	public function select ($tableName, $conditions = array()) {
		$aReturn = array();
		foreach ($this->execute(self::SELECT_QUERY, $tableName, $conditions) as $k => $object)
			array_push($aReturn, $this->buildInstance((object)$object, $tableName));
		return $aReturn;

	}

	public function update ($object) {
		return $this->execute(self::UPDATE_QUERY, $object);
	}

	public function delete ($object) {
		return $this->execute(self::DELETE_QUERY, $object);
	}

	public function insert ($object) {
		return $this->execute(self::INSERT_QUERY, $object);
	}


	private function buildInstance ($object, $classname) {
	    return unserialize(sprintf(
	        'O:%d:"%s"%s',
	        strlen($classname),
	        $classname,
	        strstr(strstr(serialize($object), '"'), ':')
	    ));
	}

}