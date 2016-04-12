<?php echo form_open('persona/buscar', 'role="form"')?>
  <div class="form-group">
    <label for="cuil">CUIL:</label>
    <input type="text" class="form-control" name="cuil">
  </div>
  <button type="submit" class="btn btn-default">Buscar</button>
  <a href="<?php echo base_url("persona/agregar");?>" class="btn btn-success" role="button">Alta</a>
<?php echo form_close();?>

<?php
if (!empty($tabla)) {
	echo $tabla;
}
?>

