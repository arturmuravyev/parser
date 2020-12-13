<?php
	require_once("Parser.php");

	$url = 'https://xn--80aesfpebagmfblc0a.xn--p1ai/information/';
	$page = Parser::getPage($url);
	
	if($page){
		$dataObj = Parser::getDataObj($page);
		Parser::printObj($dataObj);
	}else{
		echo '#Cannot connect...';
	}

?>