<form method="post" action="<?php echo $accion; ?>" role="form">
  <div class="form-group">
    <label for="cuil">CUIL:</label>
    <input type="text" class="form-control" name="cuil" value="<?php echo set_value('cuil',$this->datos_formulario->cuil); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" class="form-control" name="nombre" value="<?php echo set_value('nombre',$this->datos_formulario->nombre); ?>">
    <label for="apellido">Apellido:</label>
    <input type="text" class="form-control" name="apellido" value="<?php echo set_value('apellido',$this->datos_formulario->apellido); ?>">
    <label for="mail">Mail:</label>
    <input type="text" class="form-control" name="mail" value="<?php echo set_value('mail',$this->datos_formulario->mail); ?>">
  </div>
  <button type="submit" class="btn btn-success">Grabar</button>
  <?php echo $cancelar; ?>
  <br/><br/>
  <?php echo $mensaje; ?>
</form>