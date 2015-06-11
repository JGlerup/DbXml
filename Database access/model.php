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
		
	case 'info':
		$user = $repo->find($_GET['user']);
		echo json_encode($user);
		var_dump($user);
        break;
		
	case 'delete':
		$response = $repo->deleteUser($_GET['user']);
		echo $response;
        break;
	
    default:
        
}

function to_xml(SimpleXMLElement $object, array $data)
{   
    foreach ($data as $key => $value)
    {   
        if (is_array($value))
        {   
            $new_object = $object->addChild($key);
            to_xml($new_object, $value);
        }   
        else
        {   
            $object->addChild($key, $value);
        }   
    }   
}   

//var_dump($_GET);

?>