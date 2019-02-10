<?php

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_POST['email'])) {

    if(!isset($_POST['imie']) ||
        !isset($_POST['email']) ||
        !isset($_POST['temat']) ||
        !isset($_POST['tresc'])) {
            $message = "Wypelnij dane!";
            echo "<SCRIPT type='text/javascript'> //not showing me this
            alert('$message');
            window.location.replace(\"kontakt.php\");
            </SCRIPT>";       
    }
    
 
 
  if(strlen($_POST['tresc']) < 2) {
      // $message = "Za mala tresc!";
      //       echo "<SCRIPT type='text/javascript'> //not showing me this
      //       alert('$message');
      //       window.location.replace(\"kontakt.php\");
      //       </SCRIPT>";
  }

  try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $imie = mysqli_real_escape_string($connect, $_POST['imie']);
          $email_from = mysqli_real_escape_string($connect, $_POST['email']);
          $temat = mysqli_real_escape_string($connect, $_POST['temat']);
          $tresc = mysqli_real_escape_string($connect, $_POST['tresc']);
          if(!$result = $connect->query(
            "INSERT INTO email (imie, email_from, temat, tresc)
            VALUES('$imie', '$email_from', '$temat', '$tresc') ")){
                throw new Exception($connect->error);
            } else {
                  $message = "Dziekuje za wyslanie maila";
                  echo "<SCRIPT type='text/javascript'> //not showing me this
                  alert('$message');
                  window.location.replace(\"kontakt.php\");
                  </SCRIPT>";
            }
          }
      } catch (Exception $e){
        $message = "Wystapil blad! Sprobuj pozniej";
         echo "<SCRIPT type='text/javascript'> //not showing me this
                  alert('$message');
                  window.location.replace(\"kontakt.php\");
                  </SCRIPT>";
      }    
}

?>