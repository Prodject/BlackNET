<?php
include_once 'session.php';
try {
	@unlink("upload/" . $_GET['vicid'] . "/" . $_GET['fname']);
	$database->redirect("viewuploads.php?vicid=" . $_GET['vicid'] . "&msg=yes");
	
} catch (Exception $e) {
	
}
?>