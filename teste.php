<?php

require_once("DB.php");


class Teste 
{

	public $nome;
	public $id;

	public function __construct () {
		$this->nome = "Teste de Souza";
		$this->id = 5;
	}	

}

function objectToObject($instance, $className) {
    return unserialize(sprintf(
        'O:%d:"%s"%s',
        strlen($className),
        $className,
        strstr(strstr(serialize($instance), '"'), ':')
    ));
}

$DB = new DB();
$teste = new Teste();

echo '<pre>'; print_r(objectToObject($DB->execute(SELECT_QUERY, "teste", array("id" => 5)), "Teste")); die();


