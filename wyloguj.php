 <?php 
    session_start();

     require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);  
      try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $user_id = $_SESSION['user_id'];
          $session_id = session_id();
        
        if(!$result = $connect->query(
            "DELETE FROM sesja WHERE session_id='$session_id' AND user_id='$user_id'")){
                throw new Exception($connect->error);
            } else {
                $message = "Usunąles uzytkownika!";
                echo "<SCRIPT type='text/javascript'> //not showing me this
                alert('$message');
                window.location.replace(\"konta.php\");
                </SCRIPT>";  
            }    
        $connect -> close();
        }
      } catch (Exception $e){
        $message = "Brak polaczenia z serwerem!";
        echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"index.php\");
        </SCRIPT>";
      } 
    session_unset();
    header('Location: index.php');
?>