<?php
  session_start();
  include_once 'classes/Database.php';
  include_once 'classes/User.php';
  include_once 'classes/Auth.php';
  include_once 'vendor/auth/FixedBitNotation.php';
  include_once 'vendor/auth/GoogleAuthenticator.php';
   
   $auth = new Auth;
   $username = $_GET['username'];
   $password = $_GET['password'];
   $uuid = "b440339eb10f46db9a656db5303a09bc";
   $device_agent = $_SERVER['HTTP_USER_AGENT'];
   $uniqeid = hash("sha256", base64_encode($username . $password . $uuid . $device_agent));

   if (checkUniqeId($uniqeid) == true) { $auth->redirect("index.php"); }

   $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $code = $_POST['AuthCode'];
      $secret = $auth->getSecret($username);
      if ($g->checkCode($secret, $code)) {
        if (isset($_POST['remberme'])) {
          if (!isset( $_COOKIE[ '2fa' ] )) {
            setcookie( '2fa', 'true', time() + 2592000);
            setcookie('device_id', $uniqeid ,time() + 2592000 );
          }
        } 
        $auth->redirect("index.php");
      } else {
        $error = "Verification code is incorrect!!";
      }
   }

   function checkUniqeId($uniqeid){
    if (isset( $_COOKIE[ '2fa' ] )) {
      if (isset( $_COOKIE['device_id'] )) {
        if($_COOKIE['device_id'] == $uniqeid){ return true; } else { return false; }
     }
    }
   }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once 'components/meta.php'; ?>

    <title>BlackNET - 2 Factor Authentication</title>

    <?php include_once 'components/css.php'; ?>
  </head>
  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
          <form method="POST">
            <?php if(isset($error)): ?>
               <div class="alert alert-danger"><span class="fa fa-times-circle"></span><?php echo $error; ?></div>
              <?php else: ?>
                <div class="alert alert-primary"><span class="fa fa-info-circle"></span> Please open the app for the code.</div>
              <?php endif; ?>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="AuthCode" pattern="[0-9]{6}" name="AuthCode" class="form-control" placeholder="Verification Code" required="required">
                <label for="AuthCode">Verification Code</label>
              </div>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="remberme" name="remberme">
              <label class="custom-control-label" for="remberme">Trust Device for 30 days</label>
            </div>
            <div class="pt-3">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include_once 'components/js.php'; ?>

  </body>

</html>
