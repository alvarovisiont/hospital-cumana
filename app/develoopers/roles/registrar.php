<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$roles = null;

	if(isset($_GET['modificar']))
	{
		$system->table = "public.roles";

		$roles = $system->find($_GET['modificar']);
	}
?>
	<form action="#" class="form-horizontal" id="form_registrar">
		<h3 class="text-center"><span class="subrayado_rojo">Registro de Roles</span></h3>
		<br>
		<input type="hidden" name="action" value="<?= $roles ? 'modificar' : 'registrar'; ?>">
		<input type="hidden" name="id_modificar" value="<?= $roles ? $roles->id : ''; ?>">
		<input type="hidden" name="created_at" value="<?= $roles ? $roles->created_at : date('Y-m-d H:i:s'); ?>">
		<input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">

		<div class="form-group">
			<label for="" class="control-label col-md-2">Nombre</label>
			<div class="col-md-4">
				<input type="text" id="nombre" name="nombre" class="form-control" required="" value="<?= $roles ? $roles->nombre : ''; ?>">
			</div>
			<label for="" class="control-label col-md-2">Descripción</label>
			<div class="col-md-4">
				<input type="text" id="descripcion" name="descripcion" class="form-control" required="" value="<?= $roles ? $roles->descripcion : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-4 col-md-offset-4">
				<button type="submit" class="btn btn-primary btn-block">Guardar&nbsp;<i class="fa fa-send"></i></button>
			</div>
			<div class="col-md-offset-1 col-md-3">
				<a href="<?= './index.php' ?>">Regresar a la Vista de Roles</a>
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
		$('#form_registrar').submit(function(e){
			e.preventDefault()
			
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
		})

		$('#agregar_no').click(function(){
				window.location.href = './index.php'
		})
	})
</script>