<?php
include_once '../session.php';
include_once '../classes/Clients.php';

if ($csrf != $_POST['csrf']) {
	$database->redirect("../viewlogs.php?msg=csrf");
} else {
	$client = new Clients;
	$logs = isset($_POST['log']) ? implode(',', $_POST['log']) : '';
	$client->deleteLog($logs);
	$database->redirect("../viewlogs.php?msg=yes");
}
?>