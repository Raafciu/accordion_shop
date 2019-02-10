<?php    
    session_start();

        if(!isset($_POST['login'])){
            header('Location: rejestracja.php');
            exit();
        }

        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];


        
    if( $password!=$confirm_password){
        $_SESSION['blad_rejestracja'] = '<span style="color:red">Podane hasla nie są takie same!</span>';
        header('Location: rejestracja.php');
        exit();
    }

    if((strlen($login) < 3) || strlen(($login) > 20)){
        $_SESSION['blad_rejestracja'] = '<span style="color:red">Nick musi posiadać od 3 do 20 znaków!</span>';
        header('Location: rejestracja.php');
        exit();
        }

    if(ctype_alnum($login)==false){
        $_SESSION['blad_rejestracja'] = '<span style="color:red">Nazwa użytkownika może skadać się tylko z liter i cyfr!</span>';
        header('Location: rejestracja.php');
        exit();
    }

     if((strlen($password) < 8) || strlen(($password) > 20)){
        $_SESSION['blad_rejestracja'] = '<span style="color:red">Haslo musi posiadać od 8 do 20 znaków!</span>';
        header('Location: rejestracja.php');
        exit();
        }

    $password_hash = password_hash($password,PASSWORD_DEFAULT);

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $email = htmlentities($email, ENT_QUOTES, "UTF-8");

        if(!$result = $connect -> query(
            sprintf("SELECT * FROM uzytkownicy WHERE user='%s' OR email='%s'",
            mysqli_real_escape_string($connect,$login),
            mysqli_real_escape_string($connect,$email)))){
                throw new Exception($connect->error);
            } else{
                $userNumber = $result->num_rows;
                if($userNumber>0){
                    $_SESSION['blad_rejestracja'] = '<span style="color:red">login lub email już istnieje!</span>';
                    header('Location: rejestracja.php');
                } else {              
                     if(!$result_insert = $connect -> query(
                        sprintf("INSERT INTO uzytkownicy (user,email,password)
                        VALUES ('%s','%s', '%s')",
                        mysqli_real_escape_string($connect,$login),
                        mysqli_real_escape_string($connect,$email),
                        mysqli_real_escape_string($connect,$password_hash)))){
                            throw new Exception($connect->error);    
                        } else{
                            $result->free_result();
                            session_unset($_SESSION['blad_rejestracja']);
                            $_SESSION['udana_rejestracja'] = '<span style="color:green">Dziękujemy za rejestracje w serwisie! Teraz już możesz się zalogować!</span>'; 
                            header('Location: formularz.php');
                        }
                }
            }
        $connect->close();
        }
    } catch (Exception $e ) {
        $_SESSION['blad'] = '<span style="color:red">Blad serwera! Przepraszamy za niedogonosci i prosimy o rejestracje w innym terminie!</span>';
        header('Location: formularz.php');  
    } 
?>