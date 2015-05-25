<?php

require 'repo.php';

$repo = new Repository();

$case = $_GET['method'];

switch ($case) {
    
    case save:
	noget med repo->find her
		$response = $repo->save($_GET['user'],$_GET['posx'],$_GET['posy']);
		echo $response;
        break;
	
    default:
        
}

var_dump($_GET);

?>