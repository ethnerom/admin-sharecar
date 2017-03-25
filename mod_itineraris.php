<?php
    include "includes/bootstrap.php";
    include "includes/connexio.php";
    if (isset($_REQUEST["operacio"])) $operacio=$_REQUEST["operacio"];
    if ($operacio!="new" && $operacio!="edit") header("Location: error.php");
    //if ($operacio == "edit") $id_itinerari=$_REQUEST["id_itinerari"];
    if (isset($_REQUEST["ordre"])) $ordre=$_REQUEST["ordre"];
    if (isset($_REQUEST["nom_itinerari"])) $nom_itinerari=$_REQUEST["nom_itinerari"];
    if (isset($_REQUEST["id_itinerari"])) $id_itinerari=$_REQUEST["id_itinerari"];
    if (isset($_REQUEST["id_pi"])) $id_pi=$_REQUEST["id_pi"];
    if (isset($_REQUEST["id_pi_sortida"])) $id_pi_sortida=$_REQUEST["id_pi_sortida"];
    if (isset($_REQUEST["id_pi_arribada"])) $id_pi_arribada=$_REQUEST["id_pi_arribada"];
    obrirConnexioBD();
    if ($operacio=="new") {
      if ($id_pi_sortida!=$id_pi_arribada) {
        $sql="INSERT INTO t_itineraris (it_nomitinerari) VALUES (\"$nom_itinerari\" );";
        if ($conn->query($sql) === TRUE) {
          $last_id=$conn->insert_id;
          $sql="INSERT INTO itinerari_pi (id_itinerari, id_pi, ordre) VALUES ($last_id, $id_pi_sortida, 1);";
          $sql.="INSERT INTO itinerari_pi (id_itinerari, id_pi, ordre) VALUES ($last_id, $id_pi_arribada, 100);";
          if ($conn->multi_query($sql) === TRUE) {
            tancarConnexioBD();
            header("Location: itineraris.php");
          } else { ?>
            <!DOCTYPE html>
            <html lang="en">
              <?php bsHead("Creat/modificat"); ?>
              <script>setTimeout(function(){history.back();}, 3000);</script>
              <body>
                <div class="alert alert-danger" role="alert">
                  <h3>Error creant/modificant itinerari</h3>
                  <p><?=$conn->error?></p>
                </div>
              </body>
            </html>
        <?php
          }
        } else { ?>
          <!DOCTYPE html>
          <html lang="en">
            <?php bsHead("Creat/modificat"); ?>
            <script>setTimeout(function(){history.back();}, 3000);</script>
            <body>
              <div class="alert alert-danger" role="alert">
                <h3>Error creant/modificant itinerari</h3>
                <p><?=$conn->error?></p>
              </div>
            </body>
          </html>
<?php   }
      } else { ?>
        <!DOCTYPE html>
        <html lang="en">
          <?php bsHead("Creat/modificat"); ?>
          <script>setTimeout(function(){history.back();}, 3000);</script>
          <body>
            <div class="alert alert-danger" role="alert">
              <h3>Error: el punt d'arribada no pot ser el mateix que el punt de sortida.</h3>
              <p><?=$conn->error?></p>
            </div>
          </body>
        </html>
  <?php
        }
    } elseif ($operacio=="edit") {
      $sql="UPDATE t_itineraris SET it_nomitinerari=\"$nom_itinerari\" WHERE id_itineraris=$id_itinerari;";
      if ($conn->query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: itineraris.php");
      } else {
        tancarConnexioBD();
        header("Location: error.php?msg=" . $mysql_error($conn));
      }
    } elseif ($operacio=="suma") {
      $sql="UPDATE itinerari_pi SET ordre=ordre - 1 WHERE id_itinerari=$id_itinerari AND ordre=$ordre+1;";
      $sql.="UPDATE itinerari_pi SET ordre=ordre + 1 WHERE id_itinerari=$id_itinerari AND id_pi=$id_pi;";
      if ($conn->multi_query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: itineraris.php");
      } else {
        tancarConnexioBD();
        header("Location: error.php?msg=" . $mysql_error($conn));
      }
    } elseif ($operacio=="resta") {
      $sql="UPDATE itinerari_pi SET ordre=ordre + 1 WHERE id_itinerari=$id_itinerari AND ordre=$ordre-1;";
      $sql.="UPDATE itinerari_pi SET ordre=ordre - 1 WHERE id_itinerari=$id_itinerari AND id_pi=$id_pi;";
      if ($conn->multi_query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: itineraris.php");
      } else {
        tancarConnexioBD();
        header("Location: error.php?msg=" . $mysql_error($conn));
      }
    } elseif ($operacio=="new_pi") {
      $sql="SELECT COUNT(ORDRE) FROM itinerari_pi WHERE id_itinerari = $id_itinerari;";
      if ($result = $conn->query($sql)){
        if ($row = $result->fetch_row()) $ordre = $row[0];
        $sql="INSERT INTO itinerari_pi (id_itinerari, id_pi, ordre) VALUES ($id_itinerari, $id_pi, $ordre);";
        if ($conn->query($sql) === TRUE) {
          tancarConnexioBD();
          header("Location: itineraris.php");
        } else {
          tancarConnexioBD();
          header("Location: error.php?msg=insertant nou punt d'interés o punt d'interés ja existent");
        }
      }
    } elseif ($operacio=="esborrar_pi") {
      $sql="DELETE FROM itinerari_pi WHERE id_itinerari = $id_itinerari AND id_pi = $id_pi;";
      if ($conn->query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: itineraris.php");
      } else {
        tancarConnexioBD();
        header("Location: error.php?msg=" . $mysql_error($conn));
      }
    } elseif ($operacio=="esborrar_itinerari") {
      $sql="DELETE FROM itinerari_pi WHERE id_itinerari = $id_itinerari;";
      $sql.="DELETE FROM t_itineraris WHERE id_itinerari = $id_itinerari;";
      if ($conn->multi_query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: itineraris.php");
      } else {
        tancarConnexioBD();
        header("Location: error.php?msg=" . $mysql_error($conn));
      }
    } ?>
