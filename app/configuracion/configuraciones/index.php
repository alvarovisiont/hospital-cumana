<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$system->table = "hospital.configuracion";
	$total = $system->count();
?>
	<p class="alert text-center" id="aviso" style="display: none">
		<span id="texto"></span>&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>
	</p>
	<div class="box box-default color-palette-box">
	    <div class="box-header with-border">
	      	<h2 class="box-title"><i class="fa fa-cog"></i>&nbsp;&nbsp;Configuración Registrada</h2>
	      	<div class="pull-right">
	      		<?
	      		if($total < 1)
	      		{
	      		?>
	      			<a href="./create.php" class="btn btn-primary btn-flat btn-md pull-right">Registrar Configuración&nbsp;&nbsp;<i class="fa fa-pencil"></i><i class="fa fa-plus"></i></a>		
	      		<?
	      		}
	      		?>
       		
	      	</div>
	    </div>
	    <div class="box-body">
	    	<table class="table table-hover table-bordered">
	    		<thead>
	    			<tr>
	    				<th class="text-center">Nombre Hospital</th>
	    				<th class="text-center">Teléfono</th>
	    				<th class="text-center">Dirección</th>
	    				<th class="text-center">Director</th>
	    				<th class="text-center">Logo</th>
	    				<? if($_SESSION['nivel'] !== 4)
	    				{
	    					echo '<th class="text-center">Acción</th>';
	    				}
	    				?>
	    			</tr>
	    		</thead>
	    		<tbody class="text-center">
	    			<?
	    				$system->sql = "SELECT * from hospital.configuracion";
	    				foreach ($system->sql() as $row) 
	    				{
	    					$fila = "";

	    					if($_SESSION['nivel'] !== 4)
	    					{	
	    						$boton = '<a href="./create.php?modificar='.$row->id.'" class="letras_medianas" title="modificar"><i class="fa fa-edit"></i></a>
	    							&nbsp;
	    							<a href="#" class="letras_medianas eliminar" data-eliminar="'.$row->id.'" title="eliminar"><i class="fa fa-trash"></i></a>';

	    						$fila = '<td>'.$boton.'</td>';
	    					}

	    					echo "
								<tr>
									<td>{$row->nombre_hospital}</td>
									<td>{$row->telefono}</td>
									<td>{$row->direccion}</td>
									<td>{$row->director}</td>
									<td><img src='".$_SESSION['base_url1']."/assets/images/images_hospital/".$row->logo."' width='80px' /></td>
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