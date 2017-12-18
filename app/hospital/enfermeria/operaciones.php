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

			$_POST['fecha_nacimiento'] = date('Y-m-d',strtotime($_POST['fecha_nacimiento']));

			$system->table = "hospital.enfermeria";
			echo json_encode($system->guardar($_POST));
		break;

		case 'modificar':

			$system->table = "hospital.enfermeria";
			$system->where = "id = $_POST[id_modificar]";

			$_POST['fecha_nacimiento'] = date('Y-m-d',strtotime($_POST['fecha_nacimiento']));

			unset($_POST['action']);
			unset($_POST['id_modificar']);	

			echo json_encode($system->modificar($_POST));
		break;

		case 'eliminar':
			$system->table = "hospital.enfermeria";
			$system->where = "id = $_GET[id]";

			echo json_encode($system->eliminar());
		break;
		
		default:
			# code...
			break;
	}
?>