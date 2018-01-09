<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$producto = null;

	if(isset($_GET['modificar']))
	{
		$system->table = "hospital.almacen";
		$producto = $system->find($_GET['modificar']);
	}
?>
	<form action="#" class="form-horizontal" id="form_registrar">

		<input type="hidden" name="action" value="<?= $producto ? 'modificar' : 'registrar'; ?>">
		<input type="hidden" name="id_modificar" value="<?= $producto ? $producto->id : ''; ?>">
		<input type="hidden" name="fecha_ingreso" value="<?= $producto ? $producto->fecha_ingreso : date('Y-m-d H:s:i', strtotime('-5 hour')); ?>">
		
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Producto</label>
			<div class="col-md-4 col-sm-4">
				<input type="text" id="producto" name="producto" class="form-control" required="" value="<?= $producto ? $producto->producto : ''; ?>">
			</div>
			<label for="componente" class="control-label col-md-2 col-sm-2">Componente</label>
			<div class="col-md-4 col-sm-4">
				<input type="text" id="componente" name="componente" required="" class="form-control" value="<?= $producto ? $producto->componente : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Cantidad</label>
			<div class="col-md-4 col-sm-4">
				<input type="number" id="cantidad" name="cantidad" class="form-control" required="" value="<?= $producto ? $producto->cantidad : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="grupo_id" class="control-label col-md-2 col-sm-2">Grupo</label>
			<div class="col-md-4 col-sm-4">
				<select name="grupo_id" id="grupo_id" class="form-control" required="">
					<option value=""></option>
					<?
						$system->sql = "SELECT * from hospital.grupo_medicinas";
						foreach ($system->sql() as $row) 
						{
							if($producto && $producto->grupo_id == $row->id)
							{
								echo '<option value="'.$row->id.'" selected>'.$row->nombre.'</option>';
							}
							else
							{
								echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';	
							}
						}
					?>
				</select>
			</div>
			<label for="marca_id" class="control-label col-md-2 col-sm-2">Marca</label>
			<div class="col-md-4 col-sm-4">
				<select name="marca_id" id="marca_id" class="form-control" required="">
					<option value=""></option>
					<?
						$system->sql = "SELECT * from hospital.marca_medicinas";
						foreach ($system->sql() as $row) 
						{
							if($producto && $producto->marca_id == $row->id)
							{
								echo '<option value="'.$row->id.'" selected>'.$row->nombre.'</option>';
							}
							else
							{
								echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';	
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="fecha_ingreso" class="control-label col-md-2 col-sm-2">Fecha Entrada</label>
			<div class="col-md-4 col-sm-4">
				<input type="text" id="fecha_ingreso" name="fecha_ingreso" required="" class="form-control date-picker" value="<?= $producto ? date('d-m-Y',strtotime( $producto->fecha_ingreso )) : '' ?>">
			</div>
			<label for="fecha_expension" class="control-label col-md-2 col-sm-2">Fecha Expensión</label>
			<div class="col-md-4 col-sm-4">
				<input type="text" id="fecha_expension" name="fecha_expension" required="" class="form-control date-picker" value="<?= $producto ? date('d-m-Y',strtotime( $producto->fecha_expension )) : '' ?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
				<button type="submit" class="btn btn-primary btn-block" <?= $_SESSION['nivel'] == 4 ? 'disabled': ''; ?>>Guardar&nbsp;<i class="fa fa-send"></i></button>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1  col-md-3 col-sm-3">
				<a href="<?= './index.php' ?>">Regresar a la Vista de Productos</a>
			</div>
		</div>
		<div class="form-group" id="div_alerta" style="display: none">
			<p class="alert alert-success text-center">
				Registro Agregado con Éxito&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i> &nbsp;&nbsp;, Desea Agregar Otro?&nbsp;&nbsp; 
				<button type="button" class="btn btn-sm btn-default" id="agregar_si">Si</button>
				<button type="button" class="btn btn-sm btn-default" id="agregar_no">No</button>
			</p>
		</div>
		<div class="form-group" id="div_alerta_modificado" style="display: none">
			<p class="alert alert-success text-center">
				Registro Modificado con Éxito&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i> 
			</p>
		</div>
	</form>
<?
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>
<script>
	$(function(){

		valida_envio_formulario = true

		$('#form_registrar').submit(function(e){
			e.preventDefault()

			if(!valida_envio_formulario)
			{
				return false
			}

			
			var tipo = $('input[name="action"]').val()

			$.ajax({

				url: './operaciones.php',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				success: function(data)
				{
					if(data.r)
					{
						if(tipo == 'registrar')
						{
							valida_envio_formulario = false
							$('#div_alerta').show('slow/400/fast')
						}
						else
						{
							$('#div_alerta_modificado').show('slow/400/fast', function(){
								setTimeout(function(){
									window.location.href = './index.php'
								},1500)	
							})
							
						}
					}
				}
			})
		})

		$('#agregar_si').click(function(){
			
			$('#div_alerta').hide('slow/400/fast')
			$('#form_registrar')[0].reset()
			valida_envio_formulario = true
		})

		$('#agregar_no').click(function(){
				window.location.href = './index.php'
		})
	})
</script>