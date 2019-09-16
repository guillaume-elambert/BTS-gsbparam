<?php

require_once("../util/class.pdoGsbParam.inc.php");

$pdoTest = PdoGsbParam::getPdoGsbParam();

$lesCategs = $pdoTest-> getLesCategories();
var_dump($lesCategs);
var_dump($lesCategs[0]['id']);

?>