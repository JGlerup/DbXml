<?php

require 'repo.php';

$repo = new Repository();

$case = $_GET['method'];

switch ($case) {
    
    case 'save':
	//noget med repo->find her
		$user = $repo->find($_GET['user']);
		var_dump($user);
		$response = $repo->save($_GET['user'],$_GET['location'],$user['Progression']);
		echo $response;
        break;
		
	case 'load':
	//noget med repo->find her
		$user = $repo->find($_GET['user']);
		//var_dump($user);
		$response = $repo->findProgress($user['Progression']);
		echo $response['Position'];
        break;
	
    default:
        
}

//var_dump($_GET);

?>