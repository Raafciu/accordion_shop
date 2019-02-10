<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Rejestracja</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "hint.php?s=" + str, true);
        xmlhttp.send();
    }
}
</script>

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
            <a href = "formularz.php" class="nav-link">
                      Zaloguj się
            </a>         
            </li>          
          <?php
              }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid form">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="rejestracja" role="tabpanel" aria-labelledby="logowanie-tab">
                       <h2 style="text-align: center;">Rejestracja</h2>

                        <form action="rejestracja_action.php" method="post" enctype="multipart/form-data">
                            <div class="alert alert-error">
                            </div>
                            <div class="form-group">
                                <label for="login">Login: <span id="txtHint"></span></label>
                                <input type="login" class="form-control" id="login" placeholder="Podaj login" name="login"  onkeyup="showHint(this.value)" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="Podaj email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Hasło:</label>
                                <input type="password" class="form-control" id="password" placeholder="Podaj hasło" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Powtórz hasło:</label>
                                <input type="password" class="form-control" id="confirm_password" placeholder="Podaj hasło" name="confirm_password" required> 
                            </div>

                            <?php
                                if(isset($_SESSION['blad_rejestracja'])) {
                                    echo '<div class="form-group">'.$_SESSION['blad_rejestracja'].'</div>';
                                    unset($_SESSION['blad_rejestracja']);
                                }
                            ?>
                            <a href="formularz.php" class="btn btn-secondary">Powrót</a>
                            <button type="submit"  class="btn btn-info">Zarejestruj się</button>
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