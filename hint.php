<?php
require_once "connect.php";
 mysqli_report(MYSQLI_REPORT_STRICT);


 try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
            $string = $_REQUEST["s"];
            $hint = "";

            // lookup all hints from array if $string is different from "" 
            if ($string !== "") {
                $string = strtolower($string);
                $len=strlen($string);

            $string = mysqli_real_escape_string($connect,$string);
        
            if(!$result = $connect->query(
            "SELECT * FROM uzytkownicy where user='$string'" )){
                throw new Exception($connect->error);
            } else { 
                $userNumber = $result->num_rows;
                    if($userNumber>0){
                        echo $hint === "" ? '<span style="color:red">Zajęty</span>' : $hint;
                    } else {
                        echo $hint === "" ? '<span style="color:green">Wolny</span>' : $hint;
                    }
                }          
            }
         $connect -> close();    
        }
    } catch (Exception $e){
    $message = "Brak polaczenia z serwerem!";
    echo "<SCRIPT type='text/javascript'> //not showing me this
    alert('$message');
    window.location.replace(\"formularz.php\");
    </SCRIPT>";
}    
?>