<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){
        header('Location: formularz.php');
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if(!$result = $connect->query(
            sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
            mysqli_real_escape_string($connect,$login)))){
                throw new Exception($connect->error);
            } else { 
           $userNumber = $result->num_rows;
           if($userNumber>0){
                $row = $result->fetch_assoc();
               
                if(password_verify($password, $row['password'])){    
                    $_SESSION['logged'] = true;
                    $_SESSION['user'] = $row['user'];
                    $_SESSION['user_id'] = $row['user_id'];
                    unset($_SESSION['blad']);

                    //ustawianie cookie po zalogowaniu
                    if(!isset($_COOKIE[$cookie_name])){
                        $cookie_name = "user";
                        $cookie_value = $row['user'];
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
                    }

                    //sesja do bazy po zalogowaniu
                    $session_id = session_id();
                    $user_id = $_SESSION['user_id'];
                    if(!$result_insert = $connect->query(
                        "INSERT INTO sesja (session_id, user_id)
                        VALUES ('$session_id' , '$user_id')")){
                            throw new Exception($connect->error);
                    } else {
                        $result->free_result();
                        header('Location: index.php');
                    }


                } else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawdilowy login lub haslo!</span>';
                    header('Location: formularz.php');
                }
           } else{
               $_SESSION['blad'] = '<span style="color:red">Nieprawdilowy login lub haslo!</span>';
               header('Location: formularz.php');
           }
        }

        $connect->close();   
        }
    } catch (Exception $e){
        $_SESSION['blad'] = '<span style="color:red">Blad serwera! Przepraszamy za niedogonosci i prosimy o rejestracje w innym terminie!</span>';
        header('Location: formularz.php');        
        //echo '<br/>Informacja deweloperska: '.$e;
    }
    

    

?>