<?php
    include "includes/bootstrap.php";
    bsHead("Error");
    $msg=$_REQUEST["msg"];
?>
<script>setTimeout(function(){history.back();}, 3000);</script>
<div class="alert alert-danger">
  <strong>Atenció!</strong> Error <?=$msg?>.
</div>
