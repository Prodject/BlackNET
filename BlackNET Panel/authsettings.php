<?php
include_once 'session.php';
include_once 'vendor/auth/FixedBitNotation.php';
include_once 'vendor/auth/GoogleAuthenticator.php';
include_once 'vendor/auth/GoogleQrUrl.php';


$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
$secret = $g->generateSecret();
$qrcode = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($_SESSION['login_user'], $secret, 'BlackNET');
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'components/meta.php'; ?>
	<title>BlackNET - 2 Factor Authentication Settings</title>
	<?php include_once 'components/css.php'; ?>
	<link href="asset/css/bootstrap-switch.css" rel="stylesheet">
</head>
<body id="page-top">
	<?php include_once 'components/header.php'; ?>
	<div id="wrapper">
		<div id="content-wrapper">
			<div class="container-fluid">
	          <ol class="breadcrumb">
	            <li class="breadcrumb-item">
	              <a href="#">2 Factor Authentication Settings</a>
	            </li>
	          </ol>
	          <div class="card mb-3">
	          	<div class="card-header">
              		<i class="fas  fa-user-circle"></i> 2 Factor Authentication Settings
	          	</div>
	          	<form method="POST" action="includes/updateAuth.php">
	          		<input type="text" name="csrf" value="<?php echo $csrf ?>" hidden="">
	          		<div class="card-body">
	          			<div class="container container-special">
	          				<?php if(isset($_GET['msg'])): ?>
	          					<?php if($_GET['msg'] == "error"): ?>
		          				<div class="alert alert-danger">
		          					<span class="fas fa-times-circle"></span> Authentication Code is incorrect
		          				</div>
	          					<?php endif; ?>
	          					<?php if(isset($_GET['code'])): ?>
	          					<div class="alert alert-success">
	          						<?php if($_GET['code'] == "enable"): ?>
			          					<span class="fas fa-check-circle"></span> 2 Factor Authentication has been enabled
			          				<?php else: ?>
			          					<span class="fas fa-check-circle"></span> 2 Factor Authentication has been disbaled
	          						<?php endif; ?>
	          					</div>
	          					<?php endif; ?>
		          				<?php if($_GET['msg'] == "csrf"): ?>
		          					<div class="alert alert-danger">
		          						<span class="fas fa-times-circle"></span> CSRF Token is invalid.
		          					</div>
		          				<?php endif; ?>
	          				<?php endif; ?>
	          			</div>
	          			<div class="container container-special">
	          			  <input type="text" name="username" value="<?php echo($data->username); ?>" hidden="">
	                      <?php if($data->s2fa == "off"): ?>
	          				<dir>
	          					<p>
									2FA is an enhanced level of security for your account. Each time you login, an extra step where you will need to enter a unique code will be required to gain access to your account. To enable 2FA please click the button below and download the <b>Google Authenticator</b> app from Apple Store of Play Sore

									<h4>Important</h4>

									You need to scan the code below with the app. You need to backup the QR code below by saving it and save the key somewhere safe in case you lose your phone. You will not be able to login if you can't provide the code. if you disable 2FA and re-enable it, you will need to scan a new code.
	          					</p>
	          				</dir>
		          			<div class="text-center">
		          				<img class="img-fluid justify-content-center" src="<?php echo $qrcode;   ?>" />
		          			</div>
				           <div class="form-group">             
				             <div class="form-label-group">
				                <input class="form-control" type="text" id="secret" name="secret" placeholder="Auth Secret" value="<?php echo $secret; ?>" readonly="" />
				                 <label for="secret">Secret</label>
				             </div>
				           </div>
				           <div class="form-group">             
				             <div class="form-label-group">
				                <input class="form-control" maxlength="6" size="6" type="text" id="code" name="code" placeholder="Authentication Code"  />
				                 <label for="code">Authentication Code</label>
				                 <small for="code" class="small">Get the code from the app</small>
				             </div>
				           </div>
				           <button type="submit" name="enable" class="btn btn-block btn-primary">Enable 2 Factor Authentication</button>
				           <?php else: ?>
				           <button type="submit" name="disable" class="btn btn-block btn-primary">Disable 2 Factor Authentication</button>
	                      <?php endif; ?>
	          			</div>
	          		</div>
	          	</form>
	          </div>
			</div>
			
		</div>
		
	</div>
	<?php include_once 'components/footer.php'; ?>
	<?php include_once 'components/js.php'; ?>
    <script src="asset/js/bootstrap-switch/main.js"></script>
    <script src="asset/js/bootstrap-switch/highlight.js"></script>
    <script src="asset/js/bootstrap-switch/bootstrap-switch.js"></script>
</body>
</html>