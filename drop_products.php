<?php
 session_start();

 require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);

 if (isset($_SESSION['user_id'])) {
     try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $user_id = $_SESSION['user_id'];
                      if(!$result_insert = $connect -> query(
                          "INSERT INTO kupione (id_zamowienia, id_produkt, ilosc, user_id)
                           SELECT id_zamowienia,id_produkt,ilosc,user_id FROM zamowienia where user_id='$user_id' ")){
                              throw new Exception($connect->error);    
                          } else{
                              if(!$result_delete = $connect->query(
                                "DELETE FROM zamowienia WHERE user_id='$user_id' AND id_produkt IN 
                                     (SELECT id_produkt FROM produkty WHERE dostepnosc='tak') ")) {
                                     throw new Exception($connect->error);
                                } else {
                                    $message = "Zakupiono! Produkty usuniete z koszyka";
                                    echo "<SCRIPT type='text/javascript'> //not showing me this
                                    alert('$message');
                                    window.location.replace(\"produkty_cyfrowe.php\");
                                    </SCRIPT>";
                                }  
                             }
        $connect -> close();
         }
      } catch (Exception $e){
    //     $message = "Brak polaczenia z serwerem!";
    //     echo "<SCRIPT type='text/javascript'> //not showing me this
    //     alert('$message');
    //     window.location.replace(\"index.php\");
    //     </SCRIPT>";
      }    
}
?>