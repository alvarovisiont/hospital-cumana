<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$system->sql = "SELECT emer.*, emer_sa.*,
					(SELECT nombre_completo from hospital.medicos where id = emer.medico_admision) as medico_admision,
					(SELECT nombre_completo from hospital.medicos where id = emer.medico_departamento) as medico_departamento,
					(SELECT nombre_completo from hospital.medicos where id = emer_sa.jefe_departamento) as medico_jefe_departamento_salida
				 	from emergencia.ingreso_emergencia as emer 
				 	LEFT OUTER JOIN emergencia.salida_emergencia as emer_sa ON emer.id = emer_sa.emergencia_id
				 	where emer.id = $_GET[id]";

	$emergencia = $system->sql();
	$salida     = false;

	if($emergencia[0]->fecha_salida)
	{
		$salida = true;
	}

	$medicos = '<option value="0"></option>';
	$enfermeras = '<option value="0"></option>';


	$system->sql = "SELECT nombre_completo, id from hospital.medicos";
	foreach ($system->sql() as $row) 
	{
		$medicos.= '<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
	}

	$system->sql = "SELECT nombre_completo, id from hospital.enfermeria";
	foreach ($system->sql() as $row) 
	{
		$enfermeras.='<option value="'.$row->id.'">'.$row->nombre_completo.'</option>';
	}
