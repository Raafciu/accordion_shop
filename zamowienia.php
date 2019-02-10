<?php
session_start();

    if((!isset($_SESSION['logged'])) || ($_SESSION['user']!="admin")){
        header('Location: index.php');
        exit();
    }
 require_once "connect.php";
 mysqli_report(MYSQLI_REPORT_STRICT);

 if (isset($_GET['nr_zamowienia'])) {
     try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $user_id = $_SESSION['id_buyer'];
          $nr_zamowienia = $_GET['nr_zamowienia'];
        if(!$result = $connect->query(
            "UPDATE kupione SET wyslano='tak' WHERE nr_zamowienia='$nr_zamowienia' ")){
                throw new Exception($connect->error);
            } else {
                    unset($_SESSION['id_buyer']);
                    $message = "Zmieniles status na wyslano!";
                    echo "<SCRIPT type='text/javascript'> //not showing me this
                    alert('$message');
                    window.location.replace(\"zamowienia.php?id=$user_id\");
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
}
 if (isset($_GET['nr_zamowienia2'])) {
     try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $user_id = $_SESSION['id_buyer'];
          $nr_zamowienia = $_GET['nr_zamowienia2'];
        if(!$result = $connect->query(
            "UPDATE kupione SET wyslano='nie' WHERE nr_zamowienia='$nr_zamowienia' ")){
                throw new Exception($connect->error);
            } else {
                    unset($_SESSION['id_buyer']);
                    $message = "zmieniles status na nie wyslano!";
                    echo "<SCRIPT type='text/javascript'> //not showing me this
                    alert('$message');
                    window.location.replace(\"zamowienia.php?id=$user_id\");
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
    <div class="row">
        <div class="col-12">
            <div class="table-responsive" id="mytable">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">Nazwa</th>
                            <th scope="col">Dostępność</th>
                            <th scope="col" class="text-center">Ilość</th>
                            <th scope="col" class="text-center"></th>
                            <th scope="col" class="text-right">Cena</th>
                            <th scope="col" class="text-right">Wyslano</th>
                        </tr>
                    </thead>
                    <tbody>
                          <?php
                          try {
                            $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
                            if($connect->connect_errno!=0){
                                throw new Exception(mysqli_connect_errno());
                            } else {
                              $userId = $_GET['id'];
                              $_SESSION['id_buyer'] = $_GET['id'];
                              $sql = "SELECT k.nr_zamowienia, p.id_produkt,  p.nazwa , p.dostepnosc, p.zdjecie , k.ilosc , p.cena, k.wyslano FROM
                                      kupione k , produkty p , uzytkownicy u WHERE 
                                      k.id_produkt=p.id_produkt and u.user_id = k.user_id and k.user_id='$userId'";
                              if(!$result = $connect -> query($sql)){
                                throw new Exception($connect->error);
                              } else {
                                  if(mysqli_num_rows($result) > 0){
                                    $total = 0;
                                    while($row = mysqli_fetch_array($result)){
                                        if($row['dostepnosc'] == "tak")
                                            $total +=( intval($row['cena']) * intval($row['ilosc']) );
                                        
                                      ?>
                                        
                                      <tr>
                                          <td><img src="<?php echo $row['zdjecie']; ?>" style="height:50px;width:50px;"/> </td>
                                          <td><?php echo $row['nazwa']; ?></td>
                                          <td><?php echo $row['dostepnosc']; ?></td>

                                          <td><input disabled class="form-control" style="text-align:center;" type="text" value="<?php echo $row['ilosc']; ?>" /></td>
                                           <td> 
                                           
                                           </td>                                     
                                          <td class="text-right"><?php echo $row['cena']; ?> zł</td>
                                          <td><?php echo $row['wyslano']; ?></td>
                                          <?php if($row['wyslano'] == 'nie'){ ?>
                                             <td><a href="zamowienia.php?nr_zamowienia=<?php echo $row['nr_zamowienia']; ?>">
                                    <input type="button" class="btn btn-primary" value="Zmień status"/>
                                  </a>
                                    </td> 
                                          <?php } else { ?>
                                           <td><a href="zamowienia.php?nr_zamowienia2=<?php echo $row['nr_zamowienia']; ?>">
                                            <input type="button" class="btn btn-primary" value="Zmień status"/>
                                        </a>
                                          </td> <?php } ?>
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Suma</strong></td>
                            <td class="text-right"><strong><?php if(isset($total)) echo $total; ?> zł</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                   <a href="konta.php" class="btn btn-block btn-light">Powrót </a>
                </div>
                <div class="col-sm-12 col-md-2 text-right">
                <button id="refresh" class="btn btn-sm btn-block btn-warning">Odswież</button>
                </div>
            </div>
        </div>
    </div>

</body>
    </body>
</html>