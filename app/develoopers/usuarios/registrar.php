<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$usuario = null;
	$x = 0;
	$depars = "";
	$valida = false;

	if(isset($_GET['modificar']))
	{
		$system->table = "public.users";

		$usuario = $system->find($_GET['modificar']);

		$x = 1;
	}
?>
	<form action="#" class="form-horizontal" id="form_registrar">
		<h3 class="text-center"><span class="subrayado_rojo">Registro de Usuarios</span></h3>
		<br>
		<input type="hidden" name="action" value="<?= $usuario ? 'modificar' : 'registrar'; ?>">
		<input type="hidden" name="id_modificar" value="<?= $usuario ? $usuario->id : ''; ?>">
		<input type="hidden" name="created_at" value="<?= $usuario ? $usuario->created_at : date('Y-m-d H:i:s', strtotime('-6 hour')); ?>">
		<input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s', strtotime('-6 hour')) ?>">
		
		<ul class="nav nav-pills nav-justified">
	      <li class="active"><a href="#datos" data-toggle="pill">Datos</a></li>
	      <li><a href="#permisos" data-toggle="pill">Permisos</a></li>     
	    </ul>

    <div class="tab-content">
		  <div class="tab-pane fade in active" id="datos" role="tabpanel">
		  <br><br>
		  	<div class="form-group">
					<label for="" class="control-label col-md-2">Cédula</label>
					<div class="col-md-4">
						<input type="number" id="cedula" name="cedula" class="form-control" required="" value="<?= $usuario ? $usuario->cedula : ''; ?>">
					</div>
					<label for="" class="control-label col-md-2">Nombre Completo</label>
					<div class="col-md-4">
						<input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required="" value="<?= $usuario ? $usuario->nombre_completo : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-md-2">Teléfono</label>
					<div class="col-md-4">
						<input type="number" id="telefono" name="telefono" class="form-control" required="" value="<?= $usuario ? $usuario->telefono : ''; ?>">
					</div>
					<label for="" class="control-label col-md-2">Rol</label>
					<div class="col-md-4">
						<select name="rol_id" id="rol_id" class="form-control" required="">
							<option value=""></option>
							<?
								$system->sql = "SELECT id, nombre from public.roles";
								foreach ($system->sql() as $row) 
								{
									if($usuario)
									{
										if($usuario->rol_id == $row->id)
										{
											echo '<option value="'.$row->id.'" selected="">'.$row->nombre.'</option>';
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
				</div>
				<div class="form-group">
					<label for="" class="control-label col-md-2">Usuario</label>
					<div class="col-md-4">
						<input type="email" id="usuario" name="usuario" class="form-control" required="" value="<?= $usuario ? $usuario->usuario : ''; ?>">
					</div>
					<label for="" class="control-label col-md-2">Password</label>
					<div class="col-md-4">
						<input type="text" id="password" name="password" class="form-control" value="" <?= !$usuario ? 'required' : '' ?>>
					</div>
				</div>
		  </div>
		  
		  <? //** ==================== PERMISOS ============================== **// ?>
			<input type="hidden" id="departamentos_grabar" name="departamentos_grabar">

		  <div class="tab-pane" id="permisos" role="tabpanel">
		  	<br><br>
		  	<table class="table table-bordered table-hover">
		  		<thead>
		  			<tr>
		  				<th class="text-center">Departamento</th>
		  				<th class="text-center">Areas y Sub Areas</th>
		  			</tr>
		  		</thead>
		  		<tbody class="text-center">
			  		<?
			  			//**========================= DEPARTAMENTOS =======================
			  			$system->sql = "SELECT id, nombre from public.departamentos";
			  			$res = $system->sql();
			  			
			  			foreach ($res as $row) 
			  			{
			  		?>
			  			<tr>
			  				<td width="20%" style="border-top: 1px black solid; border-left: 1px black solid; border-right: 1px black solid;"><?= $row->nombre; ?></td>
			  				<td width="80%" style="border-top: 1px black solid; border-left: 1px black solid; border-right: 1px black solid;">
			  					<? if($usuario)
			  					{
			  						include './areas_modificar.php';
			  					}
			  					else
			  					{

			  						include './areas_registrar.php';
			  					}
			  					?>
			  				</td>
			  			</tr>
			  		<?
			  			}
			  		?>
			  	</tbody>
		  	</table>
		  </div>
		</div>

				
		<div class="form-group">
			<div class="col-md-4 col-md-offset-4">
				<button type="submit" class="btn btn-success btn-block">Guardar&nbsp;<i class="fa fa-send"></i></button>
			</div>
			<div class="col-md-offset-1 col-md-3">
				<a href="<?= './index.php' ?>">Regresar a la Vista de Usuarios</a>
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

		<div class="form-group" id="div_alerta_guardando" style="display: none">
			<p class="alert alert-info text-center">
				Guardando Configuración de Usuario, espere por favor...</i> 
			</p>
		</div>
	</form>
<?
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>
<script>
	$(function(){

		var x = "<?= $x; ?>",
				valida_envio_formulario = true

		if(x == 1)
		{
			$('#departamentos_grabar').val('<?= $depars; ?>')
		}

		$('#form_registrar').submit(function(e){
			e.preventDefault()

			if(!valida_envio_formulario)
			{
				return false
			}

			
			var tipo = $('input[name="action"]').val()

			$('#div_alerta_guardando').show('slow/400/fast')

			$.ajax({

				url: './operaciones.php',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				success: function(data)
				{
					$('#div_alerta_guardando').hide('slow/400/fast')
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

		
		$('.area_checkbox').on('click',function(){
			
			// Función que se ejecuta cuando a las areas se les clickea

			var area = $(this).val(),
					check  = $(this)

			if(check.is(':checked'))
			{

				// Si el check esta checkeado se despliega el sub_area y se valida para agregar el departamento

				$('.div_sub_'+area).show('slow/400/fast')

				var depar = check.data().departamento,
						depar_selec = $('#departamentos_grabar').val(),
						depar_array  = depar_selec.split(','),
						valida = true

				for(var i = depar_array.length; i >= 0; i--)
				{
					if(depar == depar_array[i])
					{
						valida = false
					}
				}

				if(valida)
				{
					depar_selec += depar+','
					$('#departamentos_grabar').val(depar_selec)
				}
			}
			else
			{
				// Código para validar que si todas las areas están desactivadas borrar el departamento a grabar

				var depar = check.data().departamento,
						depar_selec = $('#departamentos_grabar').val(),
						valida = true,
						depar_selec_nuevo = ""

						depar_selec = depar_selec.substring(0, depar_selec.length -1)

				var depar_array  = depar_selec.split(',')

				$('.div_sub_'+area).hide('slow/400/fast')	

				$('.area_checkbox[data-departamento="'+depar+'"]').each(function(e){
					
					if($(this).is(':checked'))
					{
						valida = false
					}
				})

				if(valida)
				{
					for(var i = depar_array.length -1; i >= 0; i--)
					{
						if(parseInt(depar) != parseInt(depar_array[i]))
						{
							depar_selec_nuevo += depar_array[i]+','
						}
						
					}
					
					$('#departamentos_grabar').val(depar_selec_nuevo)

				}

				// ** ====================== Código para validar que los hijos de esa área sean deseleccionados ============= 

				$('.div_sub_'+area).children().children().children().each(function(e){
					$(this).prop('checked',false)
				})

			}
		})

	})
</script>