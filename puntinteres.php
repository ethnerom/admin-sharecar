<?php
    include "includes/bootstrap.php";
?>
<!DOCTYPE html>
<html lang="en">
    <?php bsHead("Benvigut"); ?>
    <body>

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Web ShareCar</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="itineraris.php">Itineraris</a></li>
            <li><a href="pais.php">Pais</a></li>
            <li><a href="parroquia.php">Parròquies</a></li>
            <li><a href="poblacio.php">Poblacions</a></li>
            <li class="active"><a href="puntinteres.php">Punts d'Interès</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
