<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$system->table = "emergencia.ingreso_emergencia";
	$total = $system->count();
?>
	<div class="info-box">
	  <!-- Apply any bg-* class to to the icon to color it -->
	  	<span class="info-box-icon bg-orange"><i class="fa fa-star-o"></i></span>
	  	<div class="info-box-content">
		    <span class="info-box-text">Total Emergencias</span>
	    	<span class="info-box-number" id="total_registros"><?= $total; ?></span>
	    	<br>
	  	</div><!-- /.info-box-content -->
	</div><!-- /.info-box -->
	<p class="alert text-center" id="aviso" style="display: none">
		<span id="texto"></span>&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>
	</p>
	<div class="box box-warning color-palette-box">
	    <div class="box-header with-border">
	      	<h2 class="box-title"><i class="fa fa-bank"></i>&nbsp;&nbsp;Emergencias Registradas</h2>
	      	<div class="pull-right">
	       		<a href="./create.php" class="btn btn-danger btn-flat btn-md pull-right">Registrar Emergencias&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
	      	</div>
	    </div>
	    <div class="box-body">
	    	<ul class="nav nav-pills nav-justified">
		      	<li class="active"><a href="#con_cedula" data-toggle="pill">Pacientes con Identificación</a></li>
		      	<li><a href="#sin_cedula" data-toggle="pill">Pacientes sin Identificación</a></li>     
		    </ul>
		    <div class="tab-content">
				<div class="tab-pane fade in active" id="con_cedula" role="tabpanel">
					<br />
				    	<table class="table table-hover table-bordered">
				    		<thead>
				    			<tr>
				    				<th class="text-center">#</th>
				    				<th class="text-center">Nombre Paciente</th>
				    				<th class="text-center">Cédula</th>
				    				<th class="text-center">Teléfono</th>
				    				<th class="text-center">Fecha Ingreso</th>
				    				<th class="text-center">Fecha Egreso</th>
				    				<? if($_SESSION['nivel'] !== 4)
				    				{
				    					echo '<th class="text-center">Acción</th>';
				    				}
				    				?>
				    			</tr>
				    		</thead>
				    		<tbody class="text-center">
				    			<?
				    				$con  = 1;
				    				$system->sql = "SELECT ie.*, 
				    								to_char(ie.created_at, 'DD-MM-YYYY HH:MM:SS') as ingreso,
				    								to_char(se.fecha_salida, 'DD-MM-YYYY HH:MM:SS') as egreso
				    								from emergencia.ingreso_emergencia as ie
				    								LEFT OUTER JOIN emergencia.salida_emergencia as se ON ie.id = se.emergencia_id
				    								where posee_identificacion < 2";
				    				foreach ($system->sql() as $row) 
				    				{
				    					$fila = "";
				    					$class = "";

				    					if(!$row->egreso)
				    					{
				    						$class = "fondo_rojo";
				    					}

				    					
				    					if($_SESSION['nivel'] !== 4)
				    					{	
				    						$boton = '<a href="./view.php?id='.$row->id.'" class="letras_medianas" title="Ficha del Paciente"><i class="fa fa-search"></i></a>
				    							&nbsp;
				    							<a href="#" class="letras_medianas eliminar" data-eliminar="'.$row->id.'" title="eliminar"><i class="fa fa-trash"></i></a>';

				    						$fila = '<td>'.$boton.'</td>';
				    					}

				    					echo "
											<tr>
												<td class='{$class}'>{$con}</td>
												<td>{$row->nombre_completo}</td>
												<td>{$row->cedula}</td>
												<td>{$row->telefono}</td>
												<td>{$row->ingreso}</td>
												<td>{$row->egreso}</td>
												{$fila}
											</tr>
				    					";

				    					$con++;
				    				}
				    			?>
				    		</tbody>
				    	</table>
				</div>
				<div class="tab-pane" id="sin_cedula" role="tabpanel">
					<br />
					<table class="table table-hover table-bordered">
				    		<thead>
				    			<tr>
				    				<th class="text-center">#</th>
				    				<th class="text-center">Servicio</th>
				    				<th class="text-center">Fecha Ingreso</th>
				    				<th class="text-center">Fecha Egreso</th>
				    				<? if($_SESSION['nivel'] !== 4)
				    				{
				    					echo '<th class="text-center">Acción</th>';
				    				}
				    				?>
				    			</tr>
				    		</thead>
				    		<tbody class="text-center">
				    			<?
				    				$con  = 1;
				    				$system->sql = "SELECT ie.*, 
				    								to_char(ie.created_at, 'DD-MM-YYYY HH:MM:SS') as ingreso,
				    								to_char(se.fecha_salida, 'DD-MM-YYYY HH:MM:SS') as egreso
				    								from emergencia.ingreso_emergencia as ie
				    								LEFT OUTER JOIN emergencia.salida_emergencia as se ON ie.id = se.emergencia_id
				    								where posee_identificacion > 1";
				    				foreach ($system->sql() as $row) 
				    				{
				    					$fila = "";
				    					$class = "";

				    					if(!$row->egreso)
				    					{
				    						$class = "fondo_rojo";
				    					}

				    					
				    					if($_SESSION['nivel'] !== 4)
				    					{	
				    						$boton = '<a href="./view.php?id='.$row->id.'" class="letras_medianas" title="Ficha del Paciente"><i class="fa fa-search"></i></a>
				    							&nbsp;
				    							<a href="#" class="letras_medianas eliminar" data-eliminar="'.$row->id.'" title="eliminar"><i class="fa fa-trash"></i></a>';

				    						$fila = '<td>'.$boton.'</td>';
				    					}

				    					echo "
											<tr>
												<td class='{$class}'>{$con}</td>
												<td>{$row->servicio}</td>
												<td>{$row->ingreso}</td>
												<td>{$row->egreso}</td>
												{$fila}
											</tr>
				    					";

				    					$con++;
				    				}
				    			?>
				    		</tbody>
				    	</table>
				</div>
			</div>
	    </div>
	</div>
<?
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>
<script>
	$(function(){
		$('.table').dataTable({
			language: {url: '<?= $_SESSION["base_url1"]."/json/esp.json" ?>'},
		})

		$('.eliminar').click(function(e){
			e.preventDefault()
			var id = $(this).data().eliminar,
					tr = $(this).parent().parent(),
					total = parseInt($('#total_registros').text()) - 1,
					agree = confirm('Esta seguro que desea eliminar este Registro?')
			if(agree)
			{
				$.getJSON('./operaciones.php',{id: id, action: 'eliminar'}, function(data){

					if(data.r)
					{
						// Si se elimino con éxito
						tr.remove()
						$('#total_registros').text(total)
						$('#aviso').children('#texto').empty().text('Registro eliminado con éxito')
						$('#aviso').removeClass('alert-danger').addClass('alert-success')
						
						$('#aviso').show('slow/400/fast', function(){
							setTimeout(function(){
								$('#aviso').hide('slow/400/fast')
							},2000)
						})
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