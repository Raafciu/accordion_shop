<?php
    session_start();
    if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
        header('Location: index.php');
        exit();
    }
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
          <li class="nav-item">
            <a class="nav-link" href="kontakt.php">Kontakt</a>
          </li>
        <?php
          if (isset($_SESSION['user_id'])) 
            {?>
            <li class="nav-item">
              <a href = "#" class="nav-link"><?php echo $_SESSION['user_id']; ?> [KOSZYK]</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo"wyloguj.php"; ?>">Wyloguj</a>
            </li> 

          <?php
            }
          else { ?>
            <li class="nav-item active">
            <a href = "formularz.php" class="nav-link">Zaloguj się</a>         
            </li>          
          <?php
              }
          ?>
        </ul>
      </div>
    </div>
  </nav>

    <div class="container-fluid form">
                <div class="row">
                    <div class="col-md-8 col-sm-6 content">
                        
                        <h2 style="text-align: center;">Logowanie</h2>
                        <form action="zaloguj.php" method="post" enctype="multipart/form-data">
                            <?php
                                if(isset($_SESSION['udana_rejestracja'])) {
                                    echo '<div class="form-group">'.$_SESSION['udana_rejestracja'].'</div>';
                                    unset($_SESSION['udana_rejestracja']);
                                }
                            ?>
                            <div class="form-group">
                                <label for="login">Login:</label>
                                <input type="login" class="form-control" id="login" placeholder="Podaj login" name="login" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="password">Hasło:</label>
                                <input type="password" class="form-control" id="password" placeholder="Podaj hasło" name="password" required>
                            </div>

                            <?php
                                if(isset($_SESSION['blad'])) {
                                    echo '<div class="form-group">'.$_SESSION['blad'].'</div>';
                                    unset($_SESSION['blad']);
                                }
                            ?>
                            <button type="submit" name="logowanie" value="loguje" class="btn btn-primary">Zaloguj</button>
                        </form>
                        
                    </div>
                    <div class="col-md-4 col-sm-6 warning">
                        <div class="alert alert-warning align-middle align_p_alert" role="alert">
                                <p>Jeżeli nie masz jeszcze konta, <a href="rejestracja.php" ><b>zarejestruj się!!!</b></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="rejestracja" role="tabpanel" aria-labelledby="rejestracja-tab">
                
            </div>
        </div>
    </div>

<script>
$(document).ready(function () {
    if($("div.logowanie").is)
    $("div.form").hide();
    $("div.form").fadeIn(1500);
});
</script>

</body>
</html>