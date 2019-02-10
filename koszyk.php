<?php
    session_start();

    if(!isset($_SESSION['logged'])){
    header('Location: index.php');
    exit();
    }

    require "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

if (isset($_GET['id'])) {
     try {
        $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
          $id_produkt = $_GET['id'];
          $user_id = $_SESSION['user_id'];
          
        
          if(!$result = $connect->query(
            "DELETE FROM zamowienia WHERE id_produkt='$id_produkt' AND user_id='$user_id'")){
                throw new Exception($connect->error);
            } else {
                  $message = "Usunąles produkt!";
                  echo "<SCRIPT type='text/javascript'> //not showing me this
                  alert('$message');
                  window.location.replace(\"koszyk.php\");
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
  <title>Koszyk</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
 
 
<script>
$(document).ready(function() {

   function RefreshTable() {
       $( "body" ).load( "koszyk.php" );
   }
   $("#refresh").on("click", RefreshTable);
});
</script>
  </head>
  <body>
  <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-inverse">
            <div class="container">
            <a class="navbar-brand" href="#">Accordions</a>
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
                <li class="nav-item ">
                    <a href = "konta.php" class="nav-link">Konta</a>
                    </li> 
                <?php } ?>

                    <?php
                if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){ ?>
                <li class="nav-item active">
                    <a href = "koszyk.php" class="nav-link">Koszyk</a> 
                    <span class="sr-only">(current)</span>     
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
  <h1>TEST</h1>
</div>
<hr>


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
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                          <?php
                          try {
                            $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
                            if($connect->connect_errno!=0){
                                throw new Exception(mysqli_connect_errno());
                            } else {
                              $userId = $_SESSION['user_id'];
                              $sql = "SELECT p.id_produkt,  p.nazwa , p.dostepnosc, p.zdjecie , z.ilosc , p.cena FROM
                                      zamowienia z , produkty p , uzytkownicy u WHERE 
                                      z.id_produkt=p.id_produkt and u.user_id = z.user_id and z.user_id='$userId'";
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
                                          <td class="text-right"><a href="koszyk.php?id=<?php echo $row['id_produkt']; ?>"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button></a> </td>
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
                   <a href="produkty_cyfrowe.php" class="btn btn-block btn-light">Kontynuuj zakupy </a>
                </div>
                <div class="col-sm-12 col-md-2 text-right">
                <button id="refresh" class="btn btn-sm btn-block btn-warning">Odswież</button>
                </div>
                <div class="col-sm-12 col-md-4 text-right">
                    <a href="zakup_page.php" class="btn btn-lg btn-block btn-success text-uppercase">KUP TERAZ</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
