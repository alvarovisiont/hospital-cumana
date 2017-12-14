<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$sub_area = null;

	if(isset($_GET['modificar']))
	{
		$system->table = "public.sub_areas";

		$sub_area = $system->find($_GET['modificar']);
	}
?>
	<form action="#" class="form-horizontal" id="form_registrar">
		<h3 class="text-center"><span class="subrayado_rojo">Registro de Sub Areas</span></h3>
		<br>
		<input type="hidden" name="action" value="<?= $sub_area ? 'modificar' : 'registrar'; ?>">
		<input type="hidden" name="id_modificar" value="<?= $sub_area ? $sub_area->id : ''; ?>">
		<input type="hidden" name="created_at" value="<?= $sub_area ? $sub_area->created_at : date('Y-m-d H:i:s', strtotime('-6 hour')); ?>">
		<input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s', strtotime('-6 hour')) ?>">

		<div class="form-group">
			<label for="" class="control-label col-md-2">Departamento</label>
			<div class="col-md-4">
				<select name="departamento_id" id="departamento_id" class="form-control" required="">
					<option value=""></option>
					<?
						$system->sql = "SELECT id, nombre from public.departamentos";
						foreach ($system->sql() as $row) 
						{
							if($sub_area)
							{
								if($sub_area->departamento_id == $row->id)
								{
									echo '<option value="'.$row->id.'" selected="">'.$row->nombre.'</option>';
								}
								else
								{
									echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';
								}
							}
							else
							{
								echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';	
							}
						}
					?>				
				</select>
			</div>
			<label for="" class="control-label col-md-2">Area</label>
			<div class="col-md-4">
				<select name="area_id" id="area_id" class="form-control" required="">
					<option value=""></option>
					<?
						if($sub_area)
						{
							$system->sql = "SELECT id, nombre from public.areas where id = $sub_area->area_id";
							foreach ($system->sql() as $row) 
							{
								if($sub_area)
								{
									if($sub_area->area_id == $row->id)
									{
										echo '<option value="'.$row->id.'" selected="">'.$row->nombre.'</option>';
									}
									else
									{
										echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';			
									}
								}
								else
								{
									echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';	
								}
							}
						}
					?>				
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2">Nombre</label>
			<div class="col-md-4">
				<input type="text" id="nombre" name="nombre" class="form-control" required="" value="<?= $sub_area ? $sub_area->nombre : ''; ?>">
			</div>
			<label for="" class="control-label col-md-2">Descripción</label>
			<div class="col-md-4">
				<input type="text" id="descripcion" name="descripcion" class="form-control" required="" value="<?= $sub_area ? $sub_area->descripcion : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2">Archivo</label>
			<div class="col-md-4">
				<input type="text" id="archivo" name="archivo" class="form-control" required="" value="<?= $sub_area ? $sub_area->archivo : ''; ?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-4 col-md-offset-4">
				<button type="submit" class="btn btn-primary btn-block">Guardar&nbsp;<i class="fa fa-send"></i></button>
			</div>
			<div class="col-md-offset-1 col-md-3">
				<a href="<?= './index.php' ?>">Regresar a la Vista de Sub Areas</a>
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
							var html = 'Registro Modificado con Éxito&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>';

							$('#div_alerta_modificado').children().removeClass('alert-danger').addClass('alert-success').html(html)

							$('#div_alerta_modificado').show('slow/400/fast', function(){
								setTimeout(function(){
									window.location.href = './index.php'
								},1500)	
							})
							
						}
					}
					else
					{
						$('#div_alerta_modificado').children().removeClass('alert-success').addClass('alert-danger').html(data.mensaje)
						$('#div_alerta_modificado').show('slow/400/fast', function(){
								setTimeout(function(){
									$('#div_alerta_modificado').hide('slow/400/fast')
								},1500)	
							})
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

		$('#departamento_id').change(function(){
			var depar = $(this).val()

			$.getJSON('./operaciones.php',{action: 'buscar_area', depar: depar}, function(data){
				var filas = '<option></option>'
				$.grep(data, function(i,e){
					filas += "<option value='"+i.id+"'>"+i.nombre+"</option>"	
				})

				$('#area_id').html(filas)
			})
		})

	})
</script>