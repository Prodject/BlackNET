<?php
include_once '../session.php';
include_once '../vendor/auth/FixedBitNotation.php';
include_once '../vendor/auth/GoogleAuthenticator.php';
include_once '../vendor/auth/GoogleQrUrl.php';


$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
$status = isset($_POST['enable']) ? "on" : "";
$code = isset($_POST['code']) ? $_POST['code'] : null;
$secret = isset($_POST['secret']) ? $_POST['secret'] : null;
$username = $_POST['username'];

if ($csrf != $_POST['csrf']) {
	$database->redirect("../authsettings.php?msg=csrf");
} else {
	if ($status == ""){
		$user->enables2fa($username,$secret,$status);
		$database->redirect("../authsettings.php?msg=ok&code=disable");
	} else {
		if ($g->checkCode($secret, $code)) {
			$user->enables2fa($username,$secret,$status);
		    $database->redirect("../authsettings.php?msg=ok&code=enable");
		} else {
			$database->redirect("../authsettings.php?msg=error");
		}
	}
}
?>