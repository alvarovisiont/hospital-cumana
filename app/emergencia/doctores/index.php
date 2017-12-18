<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$system->sql = "SELECT DISTINCT count(medico_admision) as total_medicos from emergencia.ingreso_emergencia";
	$total       = $system->sql()[0]->total_medicos;
?>
	<div class="info-box">
	  <!-- Apply any bg-* class to to the icon to color it -->
	  	<span class="info-box-icon bg-orange"><i class="fa fa-star-o"></i></span>
	  	<div class="info-box-content">
		    <span class="info-box-text">Total Doctores en Emergencia</span>
	    	<span class="info-box-number" id="total_registros"><?= $total; ?></span>
	    	<br>
	  	</div><!-- /.info-box-content -->
	</div><!-- /.info-box -->
	<p class="alert text-center" id="aviso" style="display: none">
		<span id="texto"></span>&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>
	</p>
	<div class="box box-warning color-palette-box">
	    <div class="box-header with-border">
	      	<h2 class="box-title"><i class="fa fa-user-md"></i>&nbsp;&nbsp;Doctores en Emergencia con Pacientes por ver</h2>
	    </div>
	    <div class="box-body">
	    	<table class="table table-hover table-bordered">
	    		<thead>
	    			<tr>
	    				<th class="text-center">Nombre Completo</th>
	    				<th class="text-center">Cédula</th>
	    				<th class="text-center">Cantidad de Pacientes</th>
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
	    				$system->sql = "SELECT me.id, me.nombre_completo,me.cedula, count(*) as total_pacientes
	    								from emergencia.ingreso_emergencia as ie
	    								INNER JOIN hospital.medicos as me ON me.id = ie.medico_admision
	    								WHERE ie.id NOT IN(SELECT emergencia_id from emergencia.salida_emergencia)
	    								GROUP BY me.nombre_completo, me.cedula,me.id";

	    				foreach ($system->sql() as $row) 
	    				{
	    					$fila = "";
	    					
	    					if($_SESSION['nivel'] !== 4)
	    					{	
	    						$boton = '<a href="#modal_emergencia" data-toggle="modal" data-doctor="'.$row->id.'" class="letras_medianas" title="Ficha del Paciente"><i class="fa fa-search"></i></a>';

	    						$fila = '<td>'.$boton.'</td>';
	    					}

	    					echo "
								<tr>
									<td>{$row->nombre_completo}</td>
									<td>{$row->cedula}</td>
									<td>{$row->total_pacientes}</td>
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

    <div id="modal_emergencia" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                	<table class="table table-hover table-bordered" id="tabla">
			    		<thead>
			    			<tr>
			    				<th class="text-center">Nombre Completo</th>
			    				<th class="text-center">Cédula</th>
			    				<th class="text-center">Teléfono</th>
			    				<th class="text-center">Fecha Ingreso</th>
			    			</tr>
			    		</thead>
			    		<tbody class="text-center">
			    			
			    		</tbody>
			    	</table>
                </div><!-- fin modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- fin modal-content -->
        </div><!-- fin modal-dialog -->
    </div> <!-- fin modal -->

<?
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>
<script>
	$(function(){
		$('.table').dataTable({
			language: {url: '<?= $_SESSION["base_url1"]."/json/esp.json" ?>'},
		})

		$('#modal_emergencia').on('show.bs.modal', function(e){
			var doctor = e.relatedTarget.dataset.doctor,
				ruta   = '<?= $_SESSION["base_url1"]."/app/emergencia/pacientes/view.php?id="?>'



			$.getJSON('./operaciones.php', {action: 'buscar_emergencias',doctor}, function(json) 
			{
				var html = ""

				$.grep(json,function(ele,index){

					var link = '<a href="'+ruta+ele.id+'">'+ele.ingreso+'</a>'

					html+= "<tr><td>"+ele.nombre_completo+"</td><td>"+ele.cedula+"</td><<td>"+ele.telefono+"</td><td>"+link+"</td>/tr>"
				})

				$('#tabla tbody').empty().html(html)
			})
		})
	})
</script>