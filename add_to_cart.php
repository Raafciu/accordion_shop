<?php
echo "echo "<SCRIPT type='text/javascript'> alert(\"DUPA\"); </SCRIPT>";
 require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    echo
    try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
                $produkt = $_POST['id_produkt'];
                $user_id = $_SESSION['user_id'];
                $ilosc = $_POST['ilosc'];
                if(!$result_insert = $connect -> query(
                    "INSERT INTO zamowienia (id_produkt,ilosc,user_id)
                    VALUES ('$produkt','$ilosc', '$user_id')")){
                        throw new Exception($connect->error);    
                    } else{
                        $result->free_result();
                        header('Location: produkty_cyfrowe.php');
                    }
        $connect->close();
    } catch (Exception $e ) {
        $message = "Brak polaczenia z serwerem!";
        echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"index.php\");
        </SCRIPT>";
    } 

?>