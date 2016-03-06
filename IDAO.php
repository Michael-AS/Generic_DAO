<?php

interface IDAO {
	public function selectOne ($tablename, $id);
	public function selectAll ($tablename);
	public function select ($tablename, $conditions = array());
	public function insert ($object);
	public function update ($object);
	public function delete ($object);
}