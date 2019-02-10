<?php
session_start();

    if((!isset($_SESSION['logged'])) || ($_SESSION['user']!="admin")){
        header('Location: index.php');
        exit();
    }
 require_once "connect.php";
 mysqli_report(MYSQLI_REPORT_STRICT);

 if (isset($_GET['id'])) {
     try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $user_id = $_GET['id'];
        
        if(!$result = $connect->query(
            "INSERT INTO uzytkownicy_aud (user_id, user, email, password, data_dodania)
            select user_id, user, email, password, data_dodania FROM uzytkownicy
             WHERE user_id='$user_id'")){
                throw new Exception($connect->error);
            } else {
                if(!$result = $connect->query(
                    "DELETE FROM uzytkownicy WHERE user_id='$user_id'")){
                        throw new Exception($connect->error);
                    } else {
                    $message = "Usunąles uzytkownika!";
                    echo "<SCRIPT type='text/javascript'> //not showing me this
                    alert('$message');
                    window.location.replace(\"konta.php\");
                    </SCRIPT>";
                }
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
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Accordions">
    <meta name="author" content="Raafciu">
    <title>Accordion Shop</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    <script type="text/javascript">
      function deleteUser(){
        $.ajax({url:"drop_user.php", success:function(){
          location:reload();
        }
        })
      }
    </script>

    </head>

    <body>
  <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-inverse">
            <div class="container">
            <a class="navbar-brand" href="#">Accordions</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Strona główna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produkty_cyfrowe.php">Produkty</a>
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kontakt.php">Kontakt</a>
                </li>

                <?php
                if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true) && ($_SESSION['user']=="admin")){ ?>
                <li class="nav-item active ">
                    <a href = "konta.php" class="nav-link">Konta</a>
                    <span class="sr-only">(current)</span>     
                    </li> 
                <?php } ?>

                    <?php
                if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){ ?>
                <li class="nav-item">
                    <a href = "koszyk.php" class="nav-link">Koszyk</a>    
                    </li> 
                <?php } ?>

                    <?php          
                if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
                    ?>
                    <li class="nav-item">
                    <a class="nav-link" href="#"><?php echo "Witaj ".$_SESSION['user']."!" ?></a>
                    </li> 
                    <li class="nav-item">
                    <a class="nav-link" href="wyloguj.php">Wyloguj</a>
                    </li> 
                <?php 
                } else { ?>
                    <li class="nav-item">
                    <a href = "formularz.php" class="nav-link">
                            Zaloguj się
                    </a>         
                    </li> 
                <?php
                } ?> 
                </ul>
            </div>
            </div>
        </nav>

        <div class="container">
            <hr>
            <h2>Zarzadzanie uzytkownikami</h2>
            <table class="table table-hover">
            <thead>
              <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Zamowienia</th>
                <th>Akcja</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                try {
                  $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
                  if($connect->connect_errno!=0){
                      throw new Exception(mysqli_connect_errno());
                  } else {
                    $sql = "SELECT * FROM uzytkownicy where user!='admin' ORDER BY user_id ASC";
                    if(!$result = $connect -> query($sql)){
                      throw new Exception($connect->error);
                    } else {
                        if(mysqli_num_rows($result) > 0){
                          while($row = mysqli_fetch_array($result)){

                            ?>
                            <tr>
                              <td><?php echo $row['user']; ?></td>
                              <td><?php echo $row['email']; ?></td>
                                <td><a href="zamowienia.php?id=<?php echo $row['user_id']; ?>">
                                    <input type="button" class="btn btn-primary" value="Zamowienia"/>
                                  </a>
                              </td>
                              <td><a href="konta.php?id=<?php echo $row['user_id']; ?>">
                                    <input type="button" class="btn btn-danger" value="Usun"/>
                                  </a>
                              </td>
                            </tr>
                            <?php
                          }
                        }
                      }
                  $connect -> close();
                  }
                }
                catch(Exception $e){
                  $message = "Brak polaczenia z serwerem!";
                  echo "<SCRIPT type='text/javascript'> //not showing me this
                  alert('$message');
                  window.location.replace(\"index.php\");
                  </SCRIPT>";
                }       
                ?>
            </tbody>
          </table>
      </div>

</body>
    </body>
</html>