<?php
session_start();

require_once "connect.php";
 mysqli_report(MYSQLI_REPORT_STRICT);

  if((isset($_POST['add_to_cart'])) && (intval($_POST['ilosc']!=0)) ){
    if(isset($_SESSION['user_id'])){
        try {
            $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
            if($connect->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }else {
              $produkt = $_POST['id_produkt'];
              $user_id = $_SESSION['user_id'];

              if(!$result = $connect -> query(
                "SELECT * FROM zamowienia WHERE id_produkt = '$produkt' AND user_id='$user_id'")){
                  throw new Exception(mysqli_connect_errno());
              }else {
                  $produkt_number = $result->num_rows;
                  $ilosc = intval($_POST['ilosc']);           

                  if($produkt_number > 0){
                    $row_produkt_exist = $result->fetch_assoc();
                    $ilosc += intval($row_produkt_exist['ilosc']);
                    $id_zamowienia = $row_produkt_exist['id_zamowienia'];
                      if(!$result_update = $connect -> query(
                          "UPDATE zamowienia SET ilosc='$ilosc'
                          WHERE id_zamowienia='$id_zamowienia'")){
                              throw new Exception($connect->error);    
                          } else{
                              mysqli_free_result($result_update);
                              header('Location: produkty_guzikowe.php');
                          }  
                  } else {
                      if(!$result_insert = $connect -> query(
                          "INSERT INTO zamowienia (id_produkt,ilosc,user_id)
                          VALUES ('$produkt','$ilosc', '$user_id')")){
                              throw new Exception($connect->error);    
                          } else{
                              mysqli_free_result($result_insert);
                              header('Location: produkty_guzikowe.php');
                          }  
                    }
              }
            $connect->close();
          }
        } catch (Exception $e ) {
            $message = "Brak polaczenia z serwerem!";
            echo "<SCRIPT type='text/javascript'> //not showing me this
            alert('$message');
            window.location.replace(\"index.php\");
            </SCRIPT>";
        }
    } 
    else {
      $message = "Nie jestes zalogowany!";
        echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"formularz.php\");
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

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

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
          <li class="nav-item active">
            <a class="nav-link" href="produkty_cyfrowe.php">Produkty</a>
              <span class="sr-only">(current)</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="kontakt.php">Kontakt</a>
          </li>

          <?php
           if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true) && ($_SESSION['user']=="admin")){ ?>
           <li class="nav-item">
            <a href = "konta.php" class="nav-link">Konta</a>         
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

    <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">Kategorie</h1>
        <div class="list-group">
          <a href="produkty_cyfrowe.php" class="list-group-item text-dark">Cyfrowe</a>
          <a href="produkty_klawiszowe.php" class="list-group-item text-dark">Klawiszowe</a>
          <a href="produkty_guzikowe.php" class="list-group-item active">Guzikowe</a>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="row content products">
        <?php
        try {
          $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
          if($connect->connect_errno!=0){
              throw new Exception(mysqli_connect_errno());
          } else {
            $sql = "SELECT * FROM produkty WHERE id_kategoria=3 ORDER BY id_produkt ASC";
            if(!$result = $connect -> query($sql)){
              throw new Exception($connect->error);
            } else {
                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_array($result)){

                    ?>

                    <div class="col-lg-4 col-md-6 mb-4">
                      <form method="POST">
                        <div class="card h-100">
                          <a href="#"><img class="card-img-top" style="height:200px;width:100%;"
                            src="<?php echo $row['zdjecie'];?>" alt="">
                          </a>
                          <div class="card-body">
                            <h6 class="card-title text-primary"><?php echo $row['nazwa']; ?></h6>
                            <h6><?php echo $row['cena']; ?> zł</h6>
                            <p><input type="text" name="ilosc" class="form-control" value="1" />  </p> 
                            <input type="hidden" name="id_produkt" value="<?php echo $row['id_produkt'] ?>" />                     
                            <input type="hidden" name="cena" value="<?php echo $row['cena'] ?>" />                     
                            <button name="add_to_cart" type="submit" class="btn btn-primary" >
                            <span class="glyphicon glyphicon-print"></span> Dodaj do koszyka</button>
                          </div>
                        </div>
                      </form>
                    </div>


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

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- <script>
$(document).ready(function () {
    $("div.content").hide();
    $("div.content").fadeIn(1500);
});
</script> -->

</body>

</html>