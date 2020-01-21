<?php
/*
  this class is to handle user authentication

  how to user
  $auth = new Auth
  $auth->newLogin($_POST['username'],$_POST['password']);
*/
class Auth extends User{
  // function to update 2fa code if needed
	public function updateSecret($username,$secret){
		$pdo = $this->Connect();
        $sql = "UPDATE admin SET secret = :secret WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username'=>$username,'secret'=>$secret]);
	}


  // check login informations
	public function newLogin($username,$password){
     $logme = $this->check_credentials($username,$password);
     $row = $logme->fetch();
     $userCount = $logme->rowCount();
    if($userCount  == 1) {
      if($row->role == "administrator"){
      	return 200;
        } else {
          return 403;
        }
      } else {
          return 500;
      }
	}
    // check if the user exist in the database
    public function check_credentials($username,$password){
      $pdo = $this->Connect();
      $sql = "SELECT * FROM admin WHERE username = :username AND password = :password limit 1";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username'=>$username,'password'=>hash("sha256",$this->salt.$password)]);
      return $stmt;
    }

  // Google Recaptcha API to validate recaptcha v2 response
  public function recaptchaResponse($privatekey,$recaptcha_response_field){
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$privatekey.'&response='.$recaptcha_response_field);
    $responseData = json_decode($verifyResponse);
    return $responseData;
  }

  // check if 2fa is enbaled
  public function isTwoFAEnabled($username){
      $pdo = $this->Connect();
      $sql = "SELECT s2fa FROM admin WHERE username = :username limit 1";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username'=>$username]);
      $data = $stmt->fetch();
      return $data->s2fa;
  }

  public function getSecret($username){
      $pdo = $this->Connect();
      $sql = "SELECT secret FROM admin WHERE username = :username limit 1";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username'=>$username]);
      $data = $stmt->fetch();
      return $data->secret;
  }

}

?>