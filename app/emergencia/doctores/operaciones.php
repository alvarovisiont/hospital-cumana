<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;

	switch ($_REQUEST['action']) {
		case 'buscar_emergencias':
			
			$system->sql = "SELECT id,nombre_completo,cedula,telefono,
							to_char(created_at, 'DD-MM-YYYY HH:MM:SS') as ingreso
							from emergencia.ingreso_emergencia 
							where id NOT IN(SELECT emergencia_id from emergencia.salida_emergencia)
							and medico_admision = $_GET[doctor]";
			echo json_encode($system->sql());
		break;
	}
?>