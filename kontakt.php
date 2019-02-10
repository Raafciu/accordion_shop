<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Logowanie</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


</head>
<style>
    div.form{
            box-shadow: 1px -1px 30px 9px;
            padding:15px;
            width: 40%;
            position: fixed;
            left: 50%;
            top: 50%;
            transform:translate(-50%,-50%);
        }
        div.align_p_alert{
            left: 50%;
            top: 50%;
            transform:translate(-50%,-50%);
        }
    </style>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
          <li class="nav-item active">
              <span class="sr-only">(current)</span>
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

    <div class="container-fluid form">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kontakt" role="tabpanel" aria-labelledby="logowanie-tab">
                        <h2 style="text-align: center;">Kontakt</h2>
                        <form action="email.php" method="POST">
                            <div class="form-group">
                                <label for="imie">Imie:</label>
                                <input type="text" class="form-control" id="imie" placeholder="Podaj imię" name="imie" maxlength="20" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="Podaj email" name="email" maxlength="50" required>
                            </div>
                            <div class="form-group">
                                <label for="subject">Temat:</label>
                                <input type="text" class="form-control" id="temat" placeholder="Podaj temat" name="temat" maxlength="20" required>
                            </div>
                            <div class="form-group">
                                <label for="wiadomosc">Wiadomość:</label>
                                <textarea class="form-control" id="subject" name="tresc" maxlength="4000" placeholder="Napisz coś...." style="height:150px;width:100%;resize:none;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Wyślij</button>
                        </form>
            </div>
        </div>
    </div>

<script>
$(document).ready(function () {
    $("div.form").hide();
    $("div.form").fadeIn(1500);
});
</script>

</body>
</html>