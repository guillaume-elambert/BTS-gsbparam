<?php

require_once("../util/class.pdoGsbParam.inc.php");

$pdoTest = PdoGsbParam::getPdoGsbParam('');


$lesCategs = $pdoTest-> getLesCategories();

$lesProduits = $pdoTest-> getLesProduitsDeCategorie($lesCategs[0]['id']);
var_dump($lesProduits);
var_dump($lesProduits[0]['id']);

?>