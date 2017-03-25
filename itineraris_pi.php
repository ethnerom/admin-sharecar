<?php
  include "includes/bootstrap.php";
  include "includes/connexio.php";
  bsHead("Modificació d'itineraris");
  if (isset($_REQUEST["nom_itinerari"])) $nom_itinerari=$_REQUEST["nom_itinerari"];
  if (isset($_REQUEST["ordre"])) $ordre=$_REQUEST["ordre"];
  if (isset($_REQUEST["id_itinerari"])) $id_itinerari=$_REQUEST["id_itinerari"];
?>
<html>
<body>
<div class="container">
  <h3><center>Afegir punt d'interes</center></h3>
  <br>
    <div class="row myform">
      <div class="col-md-7 col-md-offset-3">
        <div class="alert alert-info" role="alert">
          <form name="form_usuaris" action="mod_itineraris.php?operacio=new_pi&ordre=<?=$ordre?>&id_itinerari=<?=$id_itinerari?>" role="form" method="post">
            <div class="form-group">
              <label class="control-label" for="itineraris">Itinerari</label>
              <input required type="text" name="nom_itinerari" id="nom_itinerari" maxlength="25" class="form-control" value="<?=$nom_itinerari?>" readonly/>
            </div>
            <?php
              obrirConnexioBD();
              $sql = "SELECT t_puntinteres.id_puntinteres, t_puntinteres.pi_nom FROM t_puntinteres ORDER BY t_puntinteres.PI_NOM ASC";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) { ?>
                <div class="form-group">
                  <label class="control-label" for="tecnic">Punt d'interes</label>
                  <select class="form-control" name="id_pi" id="id_pi">
                    <option value="">---> selecciona un punt d'interés</option>
                    <?php
                      while ($row = $result->fetch_row()){
                        $id_pi=$row[0];
                        $nom_pi=$row[1];?>
                        <option value="<?php if (isset($row)) echo $id_pi ?>"><?php echo $nom_pi ?></option>
                    <?php } ?>
                  </select>
                </div>
    <?php } else {
              echo 'No hi han itineraris';
          }
        tancarConnexioBD(); ?>
            <div class="form-group">
              <center>
                <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-send"></span> Crear</button>
              </center>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
</body>
</html>
