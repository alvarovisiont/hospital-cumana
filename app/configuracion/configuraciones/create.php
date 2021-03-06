<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$configuracion = null;

	if(isset($_GET['modificar']))
	{
		$system->table = "hospital.configuracion";
		$configuracion = $system->find($_GET['modificar']);
	}
?>
	<form action="#" class="form-horizontal" id="form_registrar" enctype="multipart/form-data">

		<input type="hidden" name="action" value="<?= $configuracion ? 'modificar' : 'registrar'; ?>">
		<input type="hidden" name="id_modificar" value="<?= $configuracion ? $configuracion->id : ''; ?>">
		
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Nombre Hospital</label>
			<div class="col-md-4 col-sm-4">
				<input type="text" id="nombre_hospital" name="nombre_hospital" class="form-control text-center" required="" value="<?= $configuracion ? $configuracion->nombre_hospital : ''; ?>">
			</div>
			<label for="" class="control-label col-md-2 col-sm-2">Teléfono</label>
			<div class="col-md-4 col-sm-4">
				<input type="number" id="telefono" name="telefono" class="form-control text-center" required="" value="<?= $configuracion ? $configuracion->telefono : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Dirección</label>
			<div class="col-md-4 col-sm-4">
				<textarea name="direccion" id="direccion" rows="3" class="form-control requerido" required=""><?= $configuracion ? $configuracion->direccion : ''; ?> </textarea>
			</div>
			<label for="" class="control-label col-md-2 col-sm-2">Director</label>
			<div class="col-md-4 col-sm-4">
				<input type="text" id="director" name="director" class="form-control text-center" required="" value="<?= $configuracion ? $configuracion->director : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Logo</label>
			<div class="col-md-4 col-sm-4">
				<input type="file" name="logo">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
				<button type="submit" class="btn btn-primary btn-block" <?= $_SESSION['nivel'] == 4 ? 'disabled': ''; ?>>Guardar&nbsp;<i class="fa fa-send"></i></button>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1  col-md-3 col-sm-3">
				<a href="<?= './index.php' ?>">Regresar a la Vista de Configuración</a>
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

			var formData = new FormData($("#form_registrar")[0]);

			$.ajax({

				url: './operaciones.php',
				type: 'POST',
				data: formData,
				dataType: 'JSON',
				cache: false,
                contentType: false,
                processData: false,
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