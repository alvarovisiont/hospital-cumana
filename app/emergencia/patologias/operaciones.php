<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;

	switch ($_REQUEST['action']) {
		case 'registrar':
			
			unset($_POST['action']);
			unset($_POST['id_modificar']);	

			$system->table = "emergencia.patologias";
			echo json_encode($system->guardar($_POST));
		break;

		case 'modificar':

			$system->table = "emergencia.patologias";
			$system->where = "id = $_POST[id_modificar]";
			
			unset($_POST['action']);
			unset($_POST['id_modificar']);	

			echo json_encode($system->modificar($_POST));
		break;

		case 'eliminar':
			$system->table = "emergencia.patologias";
			$system->where = "id = $_GET[id]";

			echo json_encode($system->eliminar());
		break;
		
		default:
			# code...
			break;
	}
?>