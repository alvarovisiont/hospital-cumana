<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';
	
	$system->table = "public.sub_areas";
	$total_areas = $system->count();

?>	
		
	<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$total_areas?></h3>

          <p>Sub Areas</p>
        </div>
        <div class="icon">
          <i class="fa fa-bank"></i>
        </div>
      </div>
    </div>
  </div>

	<p class="alert text-center" id="aviso" style="display: none">
			<span id="texto"></span>&nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i>
	</p>

	<div class="box box-warning color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-bank"></i>Sub-Areas Registradas</h3>
      <div class="pull-right">
        <a href="./registrar.php" class="btn btn-success btn-flat btn-md pull-right">Registrar Sub-Area&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
      </div>
    </div>
    <div class="box-body">
			<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th class="text-center">Departamento</th>
						<th class="text-center">Area</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Descripción</th>
						<th class="text-center">Archivo</th>
						<th class="text-center">Fecha de Creación</th>
						<th class="text-center">Acción</th>
					</tr>
				</thead>

				<tbody class="text-center">
					<?
						$system->sql = "SELECT sub.id, sub.archivo,sub.nombre,
																		sub.descripcion,
																		to_char(sub.created_at, 'dd-Mon-YYYY,HH24:MM:SS') as created_at1,
																	 area.nombre as areaa, depar.nombre as departamento
														from public.sub_areas as sub
														INNER JOIN public.areas as area ON area.id = sub.area_id
														INNER JOIN public.departamentos as depar ON area.departamento_id = depar.id";
						foreach ($system->sql() as $row) 
						{

							$botones = '<a href="./registrar.php?modificar='.$row->id.'" class="letras_medianas" title="Editar"><i class="fa fa-edit"></i></a>&nbsp;
													<a href="#" class="eliminar letras_medianas" data-eliminar="'.$row->id.'" title="Eliminar"><i class="fa fa-trash"></i></a>';
							echo "
									<tr>
										<td>{$row->departamento}</td>
										<td>{$row->areaa}</td>
										<td>{$row->nombre}</td>
										<td>{$row->descripcion}</td>
										<td>{$row->archivo}</td>
										<td>".$row->created_at1."</td>
										<td>".$botones."</td>
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
			order: [0,'asc', 1,'asc']
		})

		$('.eliminar').click(function(e){
			e.preventDefault()
			var id = $(this).data().eliminar,
					tr = $(this).parent().parent(),
					agree = confirm('Esta seguro que desea eliminar este Sub-Area?')
			if(agree)
			{
				$.getJSON('./operaciones.php',{id: id, action: 'eliminar'}, function(data){

					if(data.r)
					{
						// Si se elimino con éxito
						tr.remove()
						
						$('#aviso').children('#texto').empty().text('Sub-Area eliminada con éxito')
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
						
						$('#aviso').children('#texto').empty().text('No se puede eliminar el Sub-Area porque esta asociado con otros registros')
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