?>
	<div class="row no-gutters">
		<h3 class="text-center"><span class="subrayado_rojo">Ficha de Emergencía</span>&nbsp;<i class="fa fa-file-text-o"></i></h3>
	</div>
	<br /><br />
	<div class="row no-gutters">
		<div class="col-md-3 col-sm-3">
			<a href="./index.php" class="btn btn-danger btn-block">Volver&nbsp;<i class="fa fa-arrow-left"></i></a>	
		</div>
		<div class="col-md-3 col-sm-3">
			<? 
			if(!$salida)
			{
			?>
				<a href="./create.php?modificar=<?=$_GET['id']; ?>" class="btn btn-danger btn-block">Modificar&nbsp;<i class="fa fa-edit"></i></a>	
			<?
			}
			?>
				
		</div>
		<div class="col-md-3 col-sm-3">
			<? 
			if(!$salida)
			{
			?>
				<a href="./salida.php?id=<?=$_GET['id']; ?>" class="btn btn-danger btn-block">Dar de Alta&nbsp;<i class="fa fa-sign-out"></i></a>	
			<?
			}
			?>
		</div>
		<div class="col-md-3 col-sm-3">
			<button type="button" class="btn btn-block btn-danger eliminar-emergencia" data-eliminar="<?= $_GET['id']; ?>">Eliminar&nbsp;<i class="fa fa-trash"></i></button>
		</div>
	</div>
	<br />
	<p class="alert text-center" id="aviso" style="display: none">
		<span id="texto"></span>&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>
	</p>
	<br /><br />
	<ul class="nav nav-pills nav-justified">
      <li class="active"><a href="#ingreso" data-toggle="pill">Ingreso</a></li>
      <li><a href="#salida" data-toggle="pill">Salida</a></li>     
      <li><a href="#piso_tratamiento" data-toggle="pill">Piso y Tratamiento</a></li>     
    </ul>
	
	<div class="tab-content">
		<div class="tab-pane fade in active" id="ingreso" role="tabpanel">
			<br />
			<table class="table table-hover table-bordered">
				<tbody class="text-center">
					<tr>
						<td colspan="4" style="border-top: 1px solid red;"><b>DATOS DEL PACIENTE</b></td>
					</tr>
					<tr>
						<td><b>Fecha Nacimiento</b></td>
						<td><b>Lugar Nacimiento</b></td>
						<td><b>Dirección Actúal</b></td>
						<td><b>Procedencia Estado</b></td>
					</tr>
					<tr>
						<td>
							<?
								if($emergencia[0]->fecha_nacimiento !== '1830-02-10')
								{
									echo date('d-m-Y',strtotime($emergencia[0]->fecha_nacimiento));
								}
							?>	
						</td>
						<td><?= $system->parse_empty($emergencia[0]->lugar_nacimiento) ?></td>
						<td><?= $system->parse_empty($emergencia[0]->direccion_actual) ?></td>
						<td><?= $emergencia[0]->procedencia_estado ?></td>
					</tr>
					<tr>
						<td>
							<b>Nacionalidad</b>
						</td>
						<td>
							<b>S.S.O u Otros</b>
						</td>
					</tr>
					<tr>
						<td><?= $system->parse_empty($emergencia[0]->nacionalidad) ?></td>
						<td><?= $system->parse_empty($emergencia[0]->sso_otros) ?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="4" style="border-top: 1px solid red;"><b>DATOS DEL PARENTESCO</b></td>
					</tr>
					<tr>
						<td><b>Nombre</b></td>
						<td><b>Parentesco</b></td>
						<td><b>Dirección</b></td>
						<td><b>Teléfono</b></td>
					</tr>
					<tr>
						<td><?= $system->parse_empty($emergencia[0]->nombre_completo_parentesco) ?></td>
						<td><?= $system->parse_empty($emergencia[0]->parentesco) ?></td>
						<td><?= $system->parse_empty($emergencia[0]->direccion_parentesco) ?></td>
						<td><?= $system->parse_empty($emergencia[0]->telefono_parentesco) ?></td>
					</tr>
					<tr>
						<td colspan="4" style="border-top: 1px solid red;"><b>DIAGNOSTICO DE ADMISIÓN</b></td>
					</tr>
					<tr>
						<td><b>Motivo</b></td>
						<td><b>Enfermedad Actual</b></td>
						<td><b>Diagnóstico Admisión</b></td>
						<td><b>Médico Admisión</b></td>
					</tr>
					<tr>
						<td><?= $emergencia[0]->motivo_admision ?></td>
						<td><?= $emergencia[0]->enfermedad_actual ?></td>
						<td><?= $emergencia[0]->diagnostico_admision ?></td>
						<td><?= $emergencia[0]->medico_admision ?></td>
					</tr>
					<tr>
						<td><b>Médico Departamento</b></td>
						<td><b></b></td>
						<td><b></b></td>
						<td><b></b></td>
					</tr>
					<tr>
						<td><?= $emergencia[0]->medico_departamento ?></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="4" style="border-top: 1px solid red;"><b>PATOLOGÍAS</b></td>
					</tr>
					<?
						$con = 0;
						foreach (explode(',', $emergencia[0]->patologias) as $row) 
						{
							if($con == 0)
							{
								echo '<tr>';
							}

							$system->sql = "SELECT patologia, 
											(SELECT nombre from emergencia.tipo_patologias where id = pato.tipo) as tipo_patologia
											from emergencia.patologias as pato where id = $row";

							$patologia = $system->sql();

							if(count($patologia) > 0)
							{
								echo '<td>'.'<b>'.$patologia[0]->tipo_patologia.'</b><br />'.$patologia[0]->patologia.'</td>';
							}

							$con++;

							if($con == 4)
							{
								echo '</tr>';
								$con = 0; 
							}

							
						}

						if($con > 0)
						{
							for ($i= $con; $i < 5; $i++) 
							{ 
								echo '<td></td>';
							}

							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="salida" role="tabpanel">
			<br />
			<table class="table table-hover table-bordered">
				<tbody class="text-center">
					<tr>
						<td colspan="4" style="border-top: 1px solid red;"><b>ÚLTIMAS NOTAS</b></td>
					</tr>
					<tr>
						<td><b>Motivo de Salida</b></td>
						<td><b>Otra Causa (Explicación)</b></td>
						<td><b>Diagnóstico Clínico Final</b></td>
						<td><b>Intervención o Tratamiento</b></td>
					</tr>
					<tr>
						<td><?= $emergencia[0]->motivo ?></td>
						<td><?= $system->parse_empty($emergencia[0]->salida_otras_causas_explicacion) ?></td>
						<td><?= $emergencia[0]->diagnostico_clinico_final ?></td>
						<td><?= $emergencia[0]->intervencion_tratamiento ?></td>
					</tr>
					<tr>
						<td><b>Diagnóstico Anatomopatológico</b></td>
						<td><b>Biopsía / Alitopsía</b></td>
						<td><b></b></td>
						<td><b></b></td>
					</tr>
					<tr>
						<td><?= $emergencia[0]->diagnostico_anatomapatologico ?></td>
						<td><?= $emergencia[0]->opciones_anatomapatologico ?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="4" style="border-top: 1px solid red;"><b>DATOS DE ADMINISTRACIÓN</b></td>
					</tr>
					<tr>
						<td><b>Jefe Departamento</b></td>
						<td><b>Fecha Salida</b></td>
						<td><b></b></td>
						<td><b></b></td>
					</tr>
					<tr>
						<td><?= $emergencia[0]->medico_jefe_departamento_salida ?></td>
						<td><?= $emergencia[0]->fecha_salida ? date('d-m-Y H:i:s',strtotime($emergencia[0]->fecha_salida)) : '' ?></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="piso_tratamiento" role="tabpanel">
			<br />
			<div class="row">
				<div class="col-md-6 col-sm-6 text-center">
					<?
					if(!$salida)
					{
					?>
						<a href="#modal_tratamiento" data-toggle="modal">Agregar Tratamiento</a>
					<?
					}
					?>
				</div>
				<div class="col-md-6 col-sm-6 text-center">
					<?
					if(!$salida)
					{
					?>
						<a href="#modal_piso" data-toggle="modal">Subir a Piso</a>
					<?
					}
					?>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-6 col-sm-6 text-center">
					<table class="table table-hover table-striped" id="tabla_tratamientos">
						<tr>
							<th class="text-center">Producto</th>
							<th class="text-center">Suminstrado Por</th>
							<th class="text-center">Fecha</th>
							<th class="text-center">Eliminar</th>
						</tr>
						<tbody class="text-center">
							<?
								$system->sql = "
									SELECT tra.cantidad, tra.id,tra.almacen_id, 
									to_char(tra.fecha_aplicado,'DD-MM-YYYY') as fecha_aplicado,

									(SELECT producto from hospital.almacen where id = tra.almacen_id)
									as producto,
									(SELECT nombre_completo from hospital.enfermeria where id = tra.enfermera_id)
									as enfermera,
									(SELECT nombre_completo from hospital.medicos where id = tra.medico_id)
									as medico
									from emergencia.tratamientos as tra where emergencia_id = $_GET[id]
												";
								
								foreach ($system->sql() as $row) 
								{
									$suministrado = "";
									$eliminar = "";
									if(!$salida)
									{
										$eliminar     = '<a href="#" data-id="'.$row->id.'" data-cantidad="'.$row->cantidad.'" data-almacen="'.$row->almacen_id.'" class="eliminar"><i class="fa fa-trash"></i></a>';
									}
										
									
									if($row->medico === "")
									{
										$suministrado = '<b>Enfermero/a</b><br />'.$row->enfermera;
									}
									else
									{
										$suministrado = '<b>Médico</b><br />'.$row->medico;
									}

									echo "
											<tr>
												<td>{$row->producto}</td>
												<td>{$suministrado}</td>
												<td>{$row->fecha_aplicado}</td>
												<td>{$eliminar}</td>
											</tr>";		
								}
							?>	
						</tbody>
					</table>
				</div>
				<div class="col-md-6 col-sm-6 text-center">
					<table class="table table-hover table-striped" id="tabla_tratamientos">
						<tr>
							<th class="text-center">Departamento</th>
							<th class="text-center">Habitación</th>
							<th class="text-center">Fecha</th>
							<th class="text-center">Atendido por:</th>
						</tr>
						<tbody class="text-center">
							<?
								$system->sql = "
									SELECT paci.id, habi.numero_habitacion, habi.piso,
									to_char(paci.fecha_subido,'DD-MM-YYYY') as fecha_subido,
									(SELECT nombre_completo from hospital.enfermeria where id = paci.enfermera_id)
									as enfermera,
									(SELECT nombre_completo from hospital.medicos where id = paci.medico_id)
									as medico,
									(SELECT nombre from hospital.departamentos where id = paci.departamento_id)
									as departamento
									from hospital.pacientes as paci 
									INNER JOIN hospital.habitaciones as habi ON habi.id = paci.habitacion_id
									where emergencia_id = $_GET[id]
												";
								
								foreach ($system->sql() as $row) 
								{
									$atendido = "";
									$atendido = '<b>Médico</b><br />'.$row->medico.'<br /><b>Enfermero/a</b><br />'.$row->enfermera;

									$habitacion = "hab: ".$row->numero_habitacion."/ piso: ".$row->piso;
									
									

									echo "
											<tr>
												<td>{$row->departamento}</td>
												<td>{$habitacion}</td>
												<td>{$row->fecha_subido}</td>
												<td>{$atendido}</td>
											</tr>";		
								}
							?>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<!-- ================================= MODALES ======================================= -->

	<div id="modal_tratamiento" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header login-header">
	                <button type="button" class="close" data-dismiss="modal">×</button>
	                <h4 class="modal-title">Agregar Tratamiento</h4>
	            </div>
	            <form action="" id="form_tratamiento" class="form-horizontal">
	            	<input type="hidden" name="action" value="guardar_tratamiento">
	            	<input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">
					<input type="hidden" name="update_at" value="<?= date('Y-m-d H:i:s', strtotime('-5 hour')); ?>">
					<input type="hidden" name="emergencia_id" value="<?= $_GET['id']; ?>">
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Tratamiento</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="almacen_id" id="almacen_id" required="" style="width: 100%">
	            				<?
	            					$system->sql = "SELECT producto, id, cantidad from hospital.almacen";
	            					foreach ($system->sql() as $row) 
	            					{
	            						echo '<option value="'.$row->id.'" cantidad="'.$row->cantidad.'">'.$row->producto.'</option>';
	            					}
	            				?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Cantidad</label>
	            		<div class="col-md-10 col-sm-10">
	            			<input type="number" name="cantidad" id="cantidad" class="form-control" required="">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-3 col-sm-3">Suministrado Por:</label>
	            		<div class="col-md-2 col-sm-2">
	            			<label for="medico" class="radio-inline">
	            				<input type="radio" id="medico" name="suministrado_por" value="medico">
								Medico
	            			</label>
	            		</div>
	            		<div class="col-md-2 col-sm-2">
	            			<label for="enfermera" class="radio-inline">
	            				<input type="radio" id="enfermera" name="suministrado_por" value="enfermera">
								Enfermera
	            			</label>
	            		</div>
	            	</div>
	            	<div class="form-group" id="div_medico" style="display: none">
	            		<label for="" class="control-label col-md-2 col-sm-2">Medico:</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="medico_id" id="medico_id" required="" class="select2" style="width: 100%">
	            				<?= $medicos; ?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group" id="div_enfermera" style="display: none">
	            		<label for="" class="control-label col-md-2 col-sm-2">Enfermera/o:</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="enfermera_id" id="enfermera_id" required="" class="select2" style="width: 100%">
	            				<?= $enfermeras; ?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Fecha Aplicado</label>
	            		<div class="col-md-10 col-sm-10">
	            			<input type="text" name="fecha_aplicado" class="form-control date-picker" required="">
	            		</div>
	            	</div>
	            </div><!-- fin modal-body -->
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-success">Grabar</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	            </div>
	        	</form>
	        </div><!-- fin modal-content -->
	    </div><!-- fin modal-dialog -->
	</div> <!-- fin modal -->
		

	<div id="modal_piso" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header login-header">
	                <button type="button" class="close" data-dismiss="modal">×</button>
	                <h4 class="modal-title">Registrar Movimiento de Paciente en Habitaciones del Hospital</h4>
	            </div>
	            <form action="" id="form_subida_piso" class="form-horizontal">
	            	<input type="hidden" name="action" value="guardar_subida_piso">
	            	<input type="hidden" name="alta" value="0">
	            	<input type="hidden" name="cita_id" value="0">
	            	<input type="hidden" name="emergencia_id" value="<?= $_GET['id']; ?>">
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Departamento:</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="departamento_id" id="departamento_id" class="form-control" required="">
	            				<option value=""></option>
	            				<?
	            					$system->sql = "SELECT id, nombre from hospital.departamentos";
	            					foreach ($system->sql() as $row) 
	            					{
	            						echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';
	            					}
	            				?>
	            			</select>
	            		</div>
	            	</div>
					<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Habitaciones:</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="habitacion_id" id="habitacion_id" class="form-control" required="">
	            				<option value=""></option>
	            				
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Medico:</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="medico_id" id="medico_id" required="" class="select2" style="width: 100%">
	            				<?= $medicos; ?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Enfermera/o:</label>
	            		<div class="col-md-10 col-sm-10">
	            			<select name="enfermera_id" id="enfermera_id" required="" class="select2" style="width: 100%">
	            				<?= $enfermeras; ?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label for="" class="control-label col-md-2 col-sm-2">Fecha Subido</label>
	            		<div class="col-md-10 col-sm-10">
	            			<input type="text" name="fecha_subido" class="form-control date-picker" required="">
	            		</div>
	            	</div>
	            </div><!-- fin modal-body -->
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-success">Grabar</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	            </div>
	        	</form>
	        </div><!-- fin modal-content -->
	    </div><!-- fin modal-dialog -->
	</div> <!-- fin modal -->
<?

	include_once $_SESSION['base_url'].'/partials/footer.php';
?>

<link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/select2.css'; ?>">
<script src="<?= $_SESSION['base_url1'].'/assets/js/select2.js' ?>"></script>

<script>
	
	$(function(){
		$('.select2').select2()

		$('#form_tratamiento').submit(function(e){
			e.preventDefault()

			var tratamiento = $('#almacen_id'),
				option_tratamiento = tratamiento.children('[value="'+tratamiento.val()+'"]'),
				cantidad    = $('#cantidad').val()


			if(cantidad > option_tratamiento.attr('cantidad'))
			{
				alert('La cantidad suministrada es mayor a la que hay en el inventario')
			}
			else
			{
				$.ajax({
						url: './operaciones.php',
						type: 'POST',
						dataType: 'JSON',
						data: $(this).serialize(),
					})
					.done(function(data) {
						if(data.r)
						{
							window.location.reload()
						}
						
					})
			}
		});

		$('input[name="suministrado_por"]').click(function(){
			var value = $(this).val()

			if(value == 'medico')
			{
				$('#div_medico').show('slow/400/fast')
				$('#div_enfermera').hide('slow/400/fast')
				$('#medico_id').attr('required',true)
				$('#enfermera_id').attr('required',false)
			}
			else
			{
				$('#div_enfermera').show('slow/400/fast')
				$('#div_medico').hide('slow/400/fast')
				$('#medico_id').attr('required',false)
				$('#enfermera_id').attr('required',true)	
			}
		})

		$('#tabla_tratamientos tbody').on('click','tr td .eliminar',function(e){
			var id = e.currentTarget.dataset.id,
				cantidad = e.currentTarget.dataset.cantidad,
				almacen  = e.currentTarget.dataset.almacen,
				agree = confirm('Esta seguro de querer borrar este registro?')
				tr = $(this).parent().parent()

			$.ajax({
				url: './operaciones.php',
				type: 'POST',
				dataType: 'JSON',
				data: {action: 'eliminar_tratamiento', id,cantidad,almacen},
			})
			.done(function(data) {
				if(data.r)
				{
					window.location.reload()
				}
			})

		})

		$('#departamento_id').change(function(event) {
			var value = $(this).val()

			$.getJSON('./operaciones.php', {action: 'buscar_habitacion', value}, function(json) {
				
				var html = '<option></option>'

				$.grep(json,function(ele,index){

					html+= '<option value="'+ele.id+'"> hab: '+ele.numero_habitacion+'/ piso: '+ele.piso+'</option>'
				})

				$('#habitacion_id').html(html)
			});
		});

		$('#form_subida_piso').submit(function(e) {
			e.preventDefault()

			$.ajax({
						url: './operaciones.php',
						type: 'POST',
						dataType: 'JSON',
						data: $(this).serialize(),
					})
					.done(function(data) {
						if(data.r)
						{
							window.location.reload()
						}
						
					})
		});

		$('.eliminar-emergencia').click(function(e){
			e.preventDefault()
			var id = $(this).data().eliminar,
					agree = confirm('Esta seguro que desea eliminar este Registro?')

			if(agree)
			{
				$.getJSON('./operaciones.php',{id: id, action: 'eliminar_emergencia'}, function(data){

					if(data.r)
					{
						// Si se elimino con éxito
						window.location.href = "./index";
					}
					else
					{
						// Si fallo al eliminar
						$('#aviso').children('#texto').empty().text('No se puede eliminar el Registro porque esta asociado con otros registros')
						$('#aviso').removeClass('alert-success').addClass('alert-danger')
						
						$('#aviso').show('slow/400/fast', function(){
							setTimeout(function(){
								$('#aviso').hide('slow/400/fast')
							},2000)
						})	
					}

				})	
			}
		})
	})
</script>