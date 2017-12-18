<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$system->table = "hospital.empleados";
	$total = $system->count();
?>
	<div class="info-box">
	  <!-- Apply any bg-* class to to the icon to color it -->
	  	<span class="info-box-icon bg-orange"><i class="fa fa-star-o"></i></span>
	  	<div class="info-box-content">
		    <span class="info-box-text">Total Empleados </span>
	    	<span class="info-box-number" id="total_registros"><?= $total; ?></span>
	    	<br>
	  	</div><!-- /.info-box-content -->
	</div><!-- /.info-box -->
	<p class="alert text-center" id="aviso" style="display: none">
		<span id="texto"></span>&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>
	</p>
	<div class="box box-warning color-palette-box">
	    <div class="box-header with-border">
	      	<h2 class="box-title"><i class="fa fa-users"></i>&nbsp;&nbsp;Personal Registrados</h2>
	      	<div class="pull-right">
	       		<a href="./create.php" class="btn btn-danger btn-flat btn-md pull-right">Registrar Empleados&nbsp;&nbsp;<i class="fa fa-pencil"></i><i class="fa fa-plus"></i></a>
	      	</div>
	    </div>
	    <div class="box-body">
	    	<table class="table table-hover table-bordered">
	    		<thead>
	    			<tr>
	    				<th class="text-center">Nombre Completo</th>
	    				<th class="text-center">Cédula</th>
	    				<th class="text-center">Teléfono</th>
	    				<th class="text-center">Fecha Nacimiento</th>
	    				<th class="text-center">Turno</th>
	    				<th class="text-center">Cargo</th>
	    				<? if($_SESSION['nivel'] !== 4)
	    				{
	    					echo '<th class="text-center">Acción</th>';
	    				}
	    				?>
	    			</tr>
	    		</thead>
	    		<tbody class="text-center">
	    			<?
	    				$system->sql = "SELECT *, 
	    								(SELECT turno from hospital.turnos where id = hospital.empleados.turno) as turno,
	    								(SELECT cargo from hospital.cargo_empleado where id = hospital.empleados.cargo_empleado_id) as cargo,
	    								to_char(hospital.empleados.fecha_nacimiento, 'DD-MM-YYYY') as fecha_nacimiento
	    								from hospital.empleados";
	    				foreach ($system->sql() as $row) 
	    				{
	    					$fila  = "";
	    					$turno = "<span class='badge alert-success'>".$row->turno."</span>";

	    					if($_SESSION['nivel'] !== 4)
	    					{
	    						$boton = '<a href="./create.php?modificar='.$row->id.'" class="letras_medianas" title="ver detalles"><i class="fa fa-edit"></i></a>
	    							&nbsp;
	    							<a href="#" class="letras_medianas eliminar" data-eliminar="'.$row->id.'" title="eliminar"><i class="fa fa-trash"></i></a>';

	    						$fila = '<td>'.$boton.'</td>';
	    					}

	    					echo "
								<tr>
									<td>{$row->nombre_completo}</td>
									<td>{$row->cedula}</td>
									<td>{$row->telefono}</td>
									<td>{$row->fecha_nacimiento}</td>
									<td>{$turno}</td>
									<td>{$row->cargo}</td>
									{$fila}
								</tr>
	    					";
	    				}
	    			?>
	    		</tbody>
	    	</table>
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