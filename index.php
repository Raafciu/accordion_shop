<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Strona glowna</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/full-slider.css" rel="stylesheet">
<style>
 .bg-dark {
    background-color:transparent !important;

}
</style>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar transparent navbar-inverse">
    <div class="container">

      <a class="navbar-brand" href="#">Accordions</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Strona główna
              <span class="sr-only">(current)</span>            
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
            <a href = "formularz.php" class="nav-link">Zaloguj się</a>         
            </li>
          <?php
          } ?> 
        </ul>
      </div>
    </div>
  </nav>

    <header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" style="background-image: 
          linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(jpg/accordion_b.jpg)">
            <div class="carousel-caption d-none d-md-block">
              <h3>Witamy !!!</h3>
              <p>Zapraszamy do zapoznania się z największa ofertą akordeonów w Polsce.</p>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: 
          linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(jpg/accordion_2.jpg)">
            <div class="carousel-caption d-none d-md-block">
              <h3>Co znajdziesz w naszym sklepie?</h3>
              <p> Oferowane przez nas instrumenty 
              pochodzą od wiodących światowych producentów takich jak: PIGINI, Excelsior, Delicia, Weltmeister czy Hohner.</p>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: 
          linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(jpg/accordion_3.jpg)">
            <div class="carousel-caption d-none d-md-block">
              <h3>Zacznij zakupy już teraz!</h3>
              <p>Jeśli nie wiesz, jaki wybrać akordeon, niezależnie od tego czy jesteś początkującym akordeonistą,
               czy profesjonalnym muzykiem skontaktuj się z nami, a doradzimy Ci, który akordeon będzie najlepiej spełniał Twoje potrzeby.</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" id="cookieinfo"
	src="//cookieinfoscript.com/js/cookieinfo.min.js"
	data-bg="#645862"
	data-fg="#FFFFFF"
	data-link="#F1D600"
	data-cookie="CookieInfoScript"
	data-text-align="left"
       data-close-text="Got it!">
</script>

  </body>
</html>