<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$emergencia = null;

	if(isset($_GET['modificar']))
	{
		$system->table = "emergencia.ingreso_emergencia";
		$emergencia = $system->find($_GET['modificar']);
	}

?>
	<h3 class="text-center">Admisión a Emergencías</h3>
	<form action="#" class="form-horizontal" id="form_registrar">

		<input type="hidden" name="action" value="<?= $emergencia ? 'modificar' : 'registrar'; ?>">
		<input type="hidden" name="id_modificar" value="<?= $emergencia ? $emergencia->id : ''; ?>">
		<input type="hidden" name="created_at" value="<?= $emergencia ? $emergencia->created_at : date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">
		<input type="hidden" name="update_at" value="<?= date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">

		<fieldset>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Servicio</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="servicio" name="servicio" class="form-control requerido text-center" required="" value="<?= $emergencia ? $emergencia->servicio : ''; ?>">
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">¿Posee Identificación?</label>
				<div class="col-md-4 col-sm-4">
					<select name="posee_identificacion" id="posee_identificacion" required="" class="form-control">
						<option value=""></option>
						<option value="1" 
							<? if($emergencia){ if($emergencia->posee_identificacion == 1) { echo 'selected'; } } ?>
							>
							Si
						</option>
						<option value="2"
							<? if($emergencia){ if($emergencia->posee_identificacion == 2) { echo 'selected'; } } ?>
						>
							No
						</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Nombre Completo</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="nombre_completo" name="nombre_completo" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->nombre_completo) : ''; ?>">
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Cédula</label>
				<div class="col-md-4 col-sm-4">
					<input type="number" id="cedula" name="cedula" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->cedula) : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Telefono</label>
				<div class="col-md-4 col-sm-4">
					<input type="number" id="telefono" name="telefono" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->telefono) : ''; ?>">
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Fecha Nacimiento</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control requerido text-center date-picker" required="" value="<? if($emergencia){ if($emergencia->fecha_nacimiento !== '1830-02-10'){echo date('d-m-Y',strtotime($emergencia->fecha_nacimiento)); } } ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Lugar de Nacimiento</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="lugar_nacimiento" name="lugar_nacimiento" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->lugar_nacimiento) : ''; ?>">
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Dirección Actual</label>
				<div class="col-md-4 col-sm-4">
					<textarea name="direccion_actual" id="direccion_actual" rows="2" class="form-control requerido" required=""><?= $emergencia ? $emergencia->direccion_actual : ''; ?> </textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Procedencia por Estado</label>
				<div class="col-md-2 col-sm-2">
					<input type="text" id="procedencia_estado" name="procedencia_estado" class="form-control text-center requerido" required="" value="<?= $emergencia ? $emergencia->procedencia_estado : ''; ?>">
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Nacionalidad</label>
				<div class="col-md-2 col-sm-2">
					<select name="nacionalidad" id="nacionalidad" class="form-control requerido" required="">
						<option value=""></option>
						<option value="V" 
							<? if($emergencia){ if($emergencia->nacionalidad == 'V') { echo 'selected'; } } ?>
							>
							V
						</option>
						<option value="E"
							<? if($emergencia){ if($emergencia->nacionalidad == 'E') { echo 'selected'; } } ?>
						>
							E
						</option>
					</select>
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">S.S.O U Otros</label>
				<div class="col-md-2 col-sm-2">
					<input type="text" id="sso_otros" name="sso_otros" class="form-control text-center" value="<?= $emergencia ? $system->parse_empty($emergencia->sso_otros) : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<h4 class="text-center">En caso de Emergencía avisar a:</h4>
				<label for="" class="control-label col-md-2 col-sm-2">Nombre Completo</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="nombre_completo_parentesco" name="nombre_completo_parentesco" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->nombre_completo_parentesco) : ''; ?>">
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Parentesco</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="parentesco" name="parentesco" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->parentesco) : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Dirección</label>
				<div class="col-md-4 col-sm-4">
					<textarea name="direccion_parentesco" id="direccion_parentesco" rows="2" class="form-control requerido" required=""><?= $emergencia ? $emergencia->direccion_parentesco : ''; ?> </textarea>
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Teléfono</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="telefono_parentesco" name="telefono_parentesco" class="form-control requerido text-center" required="" value="<?= $emergencia ? $system->parse_empty($emergencia->telefono_parentesco) : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Fecha Admis. Ant</label>
				<div class="col-md-4 col-sm-4">
					<input type="text" id="fecha_admin_ant" name="fecha_admin_ant" class="form-control requerido text-center date-picker" required="" value="<? if($emergencia){ if($emergencia->fecha_admin_ant !== '1830-02-10'){echo date('d-m-Y',strtotime($emergencia->fecha_admin_ant)); } } ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
					<button type="button" class="btn btn-primary btn-block next">Siguiente&nbsp; <i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Mótivo Admisión</label>
				<div class="col-md-4 col-sm-4">
					<textarea name="motivo_admision" id="motivo_admision" rows="3" class="form-control requerido" required=""><?= $emergencia ? $emergencia->motivo_admision : ''; ?> </textarea>
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Enfermedad Actual</label>
				<div class="col-md-4 col-sm-4">
					<textarea name="enfermedad_actual" id="enfermedad_actual" rows="3" class="form-control requerido" required=""><?= $emergencia ? $emergencia->enfermedad_actual : ''; ?> </textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Diagnóstico Admisión</label>
				<div class="col-md-4 col-sm-4">
					<textarea name="diagnostico_admision" id="diagnostico_admision" rows="3" class="form-control requerido" required=""><?= $emergencia ? $emergencia->diagnostico_admision : ''; ?> </textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-md-2 col-sm-2">Médico Admisión</label>
				<div class="col-md-4 col-sm-4">
					<select name="medico_admision" id="medico_admision" class="form-control requerido" required="">
						<option value=""></option>
						<?
							$system->sql = "SELECT * from hospital.medicos";
							foreach ($system->sql() as $row) 
							{
								if($emergencia)
								{
									if($emergencia->medico_admision == $row->id)
									{
										echo '<option value="'.$row->id.'" selected>'.$row->nombre_completo.'</option>';
									}
									else
									{
										echo '<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
									}
								}
								else
								{
									echo '<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
								}
							}
						?>			
					</select>
				</div>
				<label for="" class="control-label col-md-2 col-sm-2">Médico Departamento</label>
				<div class="col-md-4 col-sm-4">
					<select name="medico_departamento" id="medico_departamento" class="form-control requerido" required="">
					<option value=""></option>
					<?
						$system->sql = "SELECT * from hospital.medicos";
						foreach ($system->sql() as $row) 
						{
							if($emergencia)
							{
								if($emergencia->medico_departamento == $row->id)
								{
									echo '<option value="'.$row->id.'" selected>'.$row->nombre_completo.'</option>';
								}
								else
								{
									echo '<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
								}
							}
							else
							{
								echo '<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
							}
						}
					?>			
				</select>	
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2">
					<button type="button" class="btn btn-primary btn-block previous">Anterior&nbsp;<i class="fa fa-arrow-left"></i></button>
				</div>
				<div class="col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2">
					<button type="button" class="btn btn-primary btn-block next">Siguiente&nbsp;<i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<?
					$con = 0;
					$conn = 0;
					$tipo_patologia = 0;

					$system->sql = "SELECT *, 
									(SELECT nombre from emergencia.tipo_patologias where id = emergencia.patologias.tipo) as tipo_patologia 
									from emergencia.patologias ORDER BY tipo asc";
					foreach ($system->sql() as $row) 
					{
						$checked = "";

						if($con == 0)
						{
							// row para hacer una fila nueva por cada 6 checkbox

							echo '<div class="row">';
						}

						if($row->tipo !== $tipo_patologia)
						{
							$tipo_patologia = $row->tipo;
							
							if($conn > 0)
							{
								// Si es un tipo de patología nueva en el ciclo cerramos la fula y creamos otra

								echo '</div> <hr /> <div class="row">';
								$con = 0;
							}

							echo '<h4 class="text-center">'.$row->tipo_patologia.'</h4>';
						}	

						if($emergencia)
						{
							foreach (explode(',', $emergencia->patologias) as $row1) 
							{
								if($row1 == $row->id)
								{
									$checked = "checked";
								}
							}
						}

						echo '	<div class="col-md-2 col-sm-2">
									<label for="'.$row->patologia.$row->tipo.'" class="radio-inline">
										<input type="checkbox" id="'.$row->patologia.$row->tipo.'" name="patologias[]" multiple="" value="'.$row->id.'" '.$checked.' /> 
										'.$row->patologia.'
									</label>
								</div>';

						$con++;
						$conn++;

						if($con == 6)
						{
							echo '</div>';
							$con = 0;
						}

					}

					if($con > 0)
					{
						echo '</div>';
					}
				?>
				<hr />
			</div>
			<div class="form-group">
				<div class="col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2">
					<button type="button" class="btn btn-primary btn-block previous">Anterior&nbsp;<i class="fa fa-arrow-left"></i></button>
				</div>
				<div class="col-md-4 col-sm-4 col-md-offset-1 col-sm-offset-1">
					<button type="submit" class="btn btn-success btn-block" <?= $_SESSION['nivel'] == 4 ? 'disabled': ''; ?>>Guardar&nbsp;<i class="fa fa-thumbs-up"></i></button>
				</div>
			</div>
			<br />
			<div class="form-group">
				<div class="col-md-offset-5 col-sm-offset-5  col-md-4 col-sm-4">
					<a href="<?= './index.php' ?>">Regresar a la Vista de Emergencias</a>
				</div>
			</div>
		</fieldset>
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

