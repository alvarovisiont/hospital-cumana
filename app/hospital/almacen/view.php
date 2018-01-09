<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';
	
	$system->table = "hospital.almacen";
	$producto = $system->find($_GET['id']);
?>
	
	<div class="row no-gutters">
		<div class="col-md-3 col-sm-3">
			<a href="./index.php" class="btn btn-default btn-block"><i class="fa fa-arrow-left">&nbsp;Volver</i></a>
		</div>
		<div class="col-md-3 col-sm-3 col-md-offset-6 col-sm-offset-6">
			<a href="./create.php?modificar=<?=$_GET['id']; ?>" class="btn btn-success btn-block"><i class="fa fa-edit">&nbsp;Modificar</i></a>
		</div>
	</div>
	<br/><br/>
	<div class="row no-gutters">
		<h3 class="text-center">Historial de Movimientos del Producto</h3>
		<br/><br/>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center">Paciente</th>
					<th class="text-center">Doctor</th>
					<th class="text-center">Cant. Suministrada</th>
					<th class="text-center">Fecha Suministrado</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?
					$system->sql = "SELECT trat.cantidad, 
									to_char(trat.fecha_aplicado, 'DD-MM-YYYY') as fecha_aplicado,
									(SELECT nombre_completo from hospital.medicos where id = trat.medico_id) as medico,
									(SELECT nombre_completo from hospital.enfermeria where id = trat.enfermera_id) as enfermera,
									(SELECT nombre_completo from emergencia.ingreso_emergencia where id = trat.emergencia_id) as paciente
									from emergencia.tratamientos as trat where trat.almacen_id = $_GET[id]";

					foreach ($system->sql() as $row) 
					{
						$encargado = $row->medico === '' ? $row->enfermera : $row->medico;

						echo "
							<tr>
								<td>{$row->paciente}</td>
								<td>{$encargado}</td>
								<td>{$row->cantidad}</td>
								<td>{$row->fecha_aplicado}</td>
							</tr>
						";
					}
				?>
			</tbody>
		</table>
	</div>
<?
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>

<script>
	$(function(){

	})
</script>