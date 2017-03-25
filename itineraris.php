<?php
  include "includes/bootstrap.php";
  include "includes/connexio.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php bsHead("Itineraris"); ?>
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
          <li class="active"><a href="itineraris.php">Itineraris <span class="sr-only">(current)</span></a></li>
          <li><a href="pais.php">Pais</a></li>
          <li><a href="parroquia.php">Parròquies</a></li>
          <li><a href="poblacio.php">Poblacions</a></li>
          <li><a href="puntinteres.php">Punts d'Interès</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

      <!-- Creació de la taula amb els itineraris-->
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Esborrar itinerari</h4>
        </div>

        <div class="modal-body">
          <p>Esteu segur que voleu esborrar l'itinerari?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <a class="btn btn-danger btn-ok">Sí</a>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <h3><center>Llistat d'itineraris</center></h3>
      <br>
      <a type="button" href="form_itineraris.php?operacio=new" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Crear sortida-arribada d'itinerari</a></br>
<?php

    obrirConnexioBD();
    $sql = "SELECT itinerari_pi.id_itinerari, t_puntinteres.pi_nom, t_itineraris.it_nomitinerari, itinerari_pi.ordre, t_puntinteres.id_puntinteres, t_puntinteres.pi_poblacio FROM itinerari_pi
            INNER JOIN t_puntinteres ON t_puntinteres.id_puntinteres = itinerari_pi.id_pi
            INNER JOIN t_itineraris on t_itineraris.id_itineraris = itinerari_pi.id_itinerari
            ORDER BY itinerari_pi.id_itinerari, itinerari_pi.ordre;";
    $result = $conn->query($sql);
          /*echo $result->num_rows;
          echo $result->fetch_assoc();*/
    if ($result->num_rows > 0) {
?>
      <br>
      <table class="table table-hover table-bordered">
        <thead>
          <tr class="success">
            <th>Itinerari</th>
            <th>Punt Interes</th>
            <th>Ordre</th>
          </tr>
        </thead>
        <tbody>
<?php  // output data of each row
    $id_itinerari_anterior=0;
    while($row = $result->fetch_row()) {
      $id_itinerari=$row[0];
      $id_pi=$row[4];
      $id_poblacio=$row[5];
      $nom_pi=$row[1];
      $nom_itinerari=$row[2];
      $ordre=$row[3];
      echo "<tr>";
      if ($id_itinerari_anterior==$id_itinerari) {
?>
        <tr>
          <td>&nbsp;</td>
<?php
      } else {
        $id_itinerari_anterior=$id_itinerari;
?>
        <td>
          <a href="form_itineraris.php?operacio=edit&id_itinerari=<?=$id_itinerari?>&id_pi=<?=$id_pi?>" data-toggle="modal"><span class="glyphicon glyphicon-edit" style="color: Green"></span></a>
          &nbsp;&nbsp;
          <a data-href="mod_itineraris.php?operacio=esborrar_itinerari&id_itinerari=<?=$id_itinerari?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-remove" style="color: Red"></span></a>
          &nbsp;&nbsp;
          <a type="button" href="itineraris_pi.php?nom_itinerari=<?=$nom_itinerari?>&ordre=<?=$ordre?>&id_itinerari=<?=$id_itinerari?>"><span class="glyphicon glyphicon-map-marker" style="color: Blue"></span></a>
          &nbsp;&nbsp;
          <?=$nom_itinerari?>
<?php } ?>
      <td>
<?php
      if ($ordre==1) { ?>
        <span class="glyphicon glyphicon-flag" style="color: Green"></span>
<?php
        } elseif ($ordre==100) { ?>
          <span class="glyphicon glyphicon-flag" style="color: Red"></span>
<?php
        } else { ?>
          <a data-href="mod_itineraris.php?operacio=esborrar_pi&id_itinerari=<?=$id_itinerari?>&id_pi=<?=$id_pi?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-pause" style="color: Red"></span></a>
<?php   } ?>
        &nbsp;&nbsp;
        <?=$nom_pi?>
      </td>
      <td>
<?php   if ($ordre>1) { ?>
<?php     if ($ordre>2 && $ordre<100) { ?>
            <a type="button" href="mod_itineraris.php?operacio=resta&id_itinerari=<?=$id_itinerari?>&id_pi=<?=$id_pi?>&ordre=<?=$ordre?>"><span class="glyphicon glyphicon glyphicon-chevron-up" style="color: Navy"></span></a>
<?php     }
          if ($ordre>=2 && $ordre<99 ) { ?>
            <a type="button" href="mod_itineraris.php?operacio=suma&id_itinerari=<?=$id_itinerari?>&id_pi=<?=$id_pi?>&ordre=<?=$ordre?>"><span class="glyphicon glyphicon glyphicon-chevron-down" style="color: Navy"></span></a>
<?php     }
        } ?>
      </td>
    </tr>
<?php
    } ?>
        </tbody>
    </table>
<?php
    } else {
        echo "No hi ha itineràris";
    }
    tancarConnexioBD(); ?>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
      $('#confirm-delete').on('show.bs.modal', function(e) {
          $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });
  </script>
</body>
</html>