// ========================= FIELDSETS DEL FORMULARIO ===============================================

		var current = 1,current_step,next_step,steps;
		steps = $("fieldset").length;
		
		$(".next").click(function(){

			// función para pasar al siguiente fieldset
			current_step = $(this).parent().parent().parent();
			next_step = $(this).parent().parent().parent().next();

			var valida = true

			if(current == 1)
			{
				if($('#posee_identificacion').val() == "")
				{
					alert('Debe indicar si el paciente posee identificación o no')
					$('#posee_identificacion').focus()
					return false
				}
				else
				{
					var posee_identificacion = $('#posee_identificacion').val()

					if(posee_identificacion == 1)
					{
						$(current_step).find('.requerido').each(function(e){
							if($(this).val() == "")
							{
								console.log(e.currentTarget)

								alert('Todos los campos de identificación son requeridos')
								valida = false
								return false
							}
						})

						if(valida)
						{
							current++;
							next_step.show();
							current_step.hide();				
						}
							
					}
					else
					{
						$(current_step).find('.requerido').each(function(e){
							$(this).removeAttr('required')
						})					

						if(valida)
						{
							current++;
							next_step.show();
							current_step.hide();				
						}
					}
				}
			}
			else
			{
				
				$(current_step).find('.requerido').each(function(e){
					if($(this).val() == "")
					{
						alert('Todos los campos de identificación son requeridos')
						valida = false
						return false
					}
				})

				if(valida)
				{
					current++;
					next_step.show();
					current_step.hide();				
				}
			}
			//setProgressBar(++current);
		});
		
		$(".previous").click(function(){
			current_step = $(this).parent().parent().parent();
			next_step = $(this).parent().parent().parent().prev();
			next_step.show();
			current_step.hide();
			current--;
			//setProgressBar(--current);
		});

		//setProgressBar(current);
		// Change progress bar action
		/*function setProgressBar(curStep){
		var percent = parseFloat(100 / steps) * curStep;
		percent = percent.toFixed();
		$(".progress-bar")
		  .css("width",percent+"%")
		  .html(percent+"%");   
		}*/


// =============================== ENVIO DEL FORMULARIO ======================================================

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

			current_step = $(this).parent().parent().parent();
			next_step = $(this).parent().parent().parent().prev().prev();

			next_step.show();
			current_step.hide();

			current = 1;

			valida_envio_formulario = true
		})

		$('#agregar_no').click(function(){
				window.location.href = './index.php'
		})




	})
</script>