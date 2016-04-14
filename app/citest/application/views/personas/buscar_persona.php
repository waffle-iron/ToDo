<form method="post" action="<?php echo $accion; ?>" role="form">
  <div class="form-group">
    <label for="cuil">CUIL:</label>
    <input type="text" class="form-control" name="cuil">
  </div>
  <button type="submit" class="btn btn-default">Buscar</button>
  <a href="<?php echo base_url("persona/alta");?>" class="btn btn-success" role="button">Alta</a>
</form>

<?php
if (!empty($tabla)) {
	echo $tabla;
}
?>