<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';
?>
	<h3 class="text-center">Alta de Emergencías</h3>
	<br />
	<form action="#" class="form-horizontal" id="form_registrar">

		<input type="hidden" name="action" value="<?= 'salida_emergencia'; ?>">
		<input type="hidden" name="created_at" value=" <?= date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">
		<input type="hidden" name="update_at" value="<?= date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">
		<input type="hidden" name="emergencia_id" value="<?= $_GET['id']; ?>">
		<input type="hidden" name="fecha_salida" value="<?= date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">
		
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Salida por Motivo: </label>
			<div class="col-md-2 col-sm-2">
				<label for="curacion" class="radio-inline">
					<input type="radio" value="curacion" id="curacion" name="motivo" required="">
					Curación
				</label>
			</div>
			<div class="col-md-2 col-sm-2">
				<label for="mejoria" class="radio-inline">
					<input type="radio" value="mejoria" id="mejoria" name="motivo">
					Mejoría
				</label>
			</div>
			<div class="col-md-2 col-sm-2">
				<label for="muerte" class="radio-inline">
					<input type="radio" value="muerte" id="muerte" name="motivo">
					Muerte
				</label>
			</div>
			<div class="col-md-2 col-sm-2">
				<label for="auptopsia_pedida" class="radio-inline">
					<input type="radio" value="auptopsia_pedida" id="auptopsia_pedida" name="motivo">
					Autopsia Pedida
				</label>
			</div>
			<div class="col-md-2 col-sm-2">
				<label for="otras_causas" class="radio-inline">
					<input type="radio" value="otras_causas" id="otras_causas" name="motivo">
					Otras Causas
				</label>
			</div>
		</div>
		<div class="form-group" id="div_escondido" style="display: none">
			<label for="" class="control-label col-md-2 col-sm-2">Específique: </label>
			<div class="col-md-4 col-sm-4">
				<textarea name="salida_otras_causas_explicacion" id="salida_otras_causas_explicacion" rows="2" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Diagnostico Clínico Final: </label>
			<div class="col-md-4 col-sm-4">
				<textarea name="diagnostico_clinico_final" id="diagnostico_clinico_final" rows="2" class="form-control" required=""></textarea>
			</div>
			<label for="" class="control-label col-md-2 col-sm-2">Intervención o Tratamiento: </label>
			<div class="col-md-4 col-sm-4">
				<textarea name="intervencion_tratamiento" id="intervencion_tratamiento" rows="2" class="form-control" required=""></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Diagnostico Anatomatológico: </label>
			<div class="col-md-4 col-sm-4">
				<textarea name="diagnostico_anatomapatologico" id="diagnostico_anatomapatologico" rows="2" class="form-control" required=""></textarea>
			</div>
			<label for="biopsia" class="col-md-1 col-sm-1">
				<input type="radio" value="biopsia" id="biopsia" name="opciones_anatomapatologico" required="">
					Biopsía
			</label>
			<label for="alitopsia" class="col-md-1 col-sm-1">
				<input type="radio" value="alitopsia" id="alitopsia" name="opciones_anatomapatologico">
					Alitopsía
			</label>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-md-2 col-sm-2">Jefe Departamento: </label>
			<div class="col-md-4 col-sm-4">
				<select name="jefe_departamento" id="jefe_departamento" required="" class="form-control">
					<option value=""></option>
					<?
						$system->sql = "SELECT nombre_completo, id from hospital.medicos";
						foreach ($system->sql() as $row) 
						{
							echo '<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
				<button type="submit" class="btn btn-primary btn-block" <?= $_SESSION['nivel'] == 4 ? 'disabled': ''; ?>>Guardar&nbsp;<i class="fa fa-send"></i></button>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1  col-md-3 col-sm-3">
				<a href="<?= './index.php' ?>">Regresar a la Vista de Emergencías</a>
			</div>
		</div>
		<div class="form-group" id="div_alerta" style="display: none">
			<p class="alert alert-success text-center">
				Registro Agregado con Éxito&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i> 
			</p>
		</div>
	</form>
<?
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>

<script>
	$(function(){

		valida_envio_formulario = true

		$('input[name="motivo"]').click(function(e){
			
			var value = e.target.value

			var explicacion = document.getElementById('salida_otras_causas_explicacion')
			var div_escondido = document.getElementById('div_escondido')
			if(value == "otras_causas")
			{
				explicacion.setAttribute('required',true)

				div_escondido.style.display = 'block'
			}
			else
			{
				explicacion.removeAttribute('required')	
				div_escondido.style.display = 'none'
			}
		})

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
						if(tipo == 'salida_emergencia')
						{
							valida_envio_formulario = false
							$('#div_alerta').show('slow/400/fast')
							setTimeout(function(){
									window.location.href = './index.php'
								},1500)	
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
	})
</script>