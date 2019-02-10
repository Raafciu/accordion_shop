<?php
    session_start();

    if(!isset($_SESSION['logged'])){
    header('Location: index.php');
    exit();
    }

    require "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="container-fluid">
  <div class="jumbotron my-4 alert alert-success">
        <h1 class="display-4">Dziekujemy za zakupy!</h1>
        <p class="lead">Sprawdz czy na pewno jest w koszyku to, co wybierales. Ponizej podsumowanie zakupionych produktów</p>
        </div>
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
                                      z.id_produkt=p.id_produkt and u.user_id = z.user_id and z.user_id='$userId' 
                                      AND p.dostepnosc='tak' ";
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
                <div class="d-flex flex-row-reverse">
                    <div class="p-2">
                    <a href="drop_products.php" class="btn btn-success btn-lg" >Zatwierdź zakupy i powrót do sklepu</a>
                    </div>
                    <div class="p-3">
                    <a href="koszyk.php" class="btn btn-warning " >Powrót</a>
                    </div>
                </div>
     </div>
</body>
</html>