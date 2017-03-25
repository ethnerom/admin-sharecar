<?php
  include "includes/bootstrap.php";
  include "includes/connexio.php";
  bsHead("Modificació d'itineraris");

  if (isset($_REQUEST["operacio"])) $operacio=$_REQUEST["operacio"];
  if ($operacio!="new" && $operacio!="edit") header("Location: itineraris.php");
  obrirConnexioBD();
  if ($operacio=="edit") {
      if (isset($_REQUEST["id_itinerari"])) {
          $id_itinerari=$_REQUEST["id_itinerari"];
          $id_pi=$_REQUEST["id_pi"];
          $sql = "SELECT itinerari_pi.id_itinerari, t_itineraris.it_nomitinerari
                  FROM itinerari_pi
                  INNER JOIN t_itineraris on t_itineraris.id_itineraris = itinerari_pi.id_itinerari
                  WHERE itinerari_pi.id_itinerari = $id_itinerari
                  ORDER BY itinerari_pi.id_itinerari, itinerari_pi.ordre";
          $result = $conn->query($sql);
          if ($result->num_rows == 0) {
              tancarConnexioBD();
              header("Location: llistat_incidencies.php?");
          } else {
              $row = $result->fetch_row();
              $id_itinerari=$row[0];
              $nom_itinerari=$row[1];
          }
      } else {
          header("Location: itineraris.php");
      }
  }
?>
<html>
<body>
<div class="container">
  <h3><center><?php if ($operacio=="new") header("Location: nou_itinerari.php?operacio=new"); else echo "Modificar nom itinerari"; ?></center></h3>
  <br>
  <div class="row myform">
    <div class="col-md-7 col-md-offset-3">
      <div class="alert alert-info" role="alert">
        <form name="form_usuaris" action="mod_itineraris.php?operacio=<?=$operacio?>&id_itinerari=<?=$id_itinerari?>" role="form" method="post">
          <div class="form-group">
            <label class="control-label" for="itineraris">Itinerari</label>
            <input required type="text" name="nom_itinerari" id="nomitinerari" maxlength="25" class="form-control" value="<?php if (isset($row)) echo $nom_itinerari ?>"/>
          </div>
          <div class="form-group">
            <center>
              <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-send"></span> Modificar</button>
            </center>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
