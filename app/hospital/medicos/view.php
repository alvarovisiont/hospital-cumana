<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/partials/header.php';

	$system->table = 'hospital.medicos';
	$medico = $system->find($_GET['id']);
?>
	<h3 class="text-center">Detalles del Medico <?= $medico->nombre_completo; ?></h3>
	<p>
		<a href="./index.php" class="btn btn-default">Volver&nbsp;<i class="fa fa-arrow-left"></i></a>
		<a href="./create.php?modificar=<?=$_GET['id']; ?>" class="btn btn-success pull-right">Modificar&nbsp;<i class="fa fa-pencil"></i></a>
	</p>
<?

	include_once $_SESSION['base_url'].'/partials/footer.php';
?>